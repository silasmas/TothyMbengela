<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\EditAdminProfile;
use App\Http\Middleware\SetFilamentAdminLocale;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Configuration du panel Filament admin (charte Alliance).
 */
class AdminPanelProvider extends PanelProvider
{
    /**
     * Déclare le panel /admin (login, couleurs, logos, hooks).
     *
     * @param  Panel  $panel  Instance Filament
     * @return Panel
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->authGuard('admin')
            ->authPasswordBroker('admins')
            ->brandName('Alliance')
            ->brandLogo(asset('assets/logo/alliance-wordmark-ochre-on-white.png'))
            ->darkModeBrandLogo(asset('assets/logo/alliance-wordmark-gold-transparent.png'))
            ->brandLogoHeight('2.75rem')
            ->favicon(asset('assets/logo/logo-alliance-mark.png'))
            ->font('Source Sans 3')
            ->profile(page: EditAdminProfile::class, isSimple: false)
            ->colors([
                'primary' => Color::hex('#A86C3C'),
                'warning' => Color::hex('#C9A25A'),
                'info' => Color::hex('#845430'),
                'success' => Color::hex('#5F6B4A'),
                'danger' => Color::hex('#A33B2B'),
                'gray' => Color::Zinc,
            ])
            ->globalSearch()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->globalSearchFieldKeyBindingSuffix()
            ->sidebarCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn (): string => view('filament.hooks.admin-brand-head')->render(),
            )
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn (): string => view('filament.hooks.admin-styles')->render(),
            )
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn (): string => view('filament.hooks.admin-footer')->render(),
            )
            ->renderHook(
                PanelsRenderHook::SIDEBAR_FOOTER,
                fn (): string => view('filament.hooks.admin-sidebar-footer')->render(),
            )
            ->renderHook(
                PanelsRenderHook::SCRIPTS_AFTER,
                fn (): string => view('filament.hooks.shepherd-tour')->render(),
            )
            ->middleware([
                SetFilamentAdminLocale::class,
            ], isPersistent: true)
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
