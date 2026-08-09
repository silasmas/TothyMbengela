<?php

namespace App\Filament\Resources\Slides\Schemas;

use App\Models\Slide;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

/**
 * Formulaire de création / édition d’une slide d’accueil (indépendante des produits).
 */
class SlideForm
{
    /**
     * Configure les champs du formulaire slide.
     *
     * @param  Schema  $schema  Schéma Filament
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Slide')
                    ->description('Chaque slide est indépendante : titre, texte et image sont définis ici (pas via la fiche produit).')
                    ->columns(2)
                    ->components([
                        TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('subtitle')
                            ->label('Sous-titre')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('body')
                            ->label('Texte')
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('image_path')
                            ->label('Image de fond')
                            ->image()
                            ->disk('public')
                            ->directory('slides')
                            ->visibility('public')
                            ->imageEditor()
                            ->helperText('Uploadez une image propre à cette slide (recommandé).')
                            ->columnSpanFull(),
                        Select::make('slide_type')
                            ->label('Catégorie')
                            ->options(Slide::typeLabels())
                            ->required()
                            ->native(false)
                            ->default(Slide::TYPE_CUSTOM),
                        TextInput::make('sort_order')
                            ->label('Ordre d’affichage')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Visible sur le site')
                            ->default(true)
                            ->columnSpanFull(),
                    ]),
                Section::make('Boutons d’action')
                    ->description('Choisissez les actions des boutons. « Panier » / « Acheter » demandent un produit cible (sans transformer le produit en slide).')
                    ->columns(2)
                    ->components([
                        Select::make('primary_action')
                            ->label('Action principale')
                            ->options(Slide::actionLabels())
                            ->required()
                            ->live()
                            ->native(false)
                            ->default(Slide::ACTION_NONE),
                        TextInput::make('primary_label')
                            ->label('Libellé bouton principal')
                            ->maxLength(80)
                            ->placeholder('Ex. Découvrir'),
                        TextInput::make('primary_url')
                            ->label('URL action principale')
                            ->maxLength(500)
                            ->visible(fn (Get $get): bool => $get('primary_action') === Slide::ACTION_LINK)
                            ->url(),
                        Select::make('secondary_action')
                            ->label('Action secondaire')
                            ->options(Slide::actionLabels())
                            ->required()
                            ->live()
                            ->native(false)
                            ->default(Slide::ACTION_NONE),
                        TextInput::make('secondary_label')
                            ->label('Libellé bouton secondaire')
                            ->maxLength(80),
                        TextInput::make('secondary_url')
                            ->label('URL action secondaire')
                            ->maxLength(500)
                            ->visible(fn (Get $get): bool => $get('secondary_action') === Slide::ACTION_LINK)
                            ->url(),
                        Select::make('book_id')
                            ->label('Produit cible (panier / acheter)')
                            ->relationship(
                                name: 'book',
                                titleAttribute: 'title',
                                modifyQueryUsing: fn ($query) => $query->where('is_active', true)->orderedForDisplay(),
                            )
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->visible(fn (Get $get): bool => Slide::actionNeedsProduct($get('primary_action'))
                                || Slide::actionNeedsProduct($get('secondary_action')))
                            ->required(fn (Get $get): bool => Slide::actionNeedsProduct($get('primary_action'))
                                || Slide::actionNeedsProduct($get('secondary_action')))
                            ->helperText('Utilisé uniquement pour les boutons Panier / Acheter.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
