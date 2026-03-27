<?php

namespace App\Filament\Resources\Donations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DonationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('donor_name')
                    ->label('Nom du donateur'),
                TextInput::make('donor_email')
                    ->label('E-mail')
                    ->email(),
                TextInput::make('donor_phone')
                    ->label('Téléphone')
                    ->tel(),
                TextInput::make('amount')
                    ->label('Montant')
                    ->required()
                    ->numeric()
                    ->step(0.01),
                TextInput::make('currency')
                    ->label('Devise')
                    ->required()
                    ->default('USD')
                    ->maxLength(3),
                Select::make('frequency')
                    ->label('Fréquence')
                    ->options([
                        'once' => 'Ponctuel',
                        'monthly' => 'Mensuel',
                    ])
                    ->default('once')
                    ->required()
                    ->native(false),
                Toggle::make('is_anonymous')
                    ->label('Don anonyme')
                    ->default(false),
                Textarea::make('message')
                    ->label('Message')
                    ->columnSpanFull(),
                TextInput::make('payment_provider')
                    ->label('Passerelle de paiement'),
                TextInput::make('external_payment_id')
                    ->label('ID transaction externe')
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'completed' => 'Complété',
                        'failed' => 'Échoué',
                        'refunded' => 'Remboursé',
                    ])
                    ->default('pending')
                    ->required()
                    ->native(false),
            ]);
    }
}
