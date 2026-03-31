<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PastorActivityGalleryItem extends Model
{
    public const TYPE_IMAGE = 'image';

    public const TYPE_VIDEO = 'video';

    protected $fillable = [
        'pastor_activity_id',
        'type',
        'file_path',
        'external_url',
        'caption',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<PastorActivity, $this>
     */
    public function pastorActivity(): BelongsTo
    {
        return $this->belongsTo(PastorActivity::class);
    }

    public function isImage(): bool
    {
        return $this->type === self::TYPE_IMAGE;
    }

    public function isVideo(): bool
    {
        return $this->type === self::TYPE_VIDEO;
    }

    public function fileDisplayUrl(): ?string
    {
        if (! $this->file_path || ! Storage::disk('public')->exists($this->file_path)) {
            return null;
        }

        return Storage::disk('public')->url($this->file_path);
    }

    public function youtubeVideoId(): ?string
    {
        if (! is_string($this->external_url) || $this->external_url === '') {
            return null;
        }

        if (preg_match('~(?:youtube\.com/watch\?(?:[^&]*&)*v=|youtu\.be/|youtube\.com/embed/|youtube\.com/shorts/)([A-Za-z0-9_-]{11})~i', $this->external_url, $m)) {
            return $m[1];
        }

        return null;
    }

    public function hasDisplayableVideo(): bool
    {
        if (! $this->isVideo()) {
            return false;
        }

        if ($this->youtubeVideoId() !== null) {
            return true;
        }

        return $this->file_path !== null
            && Storage::disk('public')->exists((string) $this->file_path);
    }
}
