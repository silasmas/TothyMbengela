<?php

namespace App\Filament\Resources\Rubriques\Pages;

use App\Filament\Resources\Rubriques\RubriqueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRubriques extends ListRecords
{
    protected static string $resource = RubriqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
