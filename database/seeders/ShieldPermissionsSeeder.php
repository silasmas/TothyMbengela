<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Génère les enregistrements Spatie (permissions + policies selon config) pour Filament Shield.
 * À lancer après les migrations ; idéal avant AdminSuperAdminSeeder.
 */
class ShieldPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        Artisan::call('shield:generate', [
            '--all' => true,
            '--panel' => 'admin',
            '--no-interaction' => true,
        ]);

        $this->command?->info(trim(Artisan::output()));
    }
}
