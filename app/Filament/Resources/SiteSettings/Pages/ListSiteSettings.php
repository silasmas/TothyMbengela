<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

/**
 * Liste / accès aux infos du site.
 */
class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingResource::class;

    /**
     * Actions d’en-tête.
     *
     * @return array<int, mixed>
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn (): bool => SiteSetting::query()->count() === 0),
        ];
    }

    /**
     * Redirige vers l’édition s’il n’y a qu’une fiche.
     *
     * @return void
     */
    public function mount(): void
    {
        parent::mount();

        $row = SiteSetting::instance();
        $this->redirect(SiteSettingResource::getUrl('edit', ['record' => $row]));
    }
}
