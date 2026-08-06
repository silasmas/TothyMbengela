<?php

namespace App\Filament\Resources\ShopSettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Table Filament des paramètres boutique.
 */
class ShopSettingsTable
{
    /**
     * Configure les colonnes de la liste.
     *
     * @param  Table  $table  Table Filament
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('usd_to_cdf_rate')
                    ->label('1 USD = … CDF')
                    ->sortable(),
                TextColumn::make('default_currency')
                    ->label('Devise défaut')
                    ->badge(),
                IconColumn::make('allow_currency_switch')
                    ->label('Choix client')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Mis à jour')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->paginated(false);
    }
}
