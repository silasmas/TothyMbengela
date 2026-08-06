<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingSetting;
use App\Models\ShopSetting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Création de commande boutique (invité par e-mail ou utilisateur connecté).
 */
class ShopCheckoutController extends Controller
{
    /**
     * Crée une commande à partir du panier.
     * L’e-mail est obligatoire : un compte est créé/associé automatiquement sans OTP.
     *
     * @param  Request  $request  items, email, name?, currency?, shipping?
     * @return JsonResponse
     */
    public function initOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'currency' => ['nullable', 'string', 'in:USD,CDF'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer', 'exists:books,id'],
            'items.*.qty' => ['required', 'integer', 'min:1', 'max:99'],
            'shipping' => ['sometimes', 'array'],
            'shipping.enabled' => ['sometimes', 'boolean'],
            'shipping.country' => ['required_if:shipping.enabled,true', 'nullable', 'string', 'size:2'],
            'shipping.city' => ['required_if:shipping.enabled,true', 'nullable', 'string', 'max:120'],
            'shipping.address' => ['required_if:shipping.enabled,true', 'nullable', 'string', 'max:2000'],
            'shipping.phone' => ['required_if:shipping.enabled,true', 'nullable', 'string', 'max:40'],
        ]);

        $email = strtolower(trim($validated['email']));
        $name = trim((string) ($validated['name'] ?? ''));
        if ($name === '') {
            $name = Str::before($email, '@') ?: 'Client Alliance';
        }

        $shop = ShopSetting::instance();
        $currency = strtoupper((string) ($validated['currency'] ?? $shop->default_currency ?: 'USD'));
        if (! $shop->isSupportedCurrency($currency)) {
            $currency = 'USD';
        }

        try {
            $user = $this->findOrRegisterBuyer($email, $name);

            $order = DB::transaction(function () use ($validated, $user, $email, $currency, $shop) {
                $subtotalUsd = 0.0;
                $lines = [];

                foreach ($validated['items'] as $row) {
                    $book = Book::query()->where('id', $row['id'])->where('is_active', true)->first();
                    if (! $book || $book->price === null) {
                        continue;
                    }
                    if ($book->stock_quantity !== null && $book->stock_quantity < $row['qty']) {
                        throw new \RuntimeException('Stock insuffisant pour : '.$book->title);
                    }

                    $qty = (int) $row['qty'];
                    $unitUsd = (float) $book->price;
                    $lineUsd = round($unitUsd * $qty, 2);
                    $subtotalUsd += $lineUsd;

                    $lines[] = [
                        'book' => $book,
                        'qty' => $qty,
                        'unit_usd' => $unitUsd,
                        'line_usd' => $lineUsd,
                    ];
                }

                if ($subtotalUsd <= 0 || $lines === []) {
                    throw new \RuntimeException('Panier invalide ou articles indisponibles.');
                }

                $shippingCfg = ShippingSetting::instance();
                $wantShipping = (bool) ($validated['shipping']['enabled'] ?? false);
                $shippingOptIn = false;
                $shippingCountry = null;
                $shippingCity = null;
                $shippingAddress = null;
                $shippingPhone = null;
                $shippingCostUsd = 0.0;

                if ($wantShipping) {
                    if (! $shippingCfg->is_active) {
                        throw new \RuntimeException('La livraison n’est pas disponible pour le moment.');
                    }
                    $shippingOptIn = true;
                    $shippingCountry = strtoupper((string) ($validated['shipping']['country'] ?? ''));
                    $shippingCity = trim((string) ($validated['shipping']['city'] ?? ''));
                    $shippingAddress = trim((string) ($validated['shipping']['address'] ?? ''));
                    $shippingPhone = trim((string) ($validated['shipping']['phone'] ?? ''));
                    if ($shippingCountry === '' || $shippingCity === '' || $shippingAddress === '' || $shippingPhone === '') {
                        throw new \RuntimeException('Renseignez le pays, la ville, l’adresse complète et un numéro de contact pour la livraison.');
                    }
                    // Les tarifs livraison sont saisis dans la devise de ShippingSetting (souvent USD).
                    $shipRaw = round($shippingCfg->amountForCountry($shippingCountry), 2);
                    $shipCurrency = strtoupper((string) ($shippingCfg->currency ?: 'USD'));
                    $shippingCostUsd = $shipCurrency === 'CDF'
                        ? round($shipRaw / max((float) $shop->usd_to_cdf_rate, 0.0001), 2)
                        : $shipRaw;
                }

                $subtotal = $shop->convertFromUsd($subtotalUsd, $currency);
                $shippingCost = $shop->convertFromUsd($shippingCostUsd, $currency);
                $grandTotal = round($subtotal + $shippingCost, 2);

                $reference = generateUniqueReference('CMD', Order::class, 'reference');

                $order = Order::create([
                    'user_id' => $user->id,
                    'guest_email' => $email,
                    'reference' => $reference,
                    'status' => 'pending',
                    'subtotal' => $subtotal,
                    'shipping_opt_in' => $shippingOptIn,
                    'shipping_country' => $shippingCountry,
                    'shipping_city' => $shippingCity,
                    'shipping_address' => $shippingAddress,
                    'shipping_phone' => $shippingPhone,
                    'shipping_cost' => $shippingCost,
                    'grand_total' => $grandTotal,
                    'currency' => $currency,
                    'payment_status' => 'pending',
                    'notes' => 'Commande boutique (e-mail '.$email.', taux USD→CDF '.$shop->usd_to_cdf_rate.')',
                ]);

                foreach ($lines as $line) {
                    $unit = $shop->convertFromUsd($line['unit_usd'], $currency);
                    $lineTotal = round($unit * $line['qty'], 2);
                    OrderItem::create([
                        'order_id' => $order->id,
                        'book_id' => $line['book']->id,
                        'quantity' => $line['qty'],
                        'unit_price' => $unit,
                        'line_total' => $lineTotal,
                    ]);
                }

                return $order->fresh(['orderItems.book']);
            });

            Auth::login($user);
            $request->session()->put('shop_checkout_email', $email);
            $refs = $request->session()->get('shop_order_refs', []);
            $refs[] = $order->reference;
            $request->session()->put('shop_order_refs', array_values(array_unique($refs)));
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'success' => true,
            'reference' => $order->reference,
            'subtotal' => (float) $order->subtotal,
            'shipping_cost' => (float) $order->shipping_cost,
            'total' => (float) $order->grand_total,
            'currency' => $order->currency,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * Retrouve un utilisateur par e-mail ou en crée un (mot de passe aléatoire).
     *
     * @param  string  $email  E-mail normalisé
     * @param  string  $name  Nom affiché
     * @return User
     */
    private function findOrRegisterBuyer(string $email, string $name): User
    {
        $user = User::query()->where('email', $email)->first();
        if ($user) {
            if ($user->name === '' || $user->name === null) {
                $user->forceFill(['name' => $name])->save();
            }

            return $user;
        }

        return User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make(Str::random(32)),
            'email_verified_at' => now(),
            'preferred_locale' => 'fr',
        ]);
    }
}
