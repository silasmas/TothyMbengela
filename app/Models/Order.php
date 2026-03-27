<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'reference',
        'guest_email',
        'guest_phone',
        'status',
        'subtotal',
        'shipping_opt_in',
        'shipping_country',
        'shipping_city',
        'shipping_address',
        'shipping_phone',
        'shipping_cost',
        'grand_total',
        'currency',
        'payment_status',
        'payment_method',
        'payment_reference',
        'external_payment_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'shipping_opt_in' => 'boolean',
            'shipping_cost' => 'decimal:2',
            'grand_total' => 'decimal:2',
        ];
    }

    /**
     * Montant à encaisser (commandes anciennes sans grand_total : sous-total seul).
     */
    public function getAmountDueAttribute(): float
    {
        return (float) ($this->grand_total ?? $this->subtotal);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
