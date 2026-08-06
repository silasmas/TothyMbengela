<?php

namespace Database\Seeders;

use App\Models\ShopSetting;
use Illuminate\Database\Seeder;

/**
 * Initialise les paramètres devises boutique.
 */
class ShopSettingSeeder extends Seeder
{
    /**
     * Crée ou met à jour la ligne shop_settings.
     *
     * @return void
     */
    public function run(): void
    {
        ShopSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'usd_to_cdf_rate' => 2850,
                'default_currency' => 'USD',
                'allow_currency_switch' => true,
            ],
        );
    }
}
