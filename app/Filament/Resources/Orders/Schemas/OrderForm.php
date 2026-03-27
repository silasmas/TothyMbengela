<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('user_id')
                    ->label('Utilisateur')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('guest_email')
                    ->label('E-mail invité')
                    ->email(),
                TextInput::make('guest_phone')
                    ->label('Téléphone invité')
                    ->tel(),
                Select::make('status')
                    ->label('Statut commande')
                    ->options([
                        'pending' => 'En attente',
                        'paid' => 'Payée',
                        'cancelled' => 'Annulée',
                        'refunded' => 'Remboursée',
                    ])
                    ->default('pending')
                    ->required()
                    ->native(false),
                TextInput::make('subtotal')
                    ->label('Sous-total articles')
                    ->required()
                    ->numeric()
                    ->step(0.01),
                TextInput::make('grand_total')
                    ->label('Total à payer (articles + livraison)')
                    ->numeric()
                    ->step(0.01)
                    ->helperText('Montant envoyé au paiement. Laisser cohérent avec sous-total + frais de livraison.'),
                Toggle::make('shipping_opt_in')
                    ->label('Livraison demandée')
                    ->columnSpanFull(),
                TextInput::make('shipping_country')
                    ->label('Pays livraison (ISO2)')
                    ->maxLength(2),
                TextInput::make('shipping_city')
                    ->label('Ville livraison')
                    ->maxLength(120)
                    ->columnSpanFull(),
                Textarea::make('shipping_address')
                    ->label('Adresse de livraison (complète)')
                    ->rows(4)
                    ->maxLength(2000)
                    ->columnSpanFull(),
                TextInput::make('shipping_phone')
                    ->label('Téléphone contact livraison')
                    ->tel()
                    ->maxLength(40),
                TextInput::make('shipping_cost')
                    ->label('Frais de livraison')
                    ->numeric()
                    ->step(0.01),
                TextInput::make('currency')
                    ->label('Devise')
                    ->required()
                    ->default('USD')
                    ->maxLength(3),
                Select::make('payment_status')
                    ->label('Statut paiement')
                    ->options([
                        'pending' => 'En attente',
                        'completed' => 'Complété',
                        'failed' => 'Échoué',
                    ])
                    ->default('pending')
                    ->required()
                    ->native(false),
                TextInput::make('payment_method')
                    ->label('Moyen de paiement')
                    ->maxLength(255),
                TextInput::make('payment_reference')
                    ->label('Référence paiement')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->label('Notes')
                    ->columnSpanFull(),
            ]);
    }
}
