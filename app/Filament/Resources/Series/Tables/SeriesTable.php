<?php

namespace App\Filament\Resources\Series\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail_path')
                    ->label('Vignette')
                    ->disk('public')
                    ->height(40)
                    ->width(64)
                    ->defaultImageUrl('https://placehold.co/64x40/e2e8f0/64748b?text=—'),
                TextColumn::make('icon')
                    ->label('Icône')
                    ->limit(24)
                    ->placeholder('—'),
                TextColumn::make('rubrique.name')
                    ->label('Rubrique')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('theme.name')
                    ->label('Thème')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug (URL)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Ordre')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Créée le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Mise à jour')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->label('Modifier'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Supprimer'),
                ])->label('Actions groupées'),
            ]);
    }
}
