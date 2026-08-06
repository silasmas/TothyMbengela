<?php

namespace App\Filament\Resources\Slides\Tables;

use App\Models\Slide;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Table Filament des slides d’accueil.
 */
class SlidesTable
{
    /**
     * Configure la liste des slides.
     *
     * @param  Table  $table  Table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable(),
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public')
                    ->height(48),
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('slide_type')
                    ->label('Catégorie')
                    ->formatStateUsing(fn (?string $state): string => Slide::typeLabels()[$state ?? Slide::TYPE_CUSTOM] ?? ($state ?? '—'))
                    ->badge(),
                TextColumn::make('primary_action')
                    ->label('Action 1')
                    ->formatStateUsing(fn (?string $state): string => Slide::actionLabels()[$state ?? ''] ?? '—')
                    ->toggleable(),
                TextColumn::make('book.title')
                    ->label('Produit (CTA)')
                    ->placeholder('—')
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
