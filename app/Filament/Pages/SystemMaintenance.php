<?php

namespace App\Filament\Pages;

use App\Services\SystemMaintenanceService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * Page admin : migrations, seeders et lien storage.
 */
class SystemMaintenance extends Page
{
    protected string $view = 'filament.pages.system-maintenance';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|UnitEnum|null $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 100;

    protected static ?string $navigationLabel = 'Maintenance système';

    protected static ?string $title = 'Maintenance système';

    protected static ?string $slug = 'maintenance-systeme';

    /**
     * Accès réservé aux super_admin.
     *
     * @return bool
     */
    public static function canAccess(): bool
    {
        $admin = auth('admin')->user();

        return $admin !== null && method_exists($admin, 'hasRole') && $admin->hasRole('super_admin');
    }

    /**
     * Données affichées dans la vue.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $service = app(SystemMaintenanceService::class);

        return [
            'migrationStatus' => $service->migrationStatus(),
            'seederStatus' => $service->seederStatus(),
            'storageStatus' => $service->storageLinkStatus(),
        ];
    }

    /**
     * Actions d’en-tête.
     *
     * @return array<int, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('runMigrations')
                ->label('Exécuter les migrations')
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Exécuter les migrations ?')
                ->modalDescription('Lance `php artisan migrate --force` sur la base de production / locale.')
                ->action(fn () => $this->runMigrations()),
            Action::make('runPendingSeeders')
                ->label('Seeders en attente')
                ->icon('heroicon-o-circle-stack')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Exécuter les seeders non encore lancés ?')
                ->modalDescription('Seuls les seeders jamais marqués comme exécutés seront lancés.')
                ->action(fn () => $this->runPendingSeeders()),
            Action::make('storageLink')
                ->label('Activer storage:link')
                ->icon('heroicon-o-link')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Créer le lien public/storage ?')
                ->action(fn () => $this->createStorageLink()),
        ];
    }

    /**
     * Lance les migrations.
     *
     * @return void
     */
    public function runMigrations(): void
    {
        $result = app(SystemMaintenanceService::class)->runMigrations();
        $this->notifyResult('Migrations', $result['ok'], $result['output']);
    }

    /**
     * Lance tous les seeders en attente.
     *
     * @return void
     */
    public function runPendingSeeders(): void
    {
        $result = app(SystemMaintenanceService::class)->runPendingSeeders();
        $this->notifyResult('Seeders en attente', $result['ok'], $result['output']);
    }

    /**
     * Lance un seeder précis.
     *
     * @param  string  $seederClass  Classe du seeder
     * @return void
     */
    public function runOneSeeder(string $seederClass): void
    {
        $result = app(SystemMaintenanceService::class)->runSeeder($seederClass);
        $this->notifyResult('Seeder', $result['ok'], $result['output']);
    }

    /**
     * Crée le lien storage.
     *
     * @return void
     */
    public function createStorageLink(): void
    {
        $result = app(SystemMaintenanceService::class)->createStorageLink(false);
        $this->notifyResult('Lien storage', $result['ok'], $result['output']);
    }

    /**
     * Force la recréation du lien storage (remplace un dossier bloquant).
     *
     * @return void
     */
    public function forceStorageLink(): void
    {
        $result = app(SystemMaintenanceService::class)->createStorageLink(true);
        $this->notifyResult('Lien storage (forcé)', $result['ok'], $result['output']);
    }

    /**
     * Notification Filament + rafraîchissement.
     *
     * @param  string  $title  Titre
     * @param  bool  $ok  Succès
     * @param  string  $body  Détail
     * @return void
     */
    private function notifyResult(string $title, bool $ok, string $body): void
    {
        Notification::make()
            ->title($title.($ok ? ' — OK' : ' — erreur'))
            ->body(mb_substr($body, 0, 2000))
            ->{$ok ? 'success' : 'danger'}()
            ->persistent()
            ->send();
    }
}
