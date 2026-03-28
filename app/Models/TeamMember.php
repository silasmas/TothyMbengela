<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'role',
        'excerpt',
        'body',
        'photo_path',
        'profile_url',
        'social_facebook',
        'social_youtube',
        'social_instagram',
        'social_tiktok',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @param  Builder<TeamMember>  $query
     * @return Builder<TeamMember>
     */
    public function scopeActiveOrdered(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('name');
    }

    public function photoDisplayUrl(): string
    {
        if ($this->photo_path && Storage::disk('public')->exists($this->photo_path)) {
            return Storage::disk('public')->url($this->photo_path);
        }

        return asset('assets/images/about-ministry/team-pasteure-only.jpg');
    }

    public function profileHref(): ?string
    {
        $url = $this->profile_url;
        if (! is_string($url) || $url === '') {
            return null;
        }

        return Str::startsWith($url, ['http://', 'https://']) ? $url : 'https://'.$url;
    }
}
