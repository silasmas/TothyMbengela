<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * Slide du carrousel d’accueil (entité indépendante, gérée via Filament).
 */
class Slide extends Model
{
    public const TYPE_CUSTOM = 'custom';

    public const TYPE_DONATE = 'donate';

    public const ACTION_ADD_CART = 'add_cart';

    public const ACTION_BUY = 'buy';

    public const ACTION_LINK = 'link';

    public const ACTION_DONATE = 'donate';

    public const ACTION_PARTNER = 'partner';

    public const ACTION_CONTENTS = 'contents';

    public const ACTION_ABOUT = 'about';

    public const ACTION_SHOP = 'shop';

    public const ACTION_NONE = 'none';

    protected $fillable = [
        'title',
        'subtitle',
        'body',
        'image_path',
        'slide_type',
        'book_id',
        'primary_action',
        'primary_label',
        'primary_url',
        'secondary_action',
        'secondary_label',
        'secondary_url',
        'sort_order',
        'is_active',
    ];

    /**
     * Casts des attributs.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Libellés des types de slide (contenu éditorial, pas des produits).
     *
     * @return array<string, string>
     */
    public static function typeLabels(): array
    {
        return [
            self::TYPE_CUSTOM => 'Contenu / promotion',
            self::TYPE_DONATE => 'Don / partenaire',
        ];
    }

    /**
     * Actions disponibles pour les boutons de slide.
     *
     * @return array<string, string>
     */
    public static function actionLabels(): array
    {
        return [
            self::ACTION_NONE => 'Aucune',
            self::ACTION_ADD_CART => 'Mettre dans le panier',
            self::ACTION_BUY => 'Acheter',
            self::ACTION_LINK => 'Lien personnalisé',
            self::ACTION_DONATE => 'Faire un don',
            self::ACTION_PARTNER => 'Devenir partenaire',
            self::ACTION_CONTENTS => 'Contenus',
            self::ACTION_ABOUT => 'À propos',
            self::ACTION_SHOP => 'Boutique',
        ];
    }

    /**
     * Indique si une action nécessite un produit (panier / acheter).
     *
     * @param  string|null  $action  Code action
     * @return bool
     */
    public static function actionNeedsProduct(?string $action): bool
    {
        return in_array($action, [self::ACTION_ADD_CART, self::ACTION_BUY], true);
    }

    /**
     * Produit optionnel (uniquement pour les boutons Panier / Acheter).
     *
     * @return BelongsTo<Book, $this>
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * URL de l’image de fond de la slide (image propre uniquement).
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            return Storage::disk('public')->url($this->image_path);
        }

        return asset('assets/images/s1.jpeg');
    }

    /**
     * Slides actives ordonnées pour le carrousel.
     *
     * @param  Builder<Slide>  $query
     * @return Builder<Slide>
     */
    public function scopeActiveOrdered(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Définition des slides affichées par défaut (modifiables / supprimables en admin).
     *
     * @return list<array<string, mixed>>
     */
    public static function defaultPayloads(): array
    {
        return [
            [
                'title' => 'Bienvenue chez Alliance',
                'subtitle' => 'Ministère Tothy Mbengela',
                'body' => 'Livres, ressources et enseignements pour votre édification.',
                'image_path' => null,
                'slide_type' => self::TYPE_CUSTOM,
                'book_id' => null,
                'primary_action' => self::ACTION_SHOP,
                'primary_label' => 'Voir la boutique',
                'primary_url' => null,
                'secondary_action' => self::ACTION_ABOUT,
                'secondary_label' => 'En savoir plus',
                'secondary_url' => null,
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'title' => 'Écoutez la Parole',
                'subtitle' => 'Contenus & enseignements',
                'body' => 'Prédications, séries et ressources pour grandir dans la foi.',
                'image_path' => null,
                'slide_type' => self::TYPE_CUSTOM,
                'book_id' => null,
                'primary_action' => self::ACTION_CONTENTS,
                'primary_label' => 'Voir les contenus',
                'primary_url' => null,
                'secondary_action' => self::ACTION_SHOP,
                'secondary_label' => 'Boutique',
                'secondary_url' => null,
                'sort_order' => 20,
                'is_active' => true,
            ],
            [
                'title' => 'Soutenez le ministère',
                'subtitle' => 'Don & partenariat',
                'body' => 'Votre générosité nous permet de partager la Parole de Dieu et d’accompagner des vies à travers le monde.',
                'image_path' => null,
                'slide_type' => self::TYPE_DONATE,
                'book_id' => null,
                'primary_action' => self::ACTION_DONATE,
                'primary_label' => 'Faire un don',
                'primary_url' => null,
                'secondary_action' => self::ACTION_PARTNER,
                'secondary_label' => 'Devenir partenaire',
                'secondary_url' => null,
                'sort_order' => 30,
                'is_active' => true,
            ],
        ];
    }

    /**
     * Crée les slides par défaut uniquement si la table est vide.
     *
     * @return int Nombre de slides créées
     */
    public static function ensureDefaults(): int
    {
        if (static::query()->exists()) {
            return 0;
        }

        $created = 0;
        foreach (static::defaultPayloads() as $payload) {
            static::query()->create($payload);
            $created++;
        }

        return $created;
    }
}
