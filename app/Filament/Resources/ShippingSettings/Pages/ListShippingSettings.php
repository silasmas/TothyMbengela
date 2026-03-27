<?php

namespace App\Filament\Resources\ShippingSettings\Pages;

use App\Filament\Resources\ShippingSettings\ShippingSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShippingSettings extends ListRecords
{
    protected static string $resource = ShippingSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn (): bool => ShippingSettingResource::canCreate()),
        ];
    }
}
