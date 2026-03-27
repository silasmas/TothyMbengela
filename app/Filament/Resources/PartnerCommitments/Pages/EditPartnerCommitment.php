<?php

namespace App\Filament\Resources\PartnerCommitments\Pages;

use App\Filament\Resources\PartnerCommitments\PartnerCommitmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPartnerCommitment extends EditRecord
{
    protected static string $resource = PartnerCommitmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
