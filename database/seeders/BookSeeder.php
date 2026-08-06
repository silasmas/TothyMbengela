<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

/**
 * Produits de démonstration de la Pasteure (livres, USB, packs).
 */
class BookSeeder extends Seeder
{
    /**
     * Remplit / met à jour le catalogue boutique.
     *
     * @return void
     */
    public function run(): void
    {
        $books = [
            [
                'title' => '7 Bénéfices de la Résolution',
                'product_type' => Book::TYPE_BOOK,
                'slug' => '7-benefices-de-la-resolution',
                'description' => "Découvrez les sept bénéfices puissants qui découlent d'une résolution ferme en Dieu. Cet ouvrage de la Pasteure Tothy Mbengela vous guide dans la compréhension de la force d'une décision ancrée dans la foi et vous encourage à tenir ferme dans vos engagements spirituels.",
                'price' => 10.00,
                'currency' => 'USD',
                'cover_path' => null,
                'is_active' => true,
                'is_featured' => true,
                'stock_quantity' => null,
            ],
            [
                'title' => "À l'Instar d'Élie",
                'product_type' => Book::TYPE_BOOK,
                'slug' => 'a-linstar-delie',
                'description' => "Inspiré par la vie du prophète Élie, ce livre vous invite à vivre une foi audacieuse et courageuse. La Pasteure Tothy Mbengela explore les leçons tirées de la vie d'Élie pour fortifier votre marche avec Dieu et vous préparer aux défis de la vie chrétienne.",
                'price' => 10.00,
                'currency' => 'USD',
                'cover_path' => null,
                'is_active' => true,
                'is_featured' => true,
                'stock_quantity' => null,
            ],
            [
                'title' => 'Attends-la cette Promesse !',
                'product_type' => Book::TYPE_BOOK,
                'slug' => 'attends-la-cette-promesse',
                'description' => "Les promesses de Dieu sont certaines, mais elles demandent patience et persévérance. Dans cet ouvrage, la Pasteure Tothy Mbengela vous encourage à ne pas abandonner, à garder la foi et à attendre avec confiance l'accomplissement des promesses divines dans votre vie.",
                'price' => 10.00,
                'currency' => 'USD',
                'cover_path' => null,
                'is_active' => true,
                'is_featured' => false,
                'stock_quantity' => null,
            ],
            [
                'title' => 'Sois Daniel ! La Préparation',
                'product_type' => Book::TYPE_BOOK,
                'slug' => 'sois-daniel-la-preparation',
                'description' => "Faisant partie de la Collection S.D., ce livre s'inspire de la vie de Daniel pour vous préparer à vivre une vie d'excellence et d'intégrité au milieu d'un monde hostile. La Pasteure Tothy Mbengela partage des clés pratiques pour rester fidèle à Dieu en toutes circonstances.",
                'price' => 10.00,
                'currency' => 'USD',
                'cover_path' => null,
                'is_active' => true,
                'is_featured' => false,
                'stock_quantity' => null,
            ],
            [
                'title' => 'Flash USB Alliance + Bracelet',
                'product_type' => Book::TYPE_USB,
                'slug' => 'flash-usb-alliance-bracelet',
                'description' => "Clé USB Alliance contenant des enseignements audio/vidéo de la Pasteure Tothy Mbengela, accompagnée d’un bracelet souvenir du ministère. Emportez la Parole partout avec vous.",
                'price' => 25.00,
                'currency' => 'USD',
                'cover_path' => null,
                'is_active' => true,
                'is_featured' => true,
                'stock_quantity' => 50,
            ],
            [
                'title' => 'Coffret 4 livres de la Pasteure',
                'product_type' => Book::TYPE_PACK,
                'slug' => 'coffret-4-livres-pasteure',
                'description' => "Les quatre ouvrages phares de la Pasteure Tothy Mbengela réunis en un seul pack : 7 Bénéfices de la Résolution, À l’Instar d’Élie, Attends-la cette Promesse ! et Sois Daniel ! La Préparation.",
                'price' => 35.00,
                'currency' => 'USD',
                'cover_path' => null,
                'is_active' => true,
                'is_featured' => true,
                'stock_quantity' => null,
            ],
        ];

        foreach ($books as $data) {
            Book::updateOrCreate(
                ['slug' => $data['slug']],
                $data,
            );
        }
    }
}
