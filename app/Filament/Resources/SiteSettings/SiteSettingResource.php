<?php

namespace App\Filament\Resources\SiteSettings;

use App\Filament\Resources\SiteSettings\Pages\CreateSiteSetting;
use App\Filament\Resources\SiteSettings\Pages\EditSiteSetting;
use App\Filament\Resources\SiteSettings\Pages\ListSiteSettings;
use App\Filament\Resources\SiteSettings\Schemas\SiteSettingForm;
use App\Filament\Resources\SiteSettings\Tables\SiteSettingsTable;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/**
 * Ressource Filament des informations de base du site.
 */
class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $recordTitleAttribute = 'email';

    protected static string|\UnitEnum|null $navigationGroup = 'Site public';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'paramètre du site';

    protected static ?string $pluralModelLabel = 'paramètres du site';

    protected static ?string $navigationLabel = 'Infos du site';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    /**
     * Formulaire.
     *
     * @param  Schema  $schema  Schéma
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return SiteSettingForm::configure($schema);
    }

    /**
     * Table.
     *
     * @param  Table  $table  Table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return SiteSettingsTable::configure($table);
    }

    /**
     * Relations.
     *
     * @return array<int, mixed>
     */
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * Pages.
     *
     * @return array<string, mixed>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListSiteSettings::route('/'),
            'create' => CreateSiteSetting::route('/create'),
            'edit' => EditSiteSetting::route('/{record}/edit'),
        ];
    }

    /**
     * Singleton : une seule fiche.
     *
     * @return bool
     */
    public static function canCreate(): bool
    {
        return SiteSetting::query()->count() === 0;
    }

    /**
     * Interdit la suppression.
     *
     * @param  Model  $record  Enregistrement
     * @return bool
     */
    public static function canDelete(Model $record): bool
    {
        return false;
    }

    /**
     * Interdit la suppression en masse.
     *
     * @return bool
     */
    public static function canDeleteAny(): bool
    {
        return false;
    }
}
