<?php

namespace App\Models;

use Database\Factories\RubriqueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rubrique extends Model
{
    /** @use HasFactory<RubriqueFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'thumbnail_path',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}
