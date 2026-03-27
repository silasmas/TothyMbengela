<?php

/**
 * Données issues de la page playlists @tothy_mbengela et du flux RSS de la chaîne.
 * Chaîne : https://www.youtube.com/@tothy_mbengela
 * RSS : https://www.youtube.com/feeds/videos.xml?channel_id=UCLp18bcg9ZMQWXaaqtqJn_A
 */
return [
    'channel_id' => 'UCLp18bcg9ZMQWXaaqtqJn_A',
    'channel_handle' => '@tothy_mbengela',

    'themes' => [
        ['name' => 'Parole & prière', 'slug' => 'parole-et-priere', 'description' => 'Enseignements et temps de prière.'],
        ['name' => 'Identité & destinée', 'slug' => 'identite-et-destinee', 'description' => 'Vocation, accomplissement et promesses.'],
    ],

    'rubriques' => [
        ['name' => 'Proverbes', 'slug' => 'proverbes', 'description' => 'Méditations et commentaires autour des Proverbes.', 'icon' => null, 'sort_order' => 10],
        ['name' => 'Minutes de ta destinée', 'slug' => 'minutes-de-ta-destinee', 'description' => 'Capsules courtes pour avancer dans votre destinée.', 'icon' => null, 'sort_order' => 20],
        ['name' => 'S’accomplir', 'slug' => 's-accomplir', 'description' => 'Série dédiée à l’accomplissement selon Dieu.', 'icon' => null, 'sort_order' => 30],
        ['name' => 'Prédications', 'slug' => 'predications', 'description' => 'Messages et cultes en vidéo.', 'icon' => null, 'sort_order' => 40],
        ['name' => 'Femme disciple de Jésus', 'slug' => 'femme-disciple-de-jesus', 'description' => 'Enseignements pour la femme disciple.', 'icon' => null, 'sort_order' => 50],
        ['name' => 'Mes déclarations', 'slug' => 'mes-declarations', 'description' => 'Le programme Mes déclarations.', 'icon' => null, 'sort_order' => 60],
    ],

    /*
     * Une entrée par playlist visible sur la chaîne (aperçu = première vidéo « Play all »).
     */
    'playlists' => [
        [
            'playlist_title' => 'Proverbes',
            'playlist_id' => 'PLsE9YNHy_f2s1I1uJ5EHDGBfZvQaOJ3K8',
            'rubrique_slug' => 'proverbes',
            'series_slug' => 'playlist-proverbes',
            'featured_video_id' => '9MwDprKBkRg',
            'featured_title' => null,
        ],
        [
            'playlist_title' => 'les minutes de ta destinée',
            'playlist_id' => 'PLsE9YNHy_f2uCPMwKNnlFI-1v1es7AhjA',
            'rubrique_slug' => 'minutes-de-ta-destinee',
            'series_slug' => 'playlist-minutes-de-ta-destinee',
            'featured_video_id' => 'GXQDovOqoBA',
            'featured_title' => null,
        ],
        [
            'playlist_title' => 'S’ACCOMPLIR',
            'playlist_id' => 'PLsE9YNHy_f2vCBsN91hMIfQz5PHaiRlgX',
            'rubrique_slug' => 's-accomplir',
            'series_slug' => 'playlist-s-accomplir',
            'featured_video_id' => '3FIhRR3qRog',
            'featured_title' => null,
        ],
        [
            'playlist_title' => 'SHORTS',
            'playlist_id' => 'PLsE9YNHy_f2vFc808uhHmMBfyPaXXqKyI',
            'rubrique_slug' => 'minutes-de-ta-destinee',
            'series_slug' => 'playlist-shorts',
            'featured_video_id' => 'J_CliWzm8ss',
            'featured_title' => null,
        ],
        [
            'playlist_title' => 'PREDICATIONS',
            'playlist_id' => 'PLsE9YNHy_f2tZGNj2cS8PElJCyc3-UoAX',
            'rubrique_slug' => 'predications',
            'series_slug' => 'playlist-predications',
            'featured_video_id' => 'cFQT1lpg5Xw',
            'featured_title' => null,
        ],
        [
            'playlist_title' => 'NE POUR VAINCRE',
            'playlist_id' => 'PLsE9YNHy_f2uzP1ZWOokLxP-coaOx2kgb',
            'rubrique_slug' => 'predications',
            'series_slug' => 'playlist-ne-pour-vaincre',
            'featured_video_id' => 'oSUTbflBQsg',
            'featured_title' => null,
        ],
        [
            'playlist_title' => 'LES COMMENT',
            'playlist_id' => 'PLsE9YNHy_f2uiRaa-pyd5HXhx7qQ_iTXg',
            'rubrique_slug' => 'proverbes',
            'series_slug' => 'playlist-les-comment',
            'featured_video_id' => 'vYerKexKZyk',
            'featured_title' => null,
        ],
        [
            'playlist_title' => 'PAROLE DE LA SEMAINE',
            'playlist_id' => 'PLsE9YNHy_f2sD9r4q7PdGyZo5puKtFvx9',
            'rubrique_slug' => 'predications',
            'series_slug' => 'playlist-parole-de-la-semaine',
            'featured_video_id' => 'Asc3iaC4IK4',
            'featured_title' => 'VEUILLE SEULEMENT L’ÉTERNEL, TON DIEU, ÊTRE AVEC TOI | Pasteure Tothy Mbengela',
        ],
        [
            'playlist_title' => 'FEMME DISCIPLE DE JESUS',
            'playlist_id' => 'PLsE9YNHy_f2v_8yPCFZhkQ9bXcT-oRjJr',
            'rubrique_slug' => 'femme-disciple-de-jesus',
            'series_slug' => 'playlist-femme-disciple-de-jesus',
            'featured_video_id' => '7flJZzwDy_Q',
            'featured_title' => null,
        ],
        [
            'playlist_title' => 'MES DECLARATIONS',
            'playlist_id' => 'PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC',
            'rubrique_slug' => 'mes-declarations',
            'series_slug' => 'playlist-mes-declarations',
            'featured_video_id' => '6K1sZTwY9Vs',
            'featured_title' => 'MES DECLARATIONS | Mars 2026 | Pasteure Tothy MBENGELA',
        ],
        [
            'playlist_title' => 'ET SI TU PRIAIS / Court-Métrage',
            'playlist_id' => 'PLsE9YNHy_f2uby5SrqpArUStxfl8cj1n4',
            'rubrique_slug' => 's-accomplir',
            'series_slug' => 'playlist-et-si-tu-priais-court-metrage',
            'featured_video_id' => 'fPNDYt4WZog',
            'featured_title' => null,
        ],
    ],

    /*
     * Dernières vidéos du flux RSS (titres et dates réels) — les doublons d’ID avec les « featured »
     * ci-dessus sont gérés par updateOrCreate sur youtube_video_id.
     */
    'rss_videos' => [
        ['video_id' => 'C7qfNyJKRn0', 'title' => 'MES 4 LIVRES SONT DESORMAIS DISPONIBLES #livresinspirants', 'published_at' => '2026-03-18T12:43:29+00:00', 'rubrique_slug' => 'minutes-de-ta-destinee', 'series_slug' => 'playlist-shorts', 'excerpt' => 'Les livres sont désormais disponibles et à votre portée.'],
        ['video_id' => 'Asc3iaC4IK4', 'title' => 'VEUILLE SEULEMENT L’ÉTERNEL, TON DIEU, ÊTRE AVEC TOI | Pasteure Tothy Mbengela', 'published_at' => '2026-03-17T08:14:06+00:00', 'rubrique_slug' => 'predications', 'series_slug' => 'playlist-parole-de-la-semaine', 'excerpt' => null],
        ['video_id' => '6K1sZTwY9Vs', 'title' => 'MES DECLARATIONS | Mars 2026 | Pasteure Tothy MBENGELA', 'published_at' => '2026-03-01T10:35:49+00:00', 'rubrique_slug' => 'mes-declarations', 'series_slug' => 'playlist-mes-declarations', 'excerpt' => null],
        ['video_id' => '0BH75IkAuq4', 'title' => 'MON HISTOIRE VERS L’ÉCRITURE | VERNISSAGE DE QUATRE LIVRES', 'published_at' => '2026-02-28T21:44:20+00:00', 'rubrique_slug' => 's-accomplir', 'series_slug' => 'playlist-s-accomplir', 'excerpt' => null],
        ['video_id' => '460ftY_DReE', 'title' => 'IL PEUT FAIRE INFINIMENT AU DELÀ | Pasteure Tothy Mbengela', 'published_at' => '2026-02-16T13:03:26+00:00', 'rubrique_slug' => 'predications', 'series_slug' => 'playlist-parole-de-la-semaine', 'excerpt' => null],
        ['video_id' => 'ipfxjB-9KZ0', 'title' => 'QUE L’ÉTERNEL VOUS BÉNISSE COMME IL VOUS L’A PROMIS | Pasteure Tothy Mbengela', 'published_at' => '2026-02-03T05:09:39+00:00', 'rubrique_slug' => 'predications', 'series_slug' => 'playlist-parole-de-la-semaine', 'excerpt' => null],
        ['video_id' => '3HXUCDTAItE', 'title' => 'MES DECLARATIONS | Février 2026 | Maman Lévi NGALULA', 'published_at' => '2026-02-01T10:27:51+00:00', 'rubrique_slug' => 'mes-declarations', 'series_slug' => 'playlist-mes-declarations', 'excerpt' => null],
        ['video_id' => 'fc1CQ6g2GTU', 'title' => 'MES DECLARATIONS | Février 2026 | Maman Lévi NGALULA', 'published_at' => '2026-01-31T21:27:15+00:00', 'rubrique_slug' => 'mes-declarations', 'series_slug' => 'playlist-mes-declarations', 'excerpt' => null],
        ['video_id' => 'd0cnu_4z2Jc', 'title' => 'FAITES DONC MOURIR VOTRE CHAIR | Pasteure Tothy Mbengela', 'published_at' => '2026-01-28T16:01:15+00:00', 'rubrique_slug' => 'predications', 'series_slug' => 'playlist-predications', 'excerpt' => null],
        ['video_id' => '7OkAo286H40', 'title' => 'SOUVIENS-TOI QUE TU ES EN VOYAGE | Pasteure Tothy Mbengela', 'published_at' => '2026-01-19T14:26:50+00:00', 'rubrique_slug' => 'predications', 'series_slug' => 'playlist-predications', 'excerpt' => null],
        ['video_id' => 'qbQ2DOc_r4c', 'title' => 'VAINCRE LA COLÈRE PAR LA PRIÈRE - Pasteure Tothy Mbengela', 'published_at' => '2026-01-12T08:32:20+00:00', 'rubrique_slug' => 'predications', 'series_slug' => 'playlist-ne-pour-vaincre', 'excerpt' => null],
        ['video_id' => 'q4RsEMhO1WM', 'title' => 'MES DECLARATIONS | DÉCEMBRE 2025 | Pasteure Tothy MBENGELA', 'published_at' => '2025-12-01T10:51:03+00:00', 'rubrique_slug' => 'mes-declarations', 'series_slug' => 'playlist-mes-declarations', 'excerpt' => null],
        ['video_id' => 'TzHPp3DgRuA', 'title' => 'MES DÉCLARATIONS | NOVEMBRE 2025 | Pasteure Tothy MBENGELA', 'published_at' => '2025-11-01T10:10:50+00:00', 'rubrique_slug' => 'mes-declarations', 'series_slug' => 'playlist-mes-declarations', 'excerpt' => null],
        ['video_id' => 'ywJ81B3IQjs', 'title' => 'MES DECLARATIONS | OCTOBRE | Pasteure Tothy MBENGELA', 'published_at' => '2025-09-30T21:59:36+00:00', 'rubrique_slug' => 'mes-declarations', 'series_slug' => 'playlist-mes-declarations', 'excerpt' => null],
        ['video_id' => 'yfGCHRZIvDo', 'title' => 'MES DECLARATIONS | Mois de Septembre | Maman Lévi NGALULA', 'published_at' => '2025-09-01T10:25:11+00:00', 'rubrique_slug' => 'mes-declarations', 'series_slug' => 'playlist-mes-declarations', 'excerpt' => null],
    ],
];
