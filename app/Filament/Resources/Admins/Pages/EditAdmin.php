<?php

namespace App\Filament\Resources\Admins\Pages;

use App\Filament\Resources\Admins\AdminResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

/**
 * Édition d’un administrateur Filament.
 */
class EditAdmin extends EditRecord
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
            DeleteAction::make()
                ->disabled(fn () => (int) $this->record->id === (int) auth('admin')->id()),
        ];
    }
}
