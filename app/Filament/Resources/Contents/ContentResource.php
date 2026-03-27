<?php

namespace App\Filament\Resources\Contents;

use App\Filament\Resources\Contents\Pages\CreateContent;
use App\Filament\Resources\Contents\Pages\EditContent;
use App\Filament\Resources\Contents\Pages\ListContents;
use App\Filament\Resources\Contents\Schemas\ContentForm;
use App\Filament\Resources\Contents\Tables\ContentsTable;
use App\Models\Content;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContentResource extends Resource
{
    protected static ?string $model = Content::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|\UnitEnum|null $navigationGroup = 'Contenu ministère';

    protected static ?int $navigationSort = 13;

    protected static ?string $modelLabel = 'Contenu';

    protected static ?string $pluralModelLabel = 'Contenus';

    protected static ?string $navigationLabel = 'Contenus';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'excerpt', 'rubrique.name', 'series.title'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Rubrique' => $record->rubrique?->name,
            'Série' => $record->series?->title,
            'Type' => $record->type,
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return ContentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentsTable::configureList($table);
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
            'index' => ListContents::route('/'),
            'create' => CreateContent::route('/create'),
            'edit' => EditContent::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
