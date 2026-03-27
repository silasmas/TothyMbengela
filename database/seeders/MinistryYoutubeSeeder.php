<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Rubrique;
use App\Models\Series;
use App\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MinistryYoutubeSeeder extends Seeder
{
    public function run(): void
    {
        /** @var array<string, mixed> $data */
        $data = require database_path('data/tothy_mbengela_youtube.php');

        $channelId = $data['channel_id'];

        foreach ($data['themes'] as $row) {
            Theme::updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'name' => $row['name'],
                    'description' => $row['description'] ?? null,
                ]
            );
        }

        foreach ($data['rubriques'] as $row) {
            Rubrique::updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'name' => $row['name'],
                    'description' => $row['description'] ?? null,
                    'icon' => $row['icon'] ?? null,
                    'sort_order' => $row['sort_order'] ?? 0,
                    'is_active' => true,
                ]
            );
        }

        /** @var Collection<string, Rubrique> $rubriquesBySlug */
        $rubriquesBySlug = Rubrique::query()
            ->whereIn('slug', collect($data['rubriques'])->pluck('slug'))
            ->get()
            ->keyBy('slug');

        $playlistIdBySeriesSlug = collect($data['playlists'])
            ->keyBy('series_slug')
            ->map(fn (array $pl) => $pl['playlist_id']);

        $sort = 0;
        foreach ($data['playlists'] as $pl) {
            $rubrique = $rubriquesBySlug[$pl['rubrique_slug']];
            $series = Series::updateOrCreate(
                ['slug' => $pl['series_slug']],
                [
                    'rubrique_id' => $rubrique->id,
                    'title' => $pl['playlist_title'],
                    'description' => 'Playlist YouTube « '.$pl['playlist_title'].' » (chaîne @tothy_mbengela).',
                    'sort_order' => $sort++,
                ]
            );

            $title = $pl['featured_title'] ?? ('Première vidéo — '.$pl['playlist_title']);

            $this->syncYoutubeVideo(
                rubrique: $rubrique,
                series: $series,
                videoId: $pl['featured_video_id'],
                title: $title,
                playlistId: $pl['playlist_id'],
                publishedAt: Carbon::now()->subDays(min(120, $sort)),
                position: 0,
                excerpt: null,
                channelId: $channelId,
            );
        }

        foreach ($data['rss_videos'] as $row) {
            $rubrique = $rubriquesBySlug[$row['rubrique_slug']];
            $series = Series::query()->where('slug', $row['series_slug'])->first();
            $playlistId = $playlistIdBySeriesSlug[$row['series_slug']] ?? null;

            $this->syncYoutubeVideo(
                rubrique: $rubrique,
                series: $series,
                videoId: $row['video_id'],
                title: $row['title'],
                playlistId: $playlistId,
                publishedAt: Carbon::parse($row['published_at']),
                position: 0,
                excerpt: $row['excerpt'] ?? null,
                channelId: $channelId,
            );
        }
    }

    private function syncYoutubeVideo(
        Rubrique $rubrique,
        ?Series $series,
        string $videoId,
        string $title,
        ?string $playlistId,
        Carbon $publishedAt,
        int $position,
        ?string $excerpt,
        string $channelId,
    ): void {
        $youtubeUrl = 'https://www.youtube.com/watch?v='.$videoId;

        $meta = array_filter([
            'youtube_channel_id' => $channelId,
            'youtube_playlist_id' => $playlistId,
        ]);

        Content::updateOrCreate(
            ['youtube_video_id' => $videoId],
            [
                'rubrique_id' => $rubrique->id,
                'series_id' => $series?->id,
                'theme_id' => null,
                'type' => 'video',
                'source' => 'youtube',
                'title' => Str::limit($title, 250, ''),
                'slug' => 'youtube-'.$videoId,
                'excerpt' => $excerpt ? Str::limit($excerpt, 500, '') : null,
                'body' => null,
                'media_url' => null,
                'youtube_url' => $youtubeUrl,
                'file_path' => null,
                'thumbnail_path' => null,
                'duration_seconds' => null,
                'allow_streaming' => true,
                'allow_download' => false,
                'is_published' => true,
                'published_at' => $publishedAt,
                'is_featured' => false,
                'position' => $position,
                'meta' => $meta ?: null,
            ]
        );
    }
}
