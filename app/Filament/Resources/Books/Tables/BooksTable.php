<?php

namespace App\Filament\Resources\Books\Tables;

use App\Models\Book;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

/**
 * Table Filament listant les produits boutique (avec aperçu photo).
 */
class BooksTable
{
    /**
     * Configure les colonnes, filtres et actions de la liste produits.
     *
     * @param  Table  $table  Table Filament
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('sort_order')
                    ->label('Pos.')
                    ->sortable()
                    ->width('4rem'),
                ImageColumn::make('cover_path')
                    ->label('Photo')
                    ->disk('public')
                    ->circular(false)
                    ->square()
                    ->height(56)
                    ->defaultImageUrl(asset('assets/images/resource/about-1.jpg')),
                ImageColumn::make('gallery_paths')
                    ->label('Galerie')
                    ->disk('public')
                    ->circular(false)
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->height(40)
                    ->toggleable(),
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('product_type')
                    ->label('Type')
                    ->formatStateUsing(fn (?string $state): string => Book::productTypeLabels()[$state ?? Book::TYPE_BOOK] ?? $state ?? '—')
                    ->badge()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('price')
                    ->label('Prix (USD)')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('currency')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('digital_file_path')
                    ->label('Fichier numérique')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('isbn')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
                IconColumn::make('is_featured')
                    ->label('À la une')
                    ->boolean(),
                TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('product_type')
                    ->label('Type')
                    ->options(Book::productTypeLabels()),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
