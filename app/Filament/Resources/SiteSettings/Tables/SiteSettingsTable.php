<?php

namespace App\Filament\Resources\SiteSettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Table des paramètres du site (une ligne).
 */
class SiteSettingsTable
{
    /**
     * Configure la liste.
     *
     * @param  Table  $table  Table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->label('E-mail')
                    ->placeholder('—'),
                TextColumn::make('phone')
                    ->label('Téléphone')
                    ->placeholder('—'),
                TextColumn::make('slogan')
                    ->label('Slogan')
                    ->limit(40)
                    ->placeholder('—'),
                TextColumn::make('updated_at')
                    ->label('Mis à jour')
                    ->dateTime(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->paginated(false);
    }
}
