<?php

namespace Database\Factories;

use App\Models\Content;
use App\Models\Rubrique;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Content>
 */
class ContentFactory extends Factory
{
    protected $model = Content::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'rubrique_id' => Rubrique::factory(),
            'series_id' => null,
            'theme_id' => null,
            'type' => fake()->randomElement(['video', 'audio', 'article']),
            'source' => 'internal',
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('####'),
            'excerpt' => fake()->optional(0.5)->sentence(),
            'body' => fake()->optional(0.3)->paragraphs(2, true),
            'media_url' => fake()->optional(0.3)->url(),
            'youtube_video_id' => null,
            'youtube_url' => null,
            'file_path' => null,
            'thumbnail_path' => null,
            'duration_seconds' => fake()->optional(0.7)->numberBetween(120, 7200),
            'allow_streaming' => true,
            'allow_download' => false,
            'is_published' => fake()->boolean(80),
            'published_at' => fake()->optional(0.8)->dateTimeBetween('-1 year'),
            'is_featured' => fake()->boolean(15),
            'position' => fake()->numberBetween(0, 100),
            'meta' => null,
        ];
    }

    /**
     * @param  array<string, mixed>|null  $metaExtra  fusionné dans meta (ex. chaîne YouTube)
     */
    public function youtube(string $videoId, ?string $playlistId = null, ?array $metaExtra = null): static
    {
        return $this->state(function (array $attributes) use ($videoId, $playlistId, $metaExtra) {
            $meta = array_filter([
                'youtube_playlist_id' => $playlistId,
            ]);
            if (is_array($metaExtra)) {
                $meta = array_merge($meta, $metaExtra);
            }

            return [
                'type' => 'video',
                'source' => 'youtube',
                'youtube_video_id' => $videoId,
                'youtube_url' => 'https://www.youtube.com/watch?v='.$videoId,
                'media_url' => null,
                'file_path' => null,
                'allow_streaming' => true,
                'allow_download' => false,
                'meta' => $meta ?: null,
            ];
        });
    }
}
