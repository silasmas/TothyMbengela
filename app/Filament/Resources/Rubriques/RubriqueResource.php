<?php

namespace App\Filament\Resources\Rubriques;

use App\Filament\Resources\Rubriques\Pages\CreateRubrique;
use App\Filament\Resources\Rubriques\Pages\EditRubrique;
use App\Filament\Resources\Rubriques\Pages\ListRubriques;
use App\Filament\Resources\Rubriques\Schemas\RubriqueForm;
use App\Filament\Resources\Rubriques\Tables\RubriquesTable;
use App\Models\Rubrique;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RubriqueResource extends Resource
{
    protected static ?string $model = Rubrique::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = 'Contenu ministère';

    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Rubrique';

    protected static ?string $pluralModelLabel = 'Rubriques';

    protected static ?string $navigationLabel = 'Rubriques';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    public static function form(Schema $schema): Schema
    {
        return RubriqueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RubriquesTable::configure($table);
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
            'index' => ListRubriques::route('/'),
            'create' => CreateRubrique::route('/create'),
            'edit' => EditRubrique::route('/{record}/edit'),
        ];
    }
}
