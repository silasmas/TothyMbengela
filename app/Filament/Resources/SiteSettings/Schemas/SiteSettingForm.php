<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Formulaire des infos de base du site.
 */
class SiteSettingForm
{
    /**
     * Configure le formulaire contact / slogan / réseaux.
     *
     * @param  Schema  $schema  Schéma Filament
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Coordonnées')
                    ->columns(2)
                    ->components([
                        TextInput::make('phone')
                            ->label('Téléphone')
                            ->tel()
                            ->maxLength(80),
                        TextInput::make('email')
                            ->label('E-mail public')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('address')
                            ->label('Adresse')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('slogan')
                            ->label('Slogan / texte « À propos » (footer)')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                Section::make('Réseaux sociaux')
                    ->columns(2)
                    ->components([
                        TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(500),
                        TextInput::make('youtube_url')
                            ->label('YouTube')
                            ->url()
                            ->maxLength(500),
                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(500),
                        TextInput::make('tiktok_url')
                            ->label('TikTok')
                            ->url()
                            ->maxLength(500),
                        TextInput::make('whatsapp_url')
                            ->label('WhatsApp (lien wa.me)')
                            ->url()
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
