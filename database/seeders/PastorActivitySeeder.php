<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PastorActivity;
use App\Models\PastorActivityGalleryItem;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Remplit pastor_activities avec des événements passés, du jour et à venir.
 *
 * Images : copie depuis le dossier local (WhatsApp *.jpeg) si trouvé.
 * PASTOR_ACTIVITY_SEED_SOURCE (optionnel) ou dossiers candidats dont
 * C:\Users\ZBOOK\Downloads\tothy\poste et database/seeders/sources/pastor-poste
 *
 * Spots vidéo : URLs YouTube publiques du ministère (contenus / chaîne).
 */
class PastorActivitySeeder extends Seeder
{
    private const POSTER_SUBDIR = 'pastor-activities/posters/seed';

    private const DEFAULT_MAX_BYTES = 5_000_000;

    /** Images légères du dossier « poste ». */
    private const LOCAL_IMAGE_FILES = [
        'WhatsApp Image 2026-03-29 at 21.15.18.jpeg',
        'WhatsApp Image 2026-03-29 at 21.15.18 (1).jpeg',
        'WhatsApp Image 2026-03-29 at 21.15.18 (2).jpeg',
        'WhatsApp Image 2026-03-29 at 21.15.19.jpeg',
        'WhatsApp Image 2026-03-29 at 21.15.19 (1).jpeg',
        'WhatsApp Image 2026-03-29 at 21.15.54.jpeg',
        'WhatsApp Image 2026-03-29 at 21.56.16.jpeg',
        'WhatsApp Image 2026-03-29 at 21.56.17.jpeg',
        'WhatsApp Image 2026-03-29 at 21.56.18.jpeg',
    ];

    private const ATELIER_POSTER_FILE = 'atelier de femme copie.jpg.jpeg';

