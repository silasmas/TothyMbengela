<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'reference',
        'donor_name',
        'donor_email',
        'donor_phone',
        'amount',
        'currency',
        'frequency',
        'is_anonymous',
        'message',
        'payment_provider',
        'external_payment_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_anonymous' => 'boolean',
        ];
    }
}
