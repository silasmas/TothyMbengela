<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Utilisateur')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('guest_email')
                    ->searchable(),
                TextColumn::make('guest_phone')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Commande')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => match ($state ?? '') {
                        'pending' => 'En attente',
                        'paid' => 'Payée',
                        'cancelled' => 'Annulée',
                        'refunded' => 'Remboursée',
                        default => (string) $state,
                    })
                    ->color(fn ($state): string => match ($state ?? '') {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'cancelled', 'refunded' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('subtotal')
                    ->label('Sous-total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('shipping_cost')
                    ->label('Livraison')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('grand_total')
                    ->label('Total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('currency')
                    ->searchable(),
                TextColumn::make('payment_status')
                    ->label('Paiement')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => match ($state ?? '') {
                        'pending' => 'En attente',
                        'completed' => 'Payé',
                        'failed' => 'Échoué',
                        'processing' => 'En cours',
                        default => (string) $state,
                    })
                    ->color(fn ($state): string => match ($state ?? '') {
                        'pending', 'processing' => 'warning',
                        'completed' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->searchable(),
                TextColumn::make('payment_reference')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
