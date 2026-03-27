<?php

namespace App\Filament\Resources\PartnerCommitments\Pages;

use App\Filament\Resources\PartnerCommitments\PartnerCommitmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPartnerCommitments extends ListRecords
{
    protected static string $resource = PartnerCommitmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
