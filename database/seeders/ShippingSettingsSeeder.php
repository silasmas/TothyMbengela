<?php

namespace Database\Seeders;

use App\Models\ShippingSetting;
use Illuminate\Database\Seeder;

class ShippingSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $row = ShippingSetting::query()->first();
        $payload = [
            'is_active' => true,
            'domestic_country_code' => 'CD',
            'price_domestic' => 5.00,
            'price_international' => 28.00,
            'currency' => 'USD',
        ];

        if ($row) {
            $row->update($payload);
        } else {
            ShippingSetting::query()->create($payload);
        }
    }
}
