<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'confirmation_token',
        'phone',
        'name',
        'verified_at',
        'unsubscribed_at',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }
}
