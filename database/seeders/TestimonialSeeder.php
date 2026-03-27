<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Grace Mutombo',
                'role' => 'Membre fidèle',
                'location' => 'Lubumbashi, RDC',
                'message' => "Les enseignements de la Pasteure Tothy m'ont profondément transformée. J'ai retrouvé ma foi et compris ma destinée en Christ. Que Dieu continue à bénir ce ministère !",
                'rating' => 5,
            ],
            [
                'name' => 'Patrick Kabongo',
                'role' => 'Partenaire du ministère',
                'location' => 'Kinshasa, RDC',
                'message' => "Depuis que je suis les prédications d'Alliance, ma vie spirituelle a pris un tournant incroyable. Les livres de la Pasteure sont de véritables trésors de sagesse.",
                'rating' => 5,
            ],
            [
                'name' => 'Marie-Claire Ilunga',
                'role' => 'Responsable cellule de prière',
                'location' => 'Likasi, RDC',
                'message' => "Le livre '7 Bénéfices de la Résolution' a changé ma façon de voir les engagements envers Dieu. Je recommande vivement les ouvrages de la Pasteure Tothy.",
                'rating' => 5,
            ],
            [
                'name' => 'Jean-Pierre Mwamba',
                'role' => 'Pasteur associé',
                'location' => 'Kolwezi, RDC',
                'message' => 'Un ministère puissant et ancré dans la Parole de Dieu. Les enseignements sont clairs, profonds et applicables au quotidien. Merci Pasteure !',
                'rating' => 5,
            ],
            [
                'name' => 'Rachel Kisimba',
                'role' => 'Étudiante en théologie',
                'location' => 'Lubumbashi, RDC',
                'message' => "'À l'Instar d'Élie' m'a appris à développer une foi audacieuse. Ce livre est devenu mon compagnon de méditation quotidienne.",
                'rating' => 5,
            ],
            [
                'name' => 'David Ngoy',
                'role' => 'Entrepreneur chrétien',
                'location' => 'Lubumbashi, RDC',
                'message' => "Les contenus en ligne d'Alliance sont une bénédiction pour ceux qui ne peuvent pas toujours être présents physiquement. La qualité est exceptionnelle.",
                'rating' => 5,
            ],
            [
                'name' => 'Esther Kapinga',
                'role' => 'Femme au foyer',
                'location' => 'Kipushi, RDC',
                'message' => "Le programme 'Femme Disciple' m'a aidée à trouver mon identité en Christ en tant que femme et mère. Merci pour cette vision !",
                'rating' => 5,
            ],
            [
                'name' => 'Samuel Tshilumba',
                'role' => 'Diacre',
                'location' => 'Kamina, RDC',
                'message' => "Chaque prédication est une nourriture spirituelle qui fortifie l'âme. La Pasteure Tothy a un don unique pour rendre la Parole accessible à tous.",
                'rating' => 5,
            ],
            [
                'name' => 'Béatrice Lunda',
                'role' => 'Enseignante',
                'location' => 'Kasumbalesa, RDC',
                'message' => "'Sois Daniel ! La Préparation' m'a donné le courage de rester intègre dans mon milieu professionnel. Un livre indispensable pour tout chrétien.",
                'rating' => 5,
            ],
            [
                'name' => 'Joseph Kalala',
                'role' => 'Médecin',
                'location' => 'Lubumbashi, RDC',
                'message' => "Je suis les vidéos YouTube du ministère depuis 2 ans. Chaque contenu est une source d'inspiration et de renouvellement spirituel.",
                'rating' => 5,
            ],
            [
                'name' => 'Chantal Mbuyu',
                'role' => 'Commerçante',
                'location' => 'Likasi, RDC',
                'message' => "'Attends-la cette Promesse !' m'a appris la patience dans l'attente. Dieu est fidèle et ce livre m'a aidée à le comprendre profondément.",
                'rating' => 5,
            ],
            [
                'name' => 'François Kasongo',
                'role' => 'Musicien gospel',
                'location' => 'Kinshasa, RDC',
                'message' => "Le ministère Alliance est une référence pour l'édification de la foi en RDC. Les enseignements sont solides et équilibrés.",
                'rating' => 4,
            ],
            [
                'name' => 'Nadine Kyungu',
                'role' => 'Infirmière',
                'location' => 'Lubumbashi, RDC',
                'message' => "Grâce aux séries d'enseignements, j'ai pu approfondir ma connaissance des Écritures. C'est un vrai séminaire spirituel en ligne !",
                'rating' => 5,
            ],
            [
                'name' => 'Albert Mukendi',
                'role' => 'Ingénieur',
                'location' => 'Fungurume, RDC',
                'message' => 'La Pasteure Tothy a un cœur pour les âmes. Son authenticité et sa passion pour la Parole transparaissent dans chaque message.',
                'rating' => 5,
            ],
            [
                'name' => 'Joséphine Mwila',
                'role' => 'Responsable jeunesse',
                'location' => 'Lubumbashi, RDC',
                'message' => 'Les jeunes de notre assemblée ont été profondément touchés par les enseignements du ministère. Un impact réel sur la nouvelle génération.',
                'rating' => 5,
            ],
            [
                'name' => 'Pierre Banza',
                'role' => 'Comptable',
                'location' => 'Kolwezi, RDC',
                'message' => 'Les 4 livres de la Pasteure sont un coffret de sagesse divine. Je les ai tous lus et ils ont transformé ma vision de la vie chrétienne.',
                'rating' => 5,
            ],
            [
                'name' => 'Carine Mujinga',
                'role' => 'Pharmacienne',
                'location' => 'Lubumbashi, RDC',
                'message' => "Le vernissage des 4 livres a été un moment inoubliable. Voir l'aboutissement du travail de la Pasteure m'a inspirée à poursuivre mes propres rêves.",
                'rating' => 5,
            ],
            [
                'name' => 'Moïse Katanga',
                'role' => 'Étudiant',
                'location' => 'Lubumbashi, RDC',
                'message' => "En tant que jeune, les contenus d'Alliance m'aident à rester connecté à Dieu malgré les distractions du monde moderne. Merci infiniment !",
                'rating' => 4,
            ],
            [
                'name' => 'Henriette Numbi',
                'role' => 'Missionnaire',
                'location' => 'Kalemie, RDC',
                'message' => 'Depuis la brousse où je sers, je peux suivre les enseignements en ligne. Alliance brise les barrières géographiques pour toucher les cœurs partout.',
                'rating' => 5,
            ],
            [
                'name' => 'Thierry Kazadi',
                'role' => 'Avocat',
                'location' => 'Lubumbashi, RDC',
                'message' => "La rigueur et la profondeur des enseignements bibliques du ministère Alliance sont remarquables. C'est un phare spirituel pour notre communauté.",
                'rating' => 5,
            ],
        ];

        foreach ($testimonials as $index => $data) {
            Testimonial::updateOrCreate(
                ['name' => $data['name']],
                array_merge($data, ['sort_order' => $index + 1, 'is_active' => true]),
            );
        }
    }
}
