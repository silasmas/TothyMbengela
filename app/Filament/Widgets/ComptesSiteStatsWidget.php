<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Users\UserResource;
use App\Models\Admin;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ComptesSiteStatsWidget extends BaseWidget
{
    protected static ?int $sort = -7;

    protected ?string $heading = 'Comptes';

    protected ?string $description = 'Utilisateurs du site et accès administration.';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        return [
            Stat::make('Utilisateurs', User::query()->count())
                ->description('Comptes publics')
                ->icon(Heroicon::OutlinedUserGroup)
                ->url(UserResource::getUrl()),
            Stat::make('Administrateurs', Admin::query()->count())
                ->description('Accès au panel admin')
                ->icon(Heroicon::OutlinedShieldCheck),
        ];
    }
}