    public function run(): void
    {
        $sourceDir = $this->resolveSourceDirectory();
        $maxBytes = (int) env('PASTOR_ACTIVITY_SEED_MAX_BYTES', self::DEFAULT_MAX_BYTES);

        if ($sourceDir) {
            $this->command?->info('Dossier source agenda : '.$sourceDir);
        } else {
            $this->command?->warn('Aucun dossier source : affiches vides. Définissez PASTOR_ACTIVITY_SEED_SOURCE ou créez database/seeders/sources/pastor-poste.');
        }

        $posters = $this->importLocalPosters($sourceDir, $maxBytes);
        $atelierPoster = $this->importSinglePosterIfSmall(
            $sourceDir,
            self::ATELIER_POSTER_FILE,
            'atelier-femmes-affiche',
            $maxBytes,
        );

        $now = Carbon::now();

        $definitions = [
            [
                'title' => 'Atelier des femmes — session de mars',
                'slug' => 'atelier-femmes-session-mars',
                'description' => 'Temps d’enseignement, d’échange et de prière entre sœurs. Thème : grandir dans la grâce au quotidien.',
                'location' => 'Centre Missionnaire Philadelphie, Lubumbashi',
                'starts_at' => $now->copy()->subDays(18)->setTime(15, 0),
                'ends_at' => $now->copy()->subDays(18)->setTime(18, 30),
                'poster' => $atelierPoster,
                'poster_fallback_index' => null,
                'spot_url' => 'https://www.youtube.com/watch?v=7flJZzwDy_Q',
                'sort_order' => 10,
            ],
            [
                'title' => 'Soirée louange et témoignages',
                'slug' => 'soiree-louange-temoignages',
                'description' => 'Soirée ouverte : adoration et partage autour de la foi.',
                'location' => 'Alliance — Ministère Tothy Mbengela',
                'starts_at' => $now->copy()->subDays(6)->setTime(18, 0),
                'ends_at' => $now->copy()->subDays(6)->setTime(20, 30),
                'poster' => null,
                'poster_fallback_index' => 0,
                'spot_url' => 'https://www.youtube.com/watch?v=0BH75IkAuq4',
                'sort_order' => 20,
            ],
            [
                'title' => 'Matinée de formation — leadership au féminin',
                'slug' => 'matinee-formation-leadership-feminin',
                'description' => 'Aujourd’hui : atelier pratique pour servir avec sagesse dans la famille, l’église et la cité.',
                'location' => 'Lubumbashi',
                'starts_at' => $now->copy()->startOfDay()->setTime(10, 0),
                'ends_at' => $now->copy()->startOfDay()->setTime(12, 30),
                'poster' => null,
                'poster_fallback_index' => 1,
                'spot_url' => 'https://www.youtube.com/watch?v=C7qfNyJKRn0',
                'sort_order' => 30,
            ],
            [
                'title' => 'Culte de célébration — soirée de gloire',
                'slug' => 'culte-celebration-soiree-gloire',
                'description' => 'Ce soir : louange, Parole et moment de communion.',
                'location' => 'Centre Missionnaire Philadelphie, Lubumbashi',
                'starts_at' => $now->copy()->startOfDay()->setTime(18, 30),
                'ends_at' => $now->copy()->startOfDay()->setTime(20, 30),
                'poster' => null,
                'poster_fallback_index' => 2,
                'spot_url' => 'https://www.youtube.com/watch?v=Asc3iaC4IK4',
                'sort_order' => 40,
            ],
            [
                'title' => 'Prière des femmes — intercession',
                'slug' => 'priere-femmes-intercession',
                'description' => 'Rendez-vous de prière pour les familles, l’église et la nation.',
                'location' => 'Lubumbashi',
                'starts_at' => $now->copy()->addDays(2)->setTime(15, 0),
                'ends_at' => $now->copy()->addDays(2)->setTime(17, 0),
                'poster' => null,
                'poster_fallback_index' => 3,
                'spot_url' => 'https://www.youtube.com/watch?v=6K1sZTwY9Vs',
                'sort_order' => 50,
            ],
            [
                'title' => 'Étude biblique — série « S’accomplir »',
                'slug' => 'etude-biblique-serie-saccomplir',
                'description' => 'Approfondissement biblique (série disponible sur la chaîne YouTube du ministère).',
                'location' => 'Lubumbashi',
                'starts_at' => $now->copy()->addDays(4)->setTime(17, 0),
                'ends_at' => $now->copy()->addDays(4)->setTime(18, 45),
                'poster' => null,
                'poster_fallback_index' => 4,
                'spot_url' => 'https://www.youtube.com/watch?v=3FIhRR3qRog',
                'sort_order' => 60,
            ],
            [
                'title' => 'Veillée de prière de fin de semaine',
                'slug' => 'veillee-priere-fin-de-semaine',
                'description' => 'Moment de prière pour clôturer la semaine dans la présence de Dieu.',
                'location' => 'Alliance — Ministère Tothy Mbengela',
                'starts_at' => $now->copy()->endOfWeek()->setTime(20, 0),
                'ends_at' => $now->copy()->endOfWeek()->setTime(22, 30),
                'poster' => null,
                'poster_fallback_index' => 5,
                'spot_url' => 'https://www.youtube.com/watch?v=460ftY_DReE',
                'sort_order' => 70,
            ],
            [
                'title' => 'Conférence — « Femme disciple de Jésus »',
                'slug' => 'conference-femme-disciple-de-jesus',
                'description' => 'Grande matinée d’enseignement : suivre Christ au quotidien.',
                'location' => 'Lubumbashi',
                'starts_at' => $now->copy()->addDays(12)->setTime(9, 30),
                'ends_at' => $now->copy()->addDays(12)->setTime(13, 0),
                'poster' => null,
                'poster_fallback_index' => 6,
                'spot_url' => 'https://www.youtube.com/watch?v=7flJZzwDy_Q',
                'sort_order' => 80,
            ],
        ];

        foreach ($definitions as $def) {
            $posterPath = $def['poster'] ?? $this->posterAtIndex($posters, $def['poster_fallback_index']);
            unset($def['poster'], $def['poster_fallback_index']);

            PastorActivity::query()->updateOrCreate(
                ['slug' => $def['slug']],
                array_merge($def, [
                    'poster_path' => $posterPath,
                    'spot_image_path' => $posterPath,
                    'is_published' => true,
                ]),
            );
        }

        $imagePool = array_values(array_unique(array_filter(array_merge(
            $posters,
            array_filter([$atelierPoster]),
        ))));

        $this->seedGalleryForPastActivities($imagePool);

        $this->command?->info('PastorActivitySeeder : '.count($definitions).' activités enregistrées.');
    }

