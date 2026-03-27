<?php

namespace App\Models;

use Database\Factories\ContentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Content extends Model
{
    /** @use HasFactory<ContentFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rubrique_id',
        'series_id',
        'theme_id',
        'type',
        'source',
        'title',
        'slug',
        'excerpt',
        'body',
        'media_url',
        'youtube_video_id',
        'youtube_url',
        'file_path',
        'thumbnail_path',
        'duration_seconds',
        'allow_streaming',
        'allow_download',
        'is_published',
        'published_at',
        'is_featured',
        'position',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'allow_streaming' => 'boolean',
            'allow_download' => 'boolean',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function rubrique(): BelongsTo
    {
        return $this->belongsTo(Rubrique::class);
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * URL affichable pour la vignette (fichier local ou miniature YouTube).
     */
    public function getThumbnailDisplayUrl(): ?string
    {
        if (filled($this->thumbnail_path)) {
            return Storage::disk('public')->url($this->thumbnail_path);
        }

        if (filled($this->youtube_video_id)) {
            return 'https://i.ytimg.com/vi/'.$this->youtube_video_id.'/hqdefault.jpg';
        }

        return null;
    }
}
