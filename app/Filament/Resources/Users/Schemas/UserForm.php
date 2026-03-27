<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                DateTimePicker::make('email_verified_at')
                    ->label('E-mail vérifié le'),
                TextInput::make('password')
                    ->label('Mot de passe')
                    ->password()
                    ->revealable()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn ($livewire): bool => $livewire instanceof CreateRecord)
                    ->helperText('À l’édition, laisser vide pour ne pas changer le mot de passe.')
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Téléphone')
                    ->tel(),
                TextInput::make('whatsapp')
                    ->label('WhatsApp'),
                TextInput::make('country')
                    ->label('Pays'),
                TextInput::make('city')
                    ->label('Ville'),
                TextInput::make('address_line')
                    ->label('Adresse')
                    ->columnSpanFull(),
                Textarea::make('bio')
                    ->label('Biographie')
                    ->columnSpanFull(),
                TextInput::make('avatar_path')
                    ->label('Chemin avatar'),
                TextInput::make('preferred_locale')
                    ->label('Langue')
                    ->required()
                    ->default('fr')
                    ->maxLength(10),
                DatePicker::make('birthdate')
                    ->label('Date de naissance'),
                TextInput::make('gender')
                    ->label('Genre / civilité')
                    ->maxLength(32),
            ]);
    }
}