    /**
     * @param  list<string>  $imagePool
     */
    private function seedGalleryForPastActivities(array $imagePool): void
    {
        $past = PastorActivity::query()
            ->published()
            ->pastCompleted()
            ->orderByRaw('COALESCE(ends_at, starts_at) DESC')
            ->get();

        foreach ($past as $activity) {
            PastorActivityGalleryItem::query()->where('pastor_activity_id', $activity->id)->delete();

            $pool = $imagePool;
            if ($activity->poster_path) {
                $pool[] = $activity->poster_path;
            }
            $pool = array_values(array_unique(array_filter($pool)));

            $sort = 0;
            if ($pool !== []) {
                $n = min(4, count($pool));
                $offset = abs(crc32($activity->slug)) % max(1, count($pool));
                for ($i = 0; $i < $n; $i++) {
                    $path = $pool[($offset + $i) % count($pool)];
                    PastorActivityGalleryItem::query()->create([
                        'pastor_activity_id' => $activity->id,
                        'type' => PastorActivityGalleryItem::TYPE_IMAGE,
                        'file_path' => $path,
                        'caption' => 'Moment de l’événement — '.$activity->title,
                        'sort_order' => $sort++,
                    ]);
                }
            }

            PastorActivityGalleryItem::query()->create([
                'pastor_activity_id' => $activity->id,
                'type' => PastorActivityGalleryItem::TYPE_VIDEO,
                'file_path' => null,
                'external_url' => 'https://www.youtube.com/watch?v=7flJZzwDy_Q',
                'caption' => 'Retour en images (vidéo)',
                'sort_order' => $sort,
            ]);
        }

        $this->command?->info('Galerie : '.$past->count().' activité(s) passée(s) enrichie(s).');
    }

    private function resolveSourceDirectory(): ?string
    {
        $candidates = array_filter([
            env('PASTOR_ACTIVITY_SEED_SOURCE'),
            'C:/Users/ZBOOK/Downloads/tothy/poste',
            base_path('database/seeders/sources/pastor-poste'),
        ]);

        foreach ($candidates as $dir) {
            if ($dir === '' || $dir === null) {
                continue;
            }
            $normalized = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $dir);
            if (is_dir($normalized)) {
                return $normalized;
            }
        }

        return null;
    }

    /**
     * @return list<string>
     */
    private function importLocalPosters(?string $sourceDir, int $maxBytes): array
    {
        if (! $sourceDir) {
            return [];
        }

        $disk = Storage::disk('public');
        $out = [];

        foreach (self::LOCAL_IMAGE_FILES as $i => $fileName) {
            $full = $sourceDir.DIRECTORY_SEPARATOR.$fileName;
            if (! is_file($full)) {
                continue;
            }
            if (filesize($full) > $maxBytes) {
                $this->command?->warn('Fichier ignoré (trop volumineux) : '.$fileName);

                continue;
            }
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION) ?: 'jpg');
            $dest = self::POSTER_SUBDIR.'/wa-'.str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT).'.'.$ext;
            $disk->put($dest, File::get($full));
            $out[] = $dest;
        }

        return $out;
    }

    private function importSinglePosterIfSmall(?string $sourceDir, string $fileName, string $basename, int $maxBytes): ?string
    {
        if (! $sourceDir) {
            return null;
        }
        $full = $sourceDir.DIRECTORY_SEPARATOR.$fileName;
        if (! is_file($full) || filesize($full) > $maxBytes) {
            if (is_file($full) && filesize($full) > $maxBytes) {
                $this->command?->warn('Affiche atelier ignorée (fichier > '.$maxBytes.' octets). Augmentez PASTOR_ACTIVITY_SEED_MAX_BYTES si besoin.');
            }

            return null;
        }
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION) ?: 'jpg');
        $dest = self::POSTER_SUBDIR.'/'.$basename.'.'.$ext;
        Storage::disk('public')->put($dest, File::get($full));

        return $dest;
    }

    /**
     * @param  list<string>  $posters
     */
    private function posterAtIndex(array $posters, ?int $index): ?string
    {
        if ($index === null || ! isset($posters[$index])) {
            return null;
        }

        return $posters[$index];
    }
}
