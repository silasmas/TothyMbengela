<?php

namespace App\Filament\Resources\ShippingSettings\Pages;

use App\Filament\Resources\ShippingSettings\ShippingSettingResource;
use Filament\Resources\Pages\EditRecord;

class EditShippingSetting extends EditRecord
{
    protected static string $resource = ShippingSettingResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['domestic_country_code'] = strtoupper(substr((string) ($data['domestic_country_code'] ?? 'CD'), 0, 2));

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
