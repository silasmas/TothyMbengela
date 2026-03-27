<?php

namespace App\Filament\Resources\PartnerCommitments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PartnerCommitmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('user_id')
                    ->label('Utilisateur partenaire')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText('Le partenaire doit posséder un compte utilisateur (inscription sur le site).'),
                TextInput::make('monthly_amount')
                    ->label('Montant mensuel')
                    ->required()
                    ->numeric()
                    ->step(0.01),
                TextInput::make('currency')
                    ->label('Devise')
                    ->required()
                    ->default('USD')
                    ->maxLength(3),
                Textarea::make('message')
                    ->label('Message')
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'active' => 'Actif',
                        'paused' => 'En pause',
                        'ended' => 'Terminé',
                        'rejected' => 'Refusé',
                    ])
                    ->default('pending')
                    ->required()
                    ->native(false),
                TextInput::make('payment_reference')
                    ->label('Référence paiement')
                    ->columnSpanFull(),
            ]);
    }
}
