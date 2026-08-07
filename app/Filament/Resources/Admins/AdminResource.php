<?php

namespace App\Filament\Resources\Admins;

use App\Filament\Resources\Admins\Pages\CreateAdmin;
use App\Filament\Resources\Admins\Pages\EditAdmin;
use App\Filament\Resources\Admins\Pages\ListAdmins;
use App\Filament\Resources\Admins\Schemas\AdminForm;
use App\Filament\Resources\Admins\Tables\AdminsTable;
use App\Models\Admin;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

/**
 * Gestion des comptes administrateurs Filament (table admins, guard admin).
 */
class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'administrateur';

    protected static ?string $pluralModelLabel = 'administrateurs';

    protected static ?string $navigationLabel = 'Administrateurs';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    /**
     * Badge compteur dans la navigation.
     *
     * @return string|null
     */
    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    /**
     * Formulaire administrateur.
     *
     * @param  Schema  $schema  Schéma Filament
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return AdminForm::configure($schema);
    }

    /**
     * Table des administrateurs.
     *
     * @param  Table  $table  Table Filament
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return AdminsTable::configure($table);
    }

    /**
     * Attributs recherchables globalement.
     *
     * @return array<int, string>
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
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
            'index' => ListAdmins::route('/'),
            'create' => CreateAdmin::route('/create'),
            'edit' => EditAdmin::route('/{record}/edit'),
        ];
    }
}
