<?php

namespace App\Models;

use Database\Factories\SeriesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    /** @use HasFactory<SeriesFactory> */
    use HasFactory;

    protected $table = 'series';

    protected $fillable = [
        'rubrique_id',
        'theme_id',
        'title',
        'slug',
        'icon',
        'thumbnail_path',
        'description',
        'sort_order',
    ];

    public function rubrique(): BelongsTo
    {
        return $this->belongsTo(Rubrique::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}
