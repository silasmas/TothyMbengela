<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Order;
use App\Models\PartnerCommitment;
use App\Models\User;
use App\Services\FlexPayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationPaymentController extends Controller
{
    public function __construct(
        protected FlexPayService $flexPayService
    ) {}

    public function initDon(Request $request): JsonResponse
    {
        if (! config('services.flexpay.enabled')) {
            return response()->json([
                'success' => false,
                'message' => 'Le paiement en ligne n\'est pas configuré. Utilisez le formulaire classique ou contactez le ministère.',
            ], 503);
        }

        $validated = $request->validate([
            'montant' => 'required|numeric|min:1',
            'nom' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'donor_phone' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:2000',
            'currency' => 'nullable|string|in:CDF',
            'frequency' => 'nullable|string|in:once,monthly',
            'is_anonymous' => 'nullable|boolean',
        ]);

        $currency = $validated['currency'] ?? 'CDF';
        $reference = generateUniqueReference('DON', Donation::class);

        $donation = Donation::create([
            'reference' => $reference,
            'donor_name' => $validated['nom'] ?? null,
            'donor_email' => $validated['email'] ?? null,
            'donor_phone' => $validated['donor_phone'] ?? null,
            'amount' => $validated['montant'],
            'currency' => $currency,
            'frequency' => $validated['frequency'] ?? 'once',
            'message' => $validated['message'] ?? null,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'payment_provider' => 'flexpay',
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'id' => $donation->id,
            'reference' => $donation->reference,
            'total' => (float) $donation->amount,
            'currency' => $donation->currency,
        ]);
    }

    /**
     * Initialise un engagement partenaire (crée / connecte le compte si invité).
     *
     * @param  Request  $request  Montant, devise, message, name?, email?
     * @return JsonResponse
     */
    public function initPartner(Request $request): JsonResponse
    {
        if (! config('services.flexpay.enabled')) {
            return response()->json([
                'success' => false,
                'message' => 'Le paiement en ligne n\'est pas configuré.',
            ], 503);
        }

        $rules = [
            'monthly_amount' => 'required|numeric|min:1',
            'currency' => 'required|string|in:USD,EUR,CDF',
            'message' => 'nullable|string|max:2000',
        ];

        if (! Auth::check()) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255';
        }

        $validated = $request->validate($rules);

        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = User::findOrRegisterByEmail(
                (string) $validated['email'],
                (string) $validated['name'],
            );
            Auth::login($user, true);
        }

        $reference = generateUniqueReference('PARTNER', PartnerCommitment::class);

        $commitment = PartnerCommitment::create([
            'user_id' => $user->id,
            'reference' => $reference,
            'payment_reference' => $reference,
            'monthly_amount' => $validated['monthly_amount'],
            'currency' => $validated['currency'],
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'id' => $commitment->id,
            'reference' => $commitment->reference,
            'total' => (float) $commitment->monthly_amount,
            'currency' => $commitment->currency,
        ]);
    }

    public function processPayment(Request $request): JsonResponse
    {
        $request->validate([
            'reference' => 'required|string',
            'channel' => 'required|in:mobile_money,card',
            'phone' => 'required_if:channel,mobile_money|nullable|string|max:30',
        ]);

        $donation = Donation::where('reference', $request->reference)->first();
        $partner = $donation ? null : PartnerCommitment::where('reference', $request->reference)->with('user')->first();
        $shopOrder = ($donation || $partner) ? null : Order::where('reference', $request->reference)->with('user')->first();

        if (! $donation && ! $partner && ! $shopOrder) {
            return response()->json(['reponse' => false, 'message' => 'Transaction introuvable'], 404);
        }

        if ($shopOrder && ! $this->canPayShopOrder($request, $shopOrder)) {
            return response()->json(['reponse' => false, 'message' => 'Commande non autorisée'], 403);
        }

        $order = $donation ?? $partner ?? $shopOrder;
        if ($donation) {
            $amount = (float) $donation->amount;
            $currency = $donation->currency;
            $label = 'Don — '.($donation->donor_name ?: 'Bienfaiteur');
            $flexType = 'don';
        } elseif ($partner) {
            $amount = (float) $partner->monthly_amount;
            $currency = $partner->currency;
            $label = 'Partenariat — '.($partner->user?->name ?? 'Partenaire');
            $flexType = 'partner';
        } else {
            $amount = (float) $shopOrder->amount_due;
            $currency = $shopOrder->currency;
            $label = 'Commande boutique — '.($shopOrder->user?->name ?? $shopOrder->guest_email ?? 'Client');
            $flexType = 'shop';
        }

        if ($request->channel === 'mobile_money') {
            $data = [
                'merchant' => config('services.flexpay.merchant'),
                'type' => '1',
                'phone' => $request->phone,
                'reference' => $order->reference,
                'amount' => $amount,
                'currency' => $currency,
                'callbackUrl' => url('/payment/callback'),
            ];

            return response()->json(initRequeteFlexPayMobile($data, $order));
        }

        try {
            $retour = $this->flexPayService->initiatePayment(
                $amount,
                $currency,
                $order->reference,
                $label,
                $flexType
            );
        } catch (\Throwable $e) {
            return response()->json(['reponse' => false, 'message' => $e->getMessage()], 400);
        }

        if ($retour['rep']) {
            $cardPayload = [
                'external_payment_id' => $retour['orderNumber'],
                'status' => 'processing',
            ];
            if ($shopOrder) {
                $cardPayload['payment_status'] = 'processing';
            }
            $order->update($cardPayload);

            return response()->json([
                'reponse' => true,
                'redirect_url' => $retour['url'],
            ]);
        }

        return response()->json([
            'reponse' => false,
            'message' => $retour['message'] ?? 'Échec',
        ], 400);
    }

    public function checkTransactionStatus(Request $request): JsonResponse
    {
        $reference = $request->input('reference');
        $url = 'https://backend.flexpay.cd/api/rest/v1/check/'.urlencode($reference);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.config('services.flexpay.token'),
        ]);
        $curlResponse = curl_exec($curl);
        $curlError = curl_errno($curl);
        curl_close($curl);

        if ($curlError) {
            return response()->json(['reponse' => false, 'message' => 'Erreur du service de paiement'], 500);
        }

        $jsonRes = json_decode($curlResponse, true);
        $transactionData = $jsonRes['transaction'] ?? [];
        $ref = $transactionData['reference'] ?? $reference;

        $donation = Donation::where('reference', $ref)->first();
        $partner = $donation ? null : PartnerCommitment::where('reference', $ref)->first();
        $shopOrder = ($donation || $partner) ? null : Order::where('reference', $ref)->first();
        $order = $donation ?? $partner ?? $shopOrder;

        if (! $order) {
            return response()->json(['reponse' => false, 'message' => 'Transaction introuvable'], 404);
        }

        $status = $jsonRes['transaction']['status'] ?? -1;

        return match ((int) $status) {
            0 => $this->markPaid($order),
            1 => $this->markCancelled($order, $jsonRes['message'] ?? 'Paiement annulé'),
            2 => response()->json([
                'reponse' => true,
                'status' => $status,
                'message' => 'Paiement en attente',
                'orderNumber' => $order->external_payment_id,
            ]),
            default => response()->json([
                'reponse' => false,
                'status' => $status,
                'message' => $jsonRes['message'] ?? 'Statut inconnu',
            ]),
        };
    }

    protected function markPaid(Donation|PartnerCommitment|Order $order): JsonResponse
    {
        if ($order instanceof Donation) {
            $order->update(['status' => 'completed']);
        } elseif ($order instanceof Order) {
            $order->update(['status' => 'paid', 'payment_status' => 'completed']);
        } else {
            $order->update(['status' => 'active']);
        }

        return response()->json([
            'reponse' => true,
            'message' => 'Paiement effectué avec succès',
            'status' => 0,
        ]);
    }

    protected function markCancelled(Donation|PartnerCommitment|Order $order, string $message): JsonResponse
    {
        if ($order instanceof Donation) {
            $order->update(['status' => 'cancelled']);
        } elseif ($order instanceof Order) {
            $order->update(['status' => 'cancelled', 'payment_status' => 'failed']);
        } else {
            $order->update(['status' => 'pending']);
        }

        return response()->json([
            'reponse' => false,
            'status' => 1,
            'message' => $message,
        ]);
    }

    public function paid(string $reference, string $amount, string $currency, string $status): RedirectResponse
    {
        $donation = Donation::where('reference', $reference)->first();
        $partner = $donation ? null : PartnerCommitment::where('reference', $reference)->first();
        $shopOrder = ($donation || $partner) ? null : Order::where('reference', $reference)->first();
        $order = $donation ?? $partner ?? $shopOrder;

        if (! $order) {
            return redirect()->route('home')->with('error', 'Transaction introuvable');
        }

        switch ($status) {
            case 'success':
                if ($donation) {
                    $order->update(['status' => 'completed']);
                    $msg = 'Merci pour votre don !';
                } elseif ($partner) {
                    $order->update(['status' => 'active']);
                    $msg = 'Merci ! Votre engagement partenaire est confirmé.';
                } else {
                    $order->update(['status' => 'paid', 'payment_status' => 'completed']);
                    $msg = 'Merci ! Votre commande est confirmée.';
                }
                break;
            case 'cancel':
                if ($donation) {
                    $order->update(['status' => 'cancelled']);
                } elseif ($partner) {
                    $order->update(['status' => 'pending']);
                } else {
                    $order->update(['status' => 'cancelled', 'payment_status' => 'failed']);
                }
                $msg = 'Paiement annulé';
                break;
            case 'decline':
                if ($donation) {
                    $order->update(['status' => 'failed']);
                } elseif ($partner) {
                    $order->update(['status' => 'pending']);
                } else {
                    $order->update(['status' => 'cancelled', 'payment_status' => 'failed']);
                }
                $msg = 'Paiement refusé';
                break;
            default:
                return redirect()->route('home')->with('error', 'Statut inconnu');
        }

        return redirect()->route('donate.merci')->with([
            'message' => $msg,
            'reference' => $reference,
            'amount' => $amount,
            'currency' => $currency,
        ]);
    }

    /**
     * Autorise le paiement d’une commande boutique (propriétaire connecté, session checkout, ou e-mail invité).
     *
     * @param  Request  $request  Requête courante
     * @param  Order  $shopOrder  Commande à payer
     * @return bool
     */
    private function canPayShopOrder(Request $request, Order $shopOrder): bool
    {
        if (Auth::check() && Auth::id() === $shopOrder->user_id) {
            return true;
        }

        $refs = $request->session()->get('shop_order_refs', []);
        if (is_array($refs) && in_array($shopOrder->reference, $refs, true)) {
            return true;
        }

        $sessionEmail = strtolower((string) $request->session()->get('shop_checkout_email', ''));
        $guestEmail = strtolower((string) ($shopOrder->guest_email ?? ''));

        return $sessionEmail !== '' && $guestEmail !== '' && $sessionEmail === $guestEmail;
    }
}
