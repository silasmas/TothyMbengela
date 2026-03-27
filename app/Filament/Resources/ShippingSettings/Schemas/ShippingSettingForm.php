<?php

namespace App\Filament\Resources\ShippingSettings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ShippingSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Livraison boutique')
                    ->description('Activez l’option sur le site et définissez les tarifs : pays « national » (ex. RDC = CD) vs autres pays. Au paiement, le client indique aussi son adresse détaillée et un numéro de contact pour la livraison.')
                    ->columns(2)
                    ->components([
                        Toggle::make('is_active')
                            ->label('Proposer la livraison sur le site')
                            ->helperText('Si désactivé, le client ne voit pas l’option au paiement.')
                            ->columnSpanFull(),
                        TextInput::make('domestic_country_code')
                            ->label('Code pays « national » (ISO 2)')
                            ->required()
                            ->maxLength(2)
                            ->placeholder('CD')
                            ->helperText('Ex. CD pour la RDC : toutes les villes de ce pays (Lubumbashi, Kinshasa, etc.) utilisent le tarif national.')
                            ->columnSpanFull(),
                        TextInput::make('price_domestic')
                            ->label('Frais — pays national')
                            ->numeric()
                            ->required()
                            ->step(0.01)
                            ->suffix(fn ($get) => $get('currency') ?: 'USD'),
                        TextInput::make('price_international')
                            ->label('Frais — hors pays national')
                            ->numeric()
                            ->required()
                            ->step(0.01)
                            ->suffix(fn ($get) => $get('currency') ?: 'USD'),
                        TextInput::make('currency')
                            ->label('Devise des frais')
                            ->required()
                            ->default('USD')
                            ->maxLength(3)
                            ->helperText('À aligner avec la devise des livres (souvent USD).')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
