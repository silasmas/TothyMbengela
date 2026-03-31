<?php

namespace App\Filament\Resources\PastorActivities;

use App\Filament\Resources\PastorActivities\Pages\CreatePastorActivity;
use App\Filament\Resources\PastorActivities\Pages\EditPastorActivity;
use App\Filament\Resources\PastorActivities\Pages\ListPastorActivities;
use App\Filament\Resources\PastorActivities\RelationManagers\GalleryItemsRelationManager;
use App\Filament\Resources\PastorActivities\Schemas\PastorActivityForm;
use App\Filament\Resources\PastorActivities\Tables\PastorActivitiesTable;
use App\Models\PastorActivity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PastorActivityResource extends Resource
{
    protected static ?string $model = PastorActivity::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|\UnitEnum|null $navigationGroup = 'Site public';

    protected static ?int $navigationSort = 12;

    protected static ?string $modelLabel = 'Activité pasteure';

    protected static ?string $pluralModelLabel = 'Agenda pasteure';

    protected static ?string $navigationLabel = 'Agenda pasteure';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public static function form(Schema $schema): Schema
    {
        return PastorActivityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PastorActivitiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            GalleryItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPastorActivities::route('/'),
            'create' => CreatePastorActivity::route('/create'),
            'edit' => EditPastorActivity::route('/{record}/edit'),
        ];
    }
}
