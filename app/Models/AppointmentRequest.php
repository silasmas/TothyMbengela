<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
        ];
    }
}
