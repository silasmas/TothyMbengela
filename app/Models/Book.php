<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'currency',
        'cover_path',
        'digital_file_path',
        'isbn',
        'is_active',
        'stock_quantity',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * URL absolue de la couverture (ou image de repli) pour le panier / listes.
     */
    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_path) {
            return Storage::disk('public')->url($this->cover_path);
        }

        return asset('assets/images/resource/about-1.jpg');
    }
}
