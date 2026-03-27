<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerCommitment extends Model
{
    protected $fillable = [
        'user_id',
        'reference',
        'monthly_amount',
        'currency',
        'message',
        'status',
        'payment_reference',
        'external_payment_id',
    ];

    protected function casts(): array
    {
        return [
            'monthly_amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
