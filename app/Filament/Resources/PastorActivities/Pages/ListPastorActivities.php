<?php

namespace App\Filament\Resources\PastorActivities\Pages;

use App\Filament\Resources\PastorActivities\PastorActivityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPastorActivities extends ListRecords
{
    protected static string $resource = PastorActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
