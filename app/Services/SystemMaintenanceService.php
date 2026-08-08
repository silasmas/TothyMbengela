<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Throwable;

/**
 * Opérations de maintenance (migrations, seeders, storage:link) pour le dashboard.
 */
class SystemMaintenanceService
{
    /**
     * Seeders gérables depuis l’admin (hors DatabaseSeeder complet).
     *
     * @return array<string, string> Classe => libellé
     */
    public static function managedSeeders(): array
    {
        return [
            'Database\\Seeders\\ShieldPermissionsSeeder' => 'Permissions Shield',
            'Database\\Seeders\\AdminSuperAdminSeeder' => 'Rôle super_admin',
            'Database\\Seeders\\ShopSettingSeeder' => 'Paramètres boutique (devises)',
            'Database\\Seeders\\ShippingSettingsSeeder' => 'Paramètres livraison',
            'Database\\Seeders\\SlideSeeder' => 'Slides par défaut',
            'Database\\Seeders\\TeamMemberSeeder' => 'Membres d’équipe',
            'Database\\Seeders\\TestimonialSeeder' => 'Témoignages',
            'Database\\Seeders\\PastorActivitySeeder' => 'Activités pasteure',
            'Database\\Seeders\\BookSeeder' => 'Produits / livres (démo)',
            'Database\\Seeders\\MinistryYoutubeSeeder' => 'Chaîne YouTube ministère',
        ];
    }

    /**
     * État des migrations (exécutées / en attente).
     *
     * @return array{ran: list<string>, pending: list<string>, batch: int|null}
     */
    public function migrationStatus(): array
    {
        $migrator = app('migrator');

        if (! $migrator->repositoryExists()) {
            return [
                'ran' => [],
                'pending' => array_keys($migrator->getMigrationFiles([database_path('migrations')])),
                'batch' => null,
            ];
        }

        $ran = $migrator->getRepository()->getRan();
        $files = $migrator->getMigrationFiles([database_path('migrations')]);
        $pending = array_values(array_diff(array_keys($files), $ran));

        return [
            'ran' => array_values($ran),
            'pending' => $pending,
            'batch' => $migrator->getRepository()->getLastBatchNumber(),
        ];
    }

    /**
     * Exécute les migrations en attente.
     *
     * @return array{ok: bool, output: string}
     */
    public function runMigrations(): array
    {
        try {
            Artisan::call('migrate', ['--force' => true]);

            return ['ok' => true, 'output' => trim(Artisan::output()) ?: 'Migrations exécutées.'];
        } catch (Throwable $e) {
            report($e);

            return ['ok' => false, 'output' => $e->getMessage()];
        }
    }

    /**
     * État des seeders gérés (exécutés ou non).
     *
     * @return list<array{class: string, label: string, ran: bool, ran_at: string|null}>
     */
    public function seederStatus(): array
    {
        $ranMap = [];
        if (Schema::hasTable('ops_seeder_runs')) {
            $ranMap = DB::table('ops_seeder_runs')->pluck('ran_at', 'seeder')->all();
        }

        $rows = [];
        foreach (self::managedSeeders() as $class => $label) {
            $ranAt = $ranMap[$class] ?? null;
            $rows[] = [
                'class' => $class,
                'label' => $label,
                'ran' => $ranAt !== null,
                'ran_at' => $ranAt ? (string) $ranAt : null,
            ];
        }

        return $rows;
    }

    /**
     * Exécute un seeder puis le marque comme exécuté.
     *
     * @param  string  $seederClass  Classe du seeder
     * @return array{ok: bool, output: string}
     */
    public function runSeeder(string $seederClass): array
    {
        if (! array_key_exists($seederClass, self::managedSeeders())) {
            return ['ok' => false, 'output' => 'Seeder non autorisé.'];
        }

        if (! class_exists($seederClass)) {
            return ['ok' => false, 'output' => 'Classe introuvable : '.$seederClass];
        }

        try {
            Artisan::call('db:seed', [
                '--class' => $seederClass,
                '--force' => true,
            ]);

            if (Schema::hasTable('ops_seeder_runs')) {
                $now = now();
                $existing = DB::table('ops_seeder_runs')->where('seeder', $seederClass)->exists();
                if ($existing) {
                    DB::table('ops_seeder_runs')->where('seeder', $seederClass)->update([
                        'ran_at' => $now,
                        'updated_at' => $now,
                    ]);
                } else {
                    DB::table('ops_seeder_runs')->insert([
                        'seeder' => $seederClass,
                        'ran_at' => $now,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }

            return ['ok' => true, 'output' => trim(Artisan::output()) ?: 'Seeder exécuté : '.$seederClass];
        } catch (Throwable $e) {
            report($e);

            return ['ok' => false, 'output' => $e->getMessage()];
        }
    }

    /**
     * Exécute tous les seeders pas encore marqués comme exécutés.
     *
     * @return array{ok: bool, output: string, count: int}
     */
    public function runPendingSeeders(): array
    {
        $outputs = [];
        $count = 0;

        foreach ($this->seederStatus() as $row) {
            if ($row['ran']) {
                continue;
            }
            $result = $this->runSeeder($row['class']);
            $outputs[] = ($result['ok'] ? 'OK' : 'ERR').' — '.$row['label'].' : '.$result['output'];
            if ($result['ok']) {
                $count++;
            } else {
                return [
                    'ok' => false,
                    'output' => implode("\n", $outputs),
                    'count' => $count,
                ];
            }
        }

        if ($count === 0) {
            return ['ok' => true, 'output' => 'Aucun seeder en attente.', 'count' => 0];
        }

        return ['ok' => true, 'output' => implode("\n", $outputs), 'count' => $count];
    }

    /**
     * Indique si le lien public/storage est actif.
     *
     * @return array{linked: bool, path: string, target: string|null}
     */
    public function storageLinkStatus(): array
    {
        $link = public_path('storage');
        $target = storage_path('app/public');

        if (is_link($link)) {
            return [
                'linked' => true,
                'path' => $link,
                'target' => readlink($link) ?: $target,
            ];
        }

        return [
            'linked' => false,
            'path' => $link,
            'target' => File::exists($link) ? '(existe mais n’est pas un lien symbolique)' : null,
        ];
    }

    /**
     * Crée le lien symbolique storage (php artisan storage:link).
     *
     * @param  bool  $force  Si true, remplace un dossier public/storage bloquant
     * @return array{ok: bool, output: string}
     */
    public function createStorageLink(bool $force = false): array
    {
        try {
            if (! File::isDirectory(storage_path('app/public'))) {
                File::makeDirectory(storage_path('app/public'), 0755, true);
            }

            $status = $this->storageLinkStatus();
            if ($status['linked']) {
                return ['ok' => true, 'output' => 'Le lien storage est déjà actif.'];
            }

            $link = public_path('storage');
            if (File::exists($link) && ! is_link($link)) {
                if ($force) {
                    if (File::isDirectory($link)) {
                        File::deleteDirectory($link);
                    } else {
                        File::delete($link);
                    }
                } elseif (File::isDirectory($link) && count(File::files($link)) === 0 && count(File::directories($link)) === 0) {
                    File::deleteDirectory($link);
                } else {
                    return [
                        'ok' => false,
                        'output' => 'public/storage existe déjà (pas un lien). Utilisez « Forcer le lien storage » pour le remplacer.',
                    ];
                }
            }

            Artisan::call('storage:link');

            return ['ok' => true, 'output' => trim(Artisan::output()) ?: 'Lien storage créé.'];
        } catch (Throwable $e) {
            report($e);

            return ['ok' => false, 'output' => $e->getMessage()];
        }
    }
}
