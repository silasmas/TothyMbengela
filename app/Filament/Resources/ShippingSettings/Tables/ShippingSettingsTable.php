<?php

namespace App\Filament\Resources\ShippingSettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShippingSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
                TextColumn::make('domestic_country_code')
                    ->label('Pays national (ISO)')
                    ->searchable(),
                TextColumn::make('price_domestic')
                    ->label('Tarif national')
                    ->numeric(decimalPlaces: 2),
                TextColumn::make('price_international')
                    ->label('Tarif international')
                    ->numeric(decimalPlaces: 2),
                TextColumn::make('currency')
                    ->label('Devise'),
                TextColumn::make('updated_at')
                    ->label('Mis à jour')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}
