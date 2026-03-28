<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        TeamMember::query()->updateOrCreate(
            ['slug' => 'tothy-mbengela'],
            [
                'name' => 'Tothy Mbengela',
                'role' => 'Pasteure, enseignante & auteure',
                'excerpt' => 'Pasteure Tothy Mbengela — Parole, enseignement et ressources pour édifier la foi.',
                'body' => "Alliance est le ministère de la Pasteure Tothy Mbengela. À travers des enseignements bibliques, des prédications et des ouvrages, elle sert la communauté à Lubumbashi et au-delà, en ligne.\n\nSa mission : restaurer les cœurs, encourager la marche avec Dieu et rendre la Parole accessible à tous.",
                'photo_path' => null,
                'profile_url' => 'https://www.youtube.com/@tothymbengela',
                'social_facebook' => 'https://www.facebook.com/tothymbengela',
                'social_youtube' => 'https://www.youtube.com/@tothymbengela',
                'social_instagram' => 'https://www.instagram.com/tothymbengela',
                'social_tiktok' => 'https://www.tiktok.com/@tothymbengela',
                'sort_order' => 0,
                'is_active' => true,
            ],
        );
    }
}
