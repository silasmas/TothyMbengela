<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Édition des infos de base du site.
 */
class EditSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;
}
