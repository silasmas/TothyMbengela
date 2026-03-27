<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Contents\ContentResource;
use App\Filament\Resources\Rubriques\RubriqueResource;
use App\Filament\Resources\Series\SeriesResource;
use App\Filament\Resources\Themes\ThemeResource;
use App\Models\Content;
use App\Models\Rubrique;
use App\Models\Series;
use App\Models\Theme;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContenuMinistereStatsWidget extends BaseWidget
{
    protected static ?int $sort = -10;

    protected ?string $heading = 'Contenu ministère';

    protected ?string $description = 'Vue d’ensemble des rubriques, thèmes, séries et contenus.';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $published = Content::query()->where('is_published', true)->count();

        return [
            Stat::make('Rubriques', Rubrique::query()->count())
                ->description('Sections principales')
                ->icon(Heroicon::OutlinedSquares2x2)
                ->url(RubriqueResource::getUrl()),
            Stat::make('Thèmes', Theme::query()->count())
                ->description('Filtres transverses')
                ->icon(Heroicon::OutlinedTag)
                ->url(ThemeResource::getUrl()),
            Stat::make('Séries', Series::query()->count())
                ->description('Regroupements par rubrique')
                ->icon(Heroicon::OutlinedQueueList)
                ->url(SeriesResource::getUrl()),
            Stat::make('Contenus', Content::query()->count())
                ->description($published.' publié'.($published > 1 ? 's' : ''))
                ->icon(Heroicon::OutlinedPlayCircle)
                ->url(ContentResource::getUrl()),
        ];
    }
}
