<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Création de la fiche infos du site.
 */
class CreateSiteSetting extends CreateRecord
{
    protected static string $resource = SiteSettingResource::class;
}
