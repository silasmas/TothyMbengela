<?php

namespace App\Filament\Resources\Books\Schemas;

use App\Models\Book;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Formulaire Filament de création / édition d’un produit boutique.
 */
class BookForm
{
    /**
     * Configure les champs du formulaire produit.
     *
     * @param  Schema  $schema  Schéma Filament
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Produit')
                    ->columns(2)
                    ->components([
                        TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Select::make('product_type')
                            ->label('Type de produit')
                            ->options(Book::productTypeLabels())
                            ->required()
                            ->default(Book::TYPE_BOOK)
                            ->native(false),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Textarea::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                        TextInput::make('price')
                            ->label('Prix (USD)')
                            ->required()
                            ->numeric()
                            ->step(0.01)
                            ->helperText('Toujours en USD. La conversion CDF utilise le taux des paramètres boutique.'),
                        TextInput::make('currency')
                            ->label('Devise de référence')
                            ->required()
                            ->default('USD')
                            ->maxLength(3)
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('isbn')
                            ->label('ISBN / Référence')
                            ->maxLength(255),
                        TextInput::make('stock_quantity')
                            ->label('Stock (vide = illimité)')
                            ->numeric()
                            ->minValue(0),
                        Toggle::make('is_active')
                            ->label('Actif à la vente')
                            ->default(true),
                        Toggle::make('is_featured')
                            ->label('Mis en avant (modale d’accueil)')
                            ->default(false),
                    ]),
                Section::make('Images')
                    ->components([
                        FileUpload::make('cover_path')
                            ->label('Image principale / couverture')
                            ->image()
                            ->disk('public')
                            ->directory('books/covers')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                        FileUpload::make('gallery_paths')
                            ->label('Galerie (autres images)')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->disk('public')
                            ->directory('books/gallery')
                            ->visibility('public')
                            ->imageEditor()
                            ->helperText('Vous pouvez ajouter plusieurs photos du produit.')
                            ->columnSpanFull(),
                        FileUpload::make('digital_file_path')
                            ->label('Fichier numérique (PDF / e-book)')
                            ->disk('public')
                            ->directory('books/digital')
                            ->visibility('public')
                            ->acceptedFileTypes(['application/pdf'])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
