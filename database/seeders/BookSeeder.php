<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => '7 Bénéfices de la Résolution',
                'slug' => '7-benefices-de-la-resolution',
                'description' => "Découvrez les sept bénéfices puissants qui découlent d'une résolution ferme en Dieu. Cet ouvrage de la Pasteure Tothy Mbengela vous guide dans la compréhension de la force d'une décision ancrée dans la foi et vous encourage à tenir ferme dans vos engagements spirituels.",
                'price' => 10.00,
                'currency' => 'USD',
                'cover_path' => 'books/7-benefices-de-la-resolution.jpg',
                'is_active' => true,
                'stock_quantity' => null,
            ],
            [
                'title' => "À l'Instar d'Élie",
                'slug' => 'a-linstar-delie',
                'description' => "Inspiré par la vie du prophète Élie, ce livre vous invite à vivre une foi audacieuse et courageuse. La Pasteure Tothy Mbengela explore les leçons tirées de la vie d'Élie pour fortifier votre marche avec Dieu et vous préparer aux défis de la vie chrétienne.",
                'price' => 10.00,
                'currency' => 'USD',
                'cover_path' => 'books/a-linstar-delie.jpg',
                'is_active' => true,
                'stock_quantity' => null,
            ],
            [
                'title' => 'Attends-la cette Promesse !',
                'slug' => 'attends-la-cette-promesse',
                'description' => "Les promesses de Dieu sont certaines, mais elles demandent patience et persévérance. Dans cet ouvrage, la Pasteure Tothy Mbengela vous encourage à ne pas abandonner, à garder la foi et à attendre avec confiance l'accomplissement des promesses divines dans votre vie.",
                'price' => 10.00,
                'currency' => 'USD',
                'cover_path' => 'books/attends-la-cette-promesse.jpg',
                'is_active' => true,
                'stock_quantity' => null,
            ],
            [
                'title' => 'Sois Daniel ! La Préparation',
                'slug' => 'sois-daniel-la-preparation',
                'description' => "Faisant partie de la Collection S.D., ce livre s'inspire de la vie de Daniel pour vous préparer à vivre une vie d'excellence et d'intégrité au milieu d'un monde hostile. La Pasteure Tothy Mbengela partage des clés pratiques pour rester fidèle à Dieu en toutes circonstances.",
                'price' => 10.00,
                'currency' => 'USD',
                'cover_path' => 'books/sois-daniel-la-preparation.jpg',
                'is_active' => true,
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
