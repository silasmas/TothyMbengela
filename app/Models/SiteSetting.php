<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

/**
 * Paramètres généraux du site (coordonnées, slogan, réseaux).
 */
class SiteSetting extends Model
{
    protected $fillable = [
        'phone',
        'email',
        'address',
        'slogan',
        'facebook_url',
        'youtube_url',
        'instagram_url',
        'tiktok_url',
        'whatsapp_url',
        'products_welcome_modal_enabled',
    ];

    /**
     * Casts des attributs.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'products_welcome_modal_enabled' => 'boolean',
        ];
    }

    /**
     * Instance unique (créée avec des valeurs par défaut si absente).
     *
     * @return self
     */
    public static function instance(): self
    {
        $row = static::query()->first();
        if ($row !== null) {
            return $row;
        }

        return static::query()->create([
            'phone' => null,
            'email' => 'contact@alliance-ministere.com',
            'address' => null,
            'slogan' => 'Ministère de la Pasteure Tothy Mbengela — Prédications, enseignements et accompagnement spirituel.',
            'facebook_url' => null,
            'youtube_url' => null,
            'instagram_url' => null,
            'tiktok_url' => null,
            'whatsapp_url' => null,
            'products_welcome_modal_enabled' => true,
        ]);
    }

    /**
     * Indique si la modale produits d’accueil est active.
     *
     * @return bool
     */
    public function isProductsWelcomeModalEnabled(): bool
    {
        if (! Schema::hasColumn($this->getTable(), 'products_welcome_modal_enabled')) {
            return true;
        }

        return (bool) ($this->products_welcome_modal_enabled ?? true);
    }
}
