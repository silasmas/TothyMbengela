<?php

namespace App\Filament\Resources\Themes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ThemeForm
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
                            ->directory('themes/vignettes')
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
                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Textarea::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
