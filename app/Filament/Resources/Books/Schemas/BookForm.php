<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->label('Prix')
                    ->required()
                    ->numeric()
                    ->step(0.01),
                TextInput::make('currency')
                    ->label('Devise')
                    ->required()
                    ->default('USD')
                    ->maxLength(3),
                TextInput::make('cover_path')
                    ->label('Couverture (chemin fichier)'),
                TextInput::make('digital_file_path')
                    ->label('Fichier numérique (chemin)')
                    ->columnSpanFull(),
                TextInput::make('isbn')
                    ->label('ISBN')
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->label('Actif à la vente')
                    ->default(true),
                TextInput::make('stock_quantity')
                    ->label('Stock (vide = illimité / numérique)')
                    ->numeric()
                    ->minValue(0),
            ]);
    }
}
