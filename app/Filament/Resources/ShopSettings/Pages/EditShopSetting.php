<?php

namespace App\Filament\Resources\ShopSettings\Pages;

use App\Filament\Resources\ShopSettings\ShopSettingResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Édition des paramètres boutique.
 */
class EditShopSetting extends EditRecord
{
    protected static string $resource = ShopSettingResource::class;
}
