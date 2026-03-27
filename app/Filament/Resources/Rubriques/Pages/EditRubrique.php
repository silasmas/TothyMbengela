<?php

namespace App\Filament\Resources\Rubriques\Pages;

use App\Filament\Resources\Rubriques\RubriqueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRubrique extends EditRecord
{
    protected static string $resource = RubriqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
