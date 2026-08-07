<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Formulaire de création / édition d’un administrateur Filament.
 */
class AdminForm
{
    /**
     * Configure les champs du formulaire admin.
     *
     * @param  Schema  $schema  Schéma Filament
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Compte administrateur')
                    ->description('Ces comptes se connectent uniquement sur /admin (pas via /login du site public).')
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
                        TextInput::make('password')
                            ->label('Mot de passe')
                            ->password()
                            ->revealable()
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn ($livewire): bool => $livewire instanceof CreateRecord)
                            ->helperText('À l’édition, laisser vide pour conserver le mot de passe actuel.')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Select::make('roles')
                            ->label('Rôles')
                            ->relationship(
                                name: 'roles',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->where('guard_name', 'admin')->orderBy('name'),
                            )
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->helperText('Attribuez au moins « super_admin » pour un accès complet au tableau de bord.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
