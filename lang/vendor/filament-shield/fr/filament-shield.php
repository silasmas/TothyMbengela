<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Colonnes du tableau
    |--------------------------------------------------------------------------
    */

    'column.name' => 'Nom',
    'column.guard_name' => 'Garde',
    'column.team' => 'Équipe',
    'column.roles' => 'Rôles',
    'column.permissions' => 'Permissions',
    'column.updated_at' => 'Mis à jour le',

    /*
    |--------------------------------------------------------------------------
    | Champs du formulaire
    |--------------------------------------------------------------------------
    */

    'field.name' => 'Nom',
    'field.guard_name' => 'Garde',
    'field.permissions' => 'Permissions',
    'field.team' => 'Équipe',
    'field.team.placeholder' => 'Sélectionner une équipe…',
    'field.select_all.name' => 'Tout sélectionner',
    'field.select_all.message' => 'Active ou désactive toutes les autorisations pour ce rôle.',

    /*
    |--------------------------------------------------------------------------
    | Navigation & ressource
    |--------------------------------------------------------------------------
    */

    'nav.group' => 'Accès & rôles',
    'nav.role.label' => 'Rôles',
    'nav.role.icon' => 'heroicon-o-shield-check',
    'resource.label.role' => 'Rôle',
    'resource.label.roles' => 'Rôles',

    /*
    |--------------------------------------------------------------------------
    | Sections & onglets
    |--------------------------------------------------------------------------
    */

    'section' => 'Entités',
    'resources' => 'Ressources',
    'widgets' => 'Widgets',
    'pages' => 'Pages',
    'custom' => 'Permissions personnalisées',

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    'forbidden' => 'Vous n’avez pas l’autorisation d’accéder à cette ressource.',

    /*
    |--------------------------------------------------------------------------
    | Libellés des actions sur les ressources (permissions)
    |--------------------------------------------------------------------------
    */

    'resource_permission_prefixes_labels' => [
        'view' => 'Voir',
        'view_any' => 'Voir la liste',
        'create' => 'Créer',
        'update' => 'Modifier',
        'delete' => 'Supprimer',
        'delete_any' => 'Supprimer en masse',
        'force_delete' => 'Supprimer définitivement',
        'force_delete_any' => 'Supprimer définitivement en masse',
        'restore' => 'Restaurer',
        'reorder' => 'Réordonner',
        'restore_any' => 'Restaurer en masse',
        'replicate' => 'Dupliquer',
    ],
];
