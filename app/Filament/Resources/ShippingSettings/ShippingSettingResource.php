<?php

namespace App\Filament\Resources\ShippingSettings;

use App\Filament\Resources\ShippingSettings\Pages\CreateShippingSetting;
use App\Filament\Resources\ShippingSettings\Pages\EditShippingSetting;
use App\Filament\Resources\ShippingSettings\Pages\ListShippingSettings;
use App\Filament\Resources\ShippingSettings\Schemas\ShippingSettingForm;
use App\Filament\Resources\ShippingSettings\Tables\ShippingSettingsTable;
use App\Models\ShippingSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ShippingSettingResource extends Resource
{
    protected static ?string $model = ShippingSetting::class;

    protected static ?string $recordTitleAttribute = 'id';

    protected static string|\UnitEnum|null $navigationGroup = 'Boutique';

    protected static ?int $navigationSort = 15;

    protected static ?string $modelLabel = 'frais de livraison';

    protected static ?string $pluralModelLabel = 'frais de livraison';

    protected static ?string $navigationLabel = 'Livraison';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    public static function form(Schema $schema): Schema
    {
        return ShippingSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShippingSettingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShippingSettings::route('/'),
            'create' => CreateShippingSetting::route('/create'),
            'edit' => EditShippingSetting::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return ShippingSetting::query()->count() === 0;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
