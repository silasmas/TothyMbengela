<?php

namespace App\Filament\Resources\ShopSettings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Formulaire des paramètres devises boutique.
 */
class ShopSettingForm
{
    /**
     * Configure le formulaire taux USD/CDF.
     *
     * @param  Schema  $schema  Schéma Filament
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Devises boutique')
                    ->description('Les prix produits sont saisis en USD. Le taux convertit vers le CDF au panier et au paiement.')
                    ->columns(2)
                    ->components([
                        TextInput::make('usd_to_cdf_rate')
                            ->label('Taux : 1 USD = ? CDF')
                            ->numeric()
                            ->required()
                            ->step(0.0001)
                            ->minValue(1)
                            ->helperText('Ex. 2850 → 10 USD = 28 500 CDF')
                            ->columnSpanFull(),
                        Select::make('default_currency')
                            ->label('Devise par défaut sur le site')
                            ->options([
                                'USD' => 'USD (dollar)',
                                'CDF' => 'CDF (franc congolais)',
                            ])
                            ->required()
                            ->native(false),
                        Toggle::make('allow_currency_switch')
                            ->label('Autoriser le choix USD / CDF pour le client')
                            ->default(true),
                    ]),
            ]);
    }
}
