<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopCheckoutController extends Controller
{
    /**
     * Crée une commande à partir du panier (utilisateur connecté uniquement).
     *
     * @param  array<int, array{id: int, qty: int}>  $request->items
     */
    public function initOrder(Request $request): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Connexion requise.'], 401);
        }

        $validated = $request->validate([
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

        try {
            $order = DB::transaction(function () use ($validated) {
                $subtotal = 0;
                $currency = 'USD';
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
                    $unit = (float) $book->price;
                    $lineTotal = round($unit * $qty, 2);
                    $subtotal += $lineTotal;
                    $currency = $book->currency ?? $currency;

                    $lines[] = [
                        'book' => $book,
                        'qty' => $qty,
                        'unit' => $unit,
                        'line_total' => $lineTotal,
                    ];
                }

                if ($subtotal <= 0 || $lines === []) {
                    throw new \RuntimeException('Panier invalide ou articles indisponibles.');
                }

                $shippingCfg = ShippingSetting::instance();
                $wantShipping = (bool) ($validated['shipping']['enabled'] ?? false);
                $shippingOptIn = false;
                $shippingCountry = null;
                $shippingCity = null;
                $shippingAddress = null;
                $shippingPhone = null;
                $shippingCost = 0.0;

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
                    $shippingCost = round($shippingCfg->amountForCountry($shippingCountry), 2);
                }

                $grandTotal = round($subtotal + $shippingCost, 2);

                $reference = generateUniqueReference('CMD', Order::class, 'reference');

                $order = Order::create([
                    'user_id' => Auth::id(),
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
                    'notes' => 'Commande livres (site)',
                ]);

                foreach ($lines as $line) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'book_id' => $line['book']->id,
                        'quantity' => $line['qty'],
                        'unit_price' => $line['unit'],
                        'line_total' => $line['line_total'],
                    ]);
                }

                return $order->fresh(['orderItems.book']);
            });
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
        ]);
    }
}
