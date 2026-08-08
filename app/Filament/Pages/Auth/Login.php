<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

/**
 * Page de connexion admin personnalisée (charte Alliance).
 */
class Login extends BaseLogin
{
    /** Empêche l’enregistrement via discoverPages (réservé à ->login()). */
    protected static bool $isDiscovered = false;

    /** Ne doit pas apparaître dans la navigation du panel. */
    protected static bool $shouldRegisterNavigation = false;

    /**
     * Titre de l’onglet navigateur.
     *
     * @return string|Htmlable
     */
    public function getTitle(): string|Htmlable
    {
        return 'Connexion — Alliance Admin';
    }

    /**
     * Titre principal affiché sous le logo.
     *
     * @return string|Htmlable|null
     */
    public function getHeading(): string|Htmlable|null
    {
        if (filled($this->userUndertakingMultiFactorAuthentication)) {
            return parent::getHeading();
        }

        return 'Espace administration';
    }

    /**
     * Sous-titre sous le heading.
     *
     * @return string|Htmlable|null
     */
    public function getSubheading(): string|Htmlable|null
    {
        if (filled($this->userUndertakingMultiFactorAuthentication)) {
            return parent::getSubheading();
        }

        return 'Connectez-vous pour gérer le ministère Alliance';
    }
}
