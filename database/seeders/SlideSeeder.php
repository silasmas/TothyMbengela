<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;

/**
 * Slides d’accueil indépendantes (jamais générées depuis les produits).
 */
class SlideSeeder extends Seeder
{
    /**
     * Nettoie les anciennes slides « produit » et crée les slides par défaut si besoin.
     *
     * @return void
     */
    public function run(): void
    {
        // Supprime les slides générées depuis les produits (plus utilisées).
        Slide::query()->where('slide_type', 'product')->delete();

        // Slides sans image dédiée dont l’unique rôle était panier/acheter via un produit.
        Slide::query()
            ->whereNotNull('book_id')
            ->whereNull('image_path')
            ->where(function ($q) {
                $q->whereIn('primary_action', [Slide::ACTION_ADD_CART, Slide::ACTION_BUY])
                    ->orWhereIn('secondary_action', [Slide::ACTION_ADD_CART, Slide::ACTION_BUY]);
            })
            ->delete();

        Slide::ensureDefaults();
    }
}
