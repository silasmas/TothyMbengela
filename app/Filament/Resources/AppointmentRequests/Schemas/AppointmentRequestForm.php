<?php

namespace App\Filament\Resources\AppointmentRequests\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AppointmentRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->label('Téléphone')
                    ->tel()
                    ->required(),
                DatePicker::make('preferred_date')
                    ->label('Date souhaitée'),
                TimePicker::make('preferred_time')
                    ->label('Heure souhaitée'),
                Textarea::make('message')
                    ->label('Message')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmé',
                        'cancelled' => 'Annulé',
                        'completed' => 'Terminé',
                    ])
                    ->default('pending')
                    ->required()
                    ->native(false),
                Textarea::make('admin_notes')
                    ->label('Notes internes')
                    ->columnSpanFull(),
            ]);
    }
}
