<?php

namespace App\Filament\Resources\Contents\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations principales')
                    ->columns(2)
                    ->components([
                        Select::make('rubrique_id')
                            ->label('Rubrique')
                            ->relationship('rubrique', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('series_id')
                            ->label('Série')
                            ->relationship('series', 'title')
                            ->searchable()
                            ->preload()
                            ->helperText('Choisissez une série de la même rubrique lorsque c’est pertinent.'),
                        Select::make('theme_id')
                            ->label('Thème')
                            ->relationship('theme', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('type')
                            ->label('Type de contenu')
                            ->options([
                                'video' => 'Vidéo',
                                'audio' => 'Audio',
                                'podcast' => 'Podcast',
                                'article' => 'Article',
                            ])
                            ->required()
                            ->native(false),
                        Select::make('source')
                            ->label('Origine du média')
                            ->options([
                                'internal' => 'Interne (fichier / URL maison)',
                                'youtube' => 'YouTube',
                                'external' => 'Autre hébergeur',
                            ])
                            ->default('internal')
                            ->required()
                            ->native(false)
                            ->helperText('Utilisez « YouTube » pour les vidéos hébergées sur la chaîne.'),
                        TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                        Textarea::make('excerpt')
                            ->label('Accroche')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                Section::make('Média et vignette')
                    ->columns(2)
                    ->description('Liens vers le fichier ou YouTube, et image d’aperçu optionnelle.')
                    ->components([
                        TextInput::make('youtube_video_id')
                            ->label('Identifiant vidéo YouTube')
                            ->maxLength(32)
                            ->helperText('Partie après v= dans l’URL (souvent 11 caractères).'),
                        TextInput::make('youtube_url')
                            ->label('Lien YouTube')
                            ->url()
                            ->columnSpanFull(),
                        TextInput::make('media_url')
                            ->label('URL du média (hors YouTube)')
                            ->url()
                            ->columnSpanFull(),
                        TextInput::make('file_path')
                            ->label('Chemin fichier (stockage local)')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        FileUpload::make('thumbnail_path')
                            ->label('Vignette')
                            ->image()
                            ->disk('public')
                            ->directory('contenus/vignettes')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),
                Section::make('Publication')
                    ->columns(2)
                    ->components([
                        Toggle::make('is_published')
                            ->label('Publié')
                            ->default(false),
                        DateTimePicker::make('published_at')
                            ->label('Date de publication')
                            ->seconds(false),
                        Toggle::make('is_featured')
                            ->label('À la une')
                            ->default(false),
                        TextInput::make('position')
                            ->label('Ordre d’affichage')
                            ->numeric()
                            ->default(0),
                    ]),
                Section::make('Paramètres avancés')
                    ->collapsed()
                    ->columns(2)
                    ->components([
                        Textarea::make('body')
                            ->label('Texte / description longue')
                            ->rows(8)
                            ->columnSpanFull(),
                        TextInput::make('duration_seconds')
                            ->label('Durée (secondes)')
                            ->numeric()
                            ->minValue(0),
                        Toggle::make('allow_streaming')
                            ->label('Lecture en ligne autorisée')
                            ->default(true),
                        Toggle::make('allow_download')
                            ->label('Téléchargement autorisé')
                            ->default(false),
                        Textarea::make('meta')
                            ->label('Métadonnées (JSON)')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('JSON optionnel ; laisser vide si inutile.')
                            ->formatStateUsing(fn ($state) => match (true) {
                                is_array($state) => json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                                is_string($state) => $state,
                                default => '',
                            })
                            ->dehydrateStateUsing(function (?string $state): ?array {
                                if (blank($state)) {
                                    return null;
                                }
                                try {
                                    return json_decode($state, true, 512, JSON_THROW_ON_ERROR);
                                } catch (\JsonException) {
                                    return null;
                                }
                            }),
                    ]),
            ]);
    }
}
