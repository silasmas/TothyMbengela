<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Données de démonstration cohérentes avec le site Alliance / Tothy Mbengela.
     *
     * Comptes de test (à changer en production) :
     * - Site : visiteur@alliance-ministere.com / password
     * - Admin Filament : admin@alliance-ministere.com / password
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'visiteur@alliance-ministere.com'],
            [
                'name' => 'Visiteur démonstration',
                'password' => 'password',
                'email_verified_at' => now(),
                'preferred_locale' => 'fr',
            ],
        );

        $admin = Admin::query()->updateOrCreate(
            ['email' => 'admin@alliance-ministere.com'],
            [
                'name' => 'Administrateur Alliance',
                'password' => 'password',
            ],
        );
        if ($admin->email_verified_at === null) {
            $admin->forceFill(['email_verified_at' => now()])->save();
        }

        $this->call(ShieldPermissionsSeeder::class);
        $this->call(AdminSuperAdminSeeder::class);

        $this->call(MinistryYoutubeSeeder::class);
        $this->call(ShopSettingSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(SlideSeeder::class);
        $this->call(ShippingSettingsSeeder::class);
        $this->call(TeamMemberSeeder::class);
        $this->call(TestimonialSeeder::class);
        $this->call(PastorActivitySeeder::class);
    }
}
