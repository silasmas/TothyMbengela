<?php

namespace App\Filament\Resources\ShopSettings;

use App\Filament\Resources\ShopSettings\Pages\CreateShopSetting;
use App\Filament\Resources\ShopSettings\Pages\EditShopSetting;
use App\Filament\Resources\ShopSettings\Pages\ListShopSettings;
use App\Filament\Resources\ShopSettings\Schemas\ShopSettingForm;
use App\Filament\Resources\ShopSettings\Tables\ShopSettingsTable;
use App\Models\ShopSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/**
 * Ressource Filament des paramètres boutique (taux USD/CDF).
 */
class ShopSettingResource extends Resource
{
    protected static ?string $model = ShopSetting::class;

    protected static ?string $recordTitleAttribute = 'id';

    protected static string|\UnitEnum|null $navigationGroup = 'Boutique';

    protected static ?int $navigationSort = 12;

    protected static ?string $modelLabel = 'paramètre boutique';

    protected static ?string $pluralModelLabel = 'paramètres boutique';

    protected static ?string $navigationLabel = 'Devises (USD/CDF)';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    /**
     * Formulaire.
     *
     * @param  Schema  $schema  Schéma Filament
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return ShopSettingForm::configure($schema);
    }

    /**
     * Table liste.
     *
     * @param  Table  $table  Table Filament
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return ShopSettingsTable::configure($table);
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
     * Pages de la ressource.
     *
     * @return array<string, mixed>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListShopSettings::route('/'),
            'create' => CreateShopSetting::route('/create'),
            'edit' => EditShopSetting::route('/{record}/edit'),
        ];
    }

    /**
     * Une seule ligne de paramètres.
     *
     * @return bool
     */
    public static function canCreate(): bool
    {
        return ShopSetting::query()->count() === 0;
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
