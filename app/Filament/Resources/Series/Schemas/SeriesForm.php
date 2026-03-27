<?php

namespace App\Filament\Resources\Series\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SeriesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Vignette et icône')
                    ->columns(2)
                    ->components([
                        FileUpload::make('thumbnail_path')
                            ->label('Vignette')
                            ->image()
                            ->disk('public')
                            ->directory('series/vignettes')
                            ->visibility('public')
                            ->imageEditor(),
                        TextInput::make('icon')
                            ->label('Icône')
                            ->helperText('Nom d’icône Heroicon ou chemin personnalisé.')
                            ->maxLength(255),
                    ]),
                Section::make('Informations générales')
                    ->columns(2)
                    ->components([
                        Select::make('rubrique_id')
                            ->label('Rubrique')
                            ->relationship('rubrique', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('theme_id')
                            ->label('Thème')
                            ->relationship('theme', 'name')
                            ->searchable()
                            ->preload(),
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
                        Textarea::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->label('Ordre d’affichage')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }
}
