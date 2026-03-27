<?php

namespace App\Filament\Resources\Contents\Pages;

use App\Filament\Resources\Contents\ContentResource;
use App\Filament\Resources\Contents\Tables\ContentsTable;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Table;

class ListContents extends ListRecords
{
    protected static string $resource = ContentResource::class;

    /**
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        return [
            'tableau' => Tab::make('Tableau'),
            'grille' => Tab::make('Grille'),
        ];
    }

    public function table(Table $table): Table
    {
        $tab = $this->activeTab ?? $this->getDefaultActiveTab();

        if (is_string($tab) && str_contains(strtolower($tab), 'grille')) {
            return ContentsTable::configureGrid($table);
        }

        return ContentsTable::configureList($table);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Nouveau contenu'),
        ];
    }
}
