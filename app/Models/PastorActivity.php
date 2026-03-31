<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class PastorActivity extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'starts_at',
        'ends_at',
        'poster_path',
        'spot_image_path',
        'spot_url',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return HasMany<PastorActivityGalleryItem, $this>
     */
    public function galleryItems(): HasMany
    {
        return $this->hasMany(PastorActivityGalleryItem::class)->orderBy('sort_order')->orderBy('id');
    }

    public function effectiveEndsAt(): Carbon
    {
        if ($this->ends_at !== null) {
            return $this->ends_at;
        }

        return $this->starts_at->copy()->endOfDay();
    }

    public function overlapsToday(): bool
    {
        $dayStart = now()->copy()->startOfDay();
        $dayEnd = now()->copy()->endOfDay();

        if ($this->starts_at->gt($dayEnd)) {
            return false;
        }

        if ($this->ends_at !== null) {
            return ! $this->ends_at->lt($dayStart);
        }

        return $this->starts_at->toDateString() === now()->toDateString();
    }

    /**
     * Activités publiées pertinentes pour la modale d’accueil : à partir d’aujourd’hui jusqu’à la fin de la semaine civile (timezone app).
     *
     * @return Collection<int, PastorActivity>
     */
    public static function forWelcomeModal(): Collection
    {
        $windowStart = now()->copy()->startOfDay();
        $windowEnd = now()->copy()->endOfWeek();

        return static::query()
            ->published()
            ->where(function (Builder $q) use ($windowStart, $windowEnd) {
                $q->where(function (Builder $q2) use ($windowStart, $windowEnd) {
                    $q2->whereNotNull('ends_at')
                        ->where('starts_at', '<=', $windowEnd)
                        ->where('ends_at', '>=', $windowStart);
                })->orWhere(function (Builder $q2) use ($windowStart, $windowEnd) {
                    $q2->whereNull('ends_at')
                        ->where('starts_at', '>=', $windowStart)
                        ->where('starts_at', '<=', $windowEnd);
                });
            })
            ->orderBy('starts_at')
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * @param  Builder<PastorActivity>  $query
     * @return Builder<PastorActivity>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Activités dont la plage horaire croise le jour civil courant (timezone app).
     *
     * @param  Builder<PastorActivity>  $query
     * @return Builder<PastorActivity>
     */
    public function scopeOverlappingToday(Builder $query): Builder
    {
        $day = now();
        $dayStart = $day->copy()->startOfDay();
        $dayEnd = $day->copy()->endOfDay();
        $dateString = $day->toDateString();

        return $query
            ->where('starts_at', '<=', $dayEnd)
            ->where(function (Builder $q) use ($dayStart, $dateString) {
                $q->where(function (Builder $q2) use ($dayStart) {
                    $q2->whereNotNull('ends_at')->where('ends_at', '>=', $dayStart);
                })->orWhere(function (Builder $q2) use ($dateString) {
                    $q2->whereNull('ends_at')->whereDate('starts_at', $dateString);
                });
            });
    }

    /**
     * @param  Builder<PastorActivity>  $query
     * @return Builder<PastorActivity>
     */
    public function scopeUpcomingFromTomorrow(Builder $query): Builder
    {
        return $query->where('starts_at', '>', now()->endOfDay());
    }

    /**
     * @param  Builder<PastorActivity>  $query
     * @return Builder<PastorActivity>
     */
    public function scopePastCompleted(Builder $query): Builder
    {
        $start = now()->startOfDay();

        return $query->where(function (Builder $q) use ($start) {
            $q->where(function (Builder $q2) use ($start) {
                $q2->whereNotNull('ends_at')->where('ends_at', '<', $start);
            })->orWhere(function (Builder $q2) use ($start) {
                $q2->whereNull('ends_at')->whereDate('starts_at', '<', $start->toDateString());
            });
        });
    }

    public function posterDisplayUrl(): ?string
    {
        if (! $this->poster_path || ! Storage::disk('public')->exists($this->poster_path)) {
            return null;
        }

        return Storage::disk('public')->url($this->poster_path);
    }

    public function spotImageDisplayUrl(): ?string
    {
        if (! $this->spot_image_path || ! Storage::disk('public')->exists($this->spot_image_path)) {
            return null;
        }

        return Storage::disk('public')->url($this->spot_image_path);
    }

    public function spotYoutubeVideoId(): ?string
    {
        if (! is_string($this->spot_url) || $this->spot_url === '') {
            return null;
        }

        if (preg_match('~(?:youtube\.com/watch\?(?:[^&]*&)*v=|youtu\.be/|youtube\.com/embed/|youtube\.com/shorts/)([A-Za-z0-9_-]{11})~i', $this->spot_url, $m)) {
            return $m[1];
        }

        return null;
    }
}
