<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Books\BookResource;
use App\Filament\Resources\Orders\OrderResource;
use App\Models\Book;
use App\Models\Order;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BoutiqueStatsWidget extends BaseWidget
{
    protected static ?int $sort = -9;

    protected ?string $heading = 'Boutique';

    protected ?string $description = 'Livres et commandes.';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $pendingOrders = Order::query()->where('status', 'pending')->count();

        return [
            Stat::make('Livres', Book::query()->count())
                ->description('Titres au catalogue')
                ->icon(Heroicon::OutlinedBookOpen)
                ->url(BookResource::getUrl()),
            Stat::make('Commandes', Order::query()->count())
                ->description($pendingOrders.' en attente')
                ->icon(Heroicon::OutlinedShoppingCart)
                ->url(OrderResource::getUrl()),
        ];
    }
}
