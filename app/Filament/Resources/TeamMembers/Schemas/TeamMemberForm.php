<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profil')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Nom affiché')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Ex. tothy-mbengela → /equipe/tothy-mbengela'),
                        TextInput::make('role')
                            ->label('Fonction')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('excerpt')
                            ->label('Accroche (liste À propos)')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('body')
                            ->label('Biographie (page détail)')
                            ->rows(10)
                            ->columnSpanFull(),
                        FileUpload::make('photo_path')
                            ->label('Photo')
                            ->image()
                            ->disk('public')
                            ->directory('team/photos')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                        TextInput::make('profile_url')
                            ->label('Lien principal (clic sur la photo)')
                            ->url()
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
                Section::make('Réseaux sociaux')
                    ->columns(2)
                    ->components([
                        TextInput::make('social_facebook')->label('Facebook')->url()->maxLength(255)->nullable(),
                        TextInput::make('social_youtube')->label('YouTube')->url()->maxLength(255)->nullable(),
                        TextInput::make('social_instagram')->label('Instagram')->url()->maxLength(255)->nullable(),
                        TextInput::make('social_tiktok')->label('TikTok')->url()->maxLength(255)->nullable(),
                    ]),
                Section::make('Publication')
                    ->columns(2)
                    ->components([
                        TextInput::make('sort_order')
                            ->label('Ordre')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Visible sur le site')
                            ->default(true),
                    ]),
            ]);
    }
}
