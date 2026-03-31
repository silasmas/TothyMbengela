<?php

namespace App\Filament\Resources\PastorActivities\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PastorActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Activité')
                    ->columns(2)
                    ->components([
                        TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Laissez vide à la création : généré à partir du titre. Ex. /activites-pasteure/mon-slug')
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Description / texte d’affiche')
                            ->rows(6)
                            ->columnSpanFull(),
                        TextInput::make('location')
                            ->label('Lieu')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        DateTimePicker::make('starts_at')
                            ->label('Début')
                            ->required()
                            ->seconds(false)
                            ->native(false),
                        DateTimePicker::make('ends_at')
                            ->label('Fin (optionnel)')
                            ->seconds(false)
                            ->native(false)
                            ->helperText('Vide = journée du début (jusqu’à minuit).'),
                    ]),
                Section::make('Visuels et spot')
                    ->columns(2)
                    ->components([
                        FileUpload::make('poster_path')
                            ->label('Affiche')
                            ->image()
                            ->disk('public')
                            ->directory('pastor-activities/posters')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                        FileUpload::make('spot_image_path')
                            ->label('Image du spot (optionnel)')
                            ->image()
                            ->disk('public')
                            ->directory('pastor-activities/spots')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                        TextInput::make('spot_url')
                            ->label('Lien du spot (vidéo, réseau…)')
                            ->url()
                            ->maxLength(2048)
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
                Section::make('Publication')
                    ->columns(2)
                    ->components([
                        TextInput::make('sort_order')
                            ->label('Ordre d’affichage')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_published')
                            ->label('Publié sur le site')
                            ->default(true),
                    ]),
            ]);
    }
}
