<?php

namespace App\Models;

use Database\Factories\ThemeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    /** @use HasFactory<ThemeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'thumbnail_path',
        'description',
    ];

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}
