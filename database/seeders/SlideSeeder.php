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
     * Nettoie les anciennes slides « produit » et crée les slides de base si besoin.
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

        if (Slide::query()->exists()) {
            return;
        }

        Slide::query()->create([
            'title' => 'Bienvenue chez Alliance',
            'subtitle' => 'Ministère Tothy Mbengela',
            'body' => 'Livres, ressources et enseignements pour votre édification.',
            'image_path' => null,
            'slide_type' => Slide::TYPE_CUSTOM,
            'book_id' => null,
            'primary_action' => Slide::ACTION_SHOP,
            'primary_label' => 'Voir la boutique',
            'secondary_action' => Slide::ACTION_ABOUT,
            'secondary_label' => 'En savoir plus',
            'sort_order' => 10,
            'is_active' => true,
        ]);

        Slide::query()->create([
            'title' => 'Soutenez le ministère',
            'subtitle' => null,
            'body' => 'Votre générosité nous permet de partager la Parole de Dieu et d’accompagner des vies à travers le monde.',
            'image_path' => null,
            'slide_type' => Slide::TYPE_DONATE,
            'book_id' => null,
            'primary_action' => Slide::ACTION_DONATE,
            'primary_label' => 'Faire un don',
            'secondary_action' => Slide::ACTION_PARTNER,
            'secondary_label' => 'Devenir partenaire',
            'sort_order' => 20,
            'is_active' => true,
        ]);
    }
}
