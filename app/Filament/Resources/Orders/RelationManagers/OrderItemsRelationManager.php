<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    protected static ?string $title = 'Lignes de commande';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('book_id')
                    ->label('Livre')
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('quantity')
                    ->label('Quantité')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->default(1),
                TextInput::make('unit_price')
                    ->label('Prix unitaire')
                    ->numeric()
                    ->required()
                    ->step(0.01),
                TextInput::make('line_total')
                    ->label('Total ligne')
                    ->numeric()
                    ->required()
                    ->step(0.01)
                    ->helperText('En général : quantité × prix unitaire (saisie manuelle pour arrondis).'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('book.title')
                    ->label('Livre')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Qté')
                    ->alignCenter(),
                TextColumn::make('unit_price')
                    ->label('Prix unit.')
                    ->numeric(decimalPlaces: 2),
                TextColumn::make('line_total')
                    ->label('Total')
                    ->numeric(decimalPlaces: 2),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
