<?php

namespace App\Filament\Resources\ShopSettings\Pages;

use App\Filament\Resources\ShopSettings\ShopSettingResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Création des paramètres boutique.
 */
class CreateShopSetting extends CreateRecord
{
    protected static string $resource = ShopSettingResource::class;
}
