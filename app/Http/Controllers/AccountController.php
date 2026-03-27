<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Order;
use App\Models\PartnerCommitment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $email = strtolower(trim($user->email));

        $ordersCount = Order::where('user_id', $user->id)->count();
        $donationsCount = Donation::whereRaw('LOWER(TRIM(donor_email)) = ?', [$email])->count();
        $partnersCount = PartnerCommitment::where('user_id', $user->id)->count();

        return view('account.index', compact('ordersCount', 'donationsCount', 'partnersCount'));
    }

    public function purchases(Request $request): View
    {
        $orders = Order::query()
            ->where('user_id', $request->user()->id)
            ->with(['orderItems.book'])
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('account.purchases', compact('orders'));
    }

    public function donations(Request $request): View
    {
        $email = strtolower(trim($request->user()->email));
        $donations = Donation::query()
            ->whereRaw('LOWER(TRIM(donor_email)) = ?', [$email])
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('account.donations', compact('donations'));
    }

    public function partnerships(Request $request): View
    {
        $commitments = PartnerCommitment::query()
            ->where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('account.partnerships', compact('commitments'));
    }

    public function activity(Request $request): View
    {
        $user = $request->user();
        $items = $this->collectActivityItems($user->id, $user->email);

        return view('account.activity', ['items' => $items]);
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    private function collectActivityItems(int $userId, string $email): Collection
    {
        $emailKey = strtolower(trim($email));
        $items = collect();

        Order::query()
            ->where('user_id', $userId)
            ->orderByDesc('updated_at')
            ->get()
            ->each(function (Order $o) use ($items) {
                $items->push([
                    'sort' => $o->updated_at?->timestamp ?? 0,
                    'at' => $o->updated_at,
                    'icon' => 'fa-shopping-bag',
                    'title' => 'Commande livres',
                    'kind' => 'order',
                    'ref' => $o->reference ?? ('#'.$o->id),
                    'detail' => number_format((float) ($o->grand_total ?? $o->subtotal), 2, ',', ' ').' '.$o->currency,
                    'status' => $o->status.' · '.$o->payment_status,
                    'order_status' => $o->status,
                    'payment_status' => $o->payment_status,
                ]);
            });

        Donation::query()
            ->whereRaw('LOWER(TRIM(donor_email)) = ?', [$emailKey])
            ->orderByDesc('updated_at')
            ->get()
            ->each(function (Donation $d) use ($items) {
                $items->push([
                    'sort' => $d->updated_at?->timestamp ?? 0,
                    'at' => $d->updated_at,
                    'icon' => 'fa-heart',
                    'title' => 'Don',
                    'kind' => 'donation',
                    'ref' => $d->reference,
                    'detail' => number_format((float) $d->amount, 2, ',', ' ').' '.$d->currency,
                    'status' => $d->status,
                ]);
            });

        PartnerCommitment::query()
            ->where('user_id', $userId)
            ->orderByDesc('updated_at')
            ->get()
            ->each(function (PartnerCommitment $p) use ($items) {
                $items->push([
                    'sort' => $p->updated_at?->timestamp ?? 0,
                    'at' => $p->updated_at,
                    'icon' => 'fa-handshake',
                    'title' => 'Partenariat',
                    'kind' => 'partner',
                    'ref' => $p->reference,
                    'detail' => number_format((float) $p->monthly_amount, 2, ',', ' ').' '.$p->currency.'/mois',
                    'status' => $p->status,
                ]);
            });

        return $items->sortByDesc('sort')->values();
    }
}
