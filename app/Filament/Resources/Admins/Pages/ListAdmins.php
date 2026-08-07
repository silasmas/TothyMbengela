<?php

namespace App\Filament\Resources\Admins\Pages;

use App\Filament\Resources\Admins\AdminResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

/**
 * Liste des administrateurs Filament.
 */
class ListAdmins extends ListRecords
{
    protected static string $resource = AdminResource::class;

    /**
     * Actions d’en-tête.
     *
     * @return array<int, mixed>
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
