<?php

namespace App\Filament\Resources\Series;

use App\Filament\Resources\Series\Pages\CreateSeries;
use App\Filament\Resources\Series\Pages\EditSeries;
use App\Filament\Resources\Series\Pages\ListSeries;
use App\Filament\Resources\Series\Schemas\SeriesForm;
use App\Filament\Resources\Series\Tables\SeriesTable;
use App\Models\Series;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SeriesResource extends Resource
{
    protected static ?string $model = Series::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|\UnitEnum|null $navigationGroup = 'Contenu ministère';

    protected static ?int $navigationSort = 12;

    protected static ?string $modelLabel = 'Série';

    protected static ?string $pluralModelLabel = 'Séries';

    protected static ?string $navigationLabel = 'Séries';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    public static function form(Schema $schema): Schema
    {
        return SeriesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeriesTable::configure($table);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description', 'rubrique.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Rubrique' => $record->rubrique?->name,
        ];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSeries::route('/'),
            'create' => CreateSeries::route('/create'),
            'edit' => EditSeries::route('/{record}/edit'),
        ];
    }
}
