<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

/**
 * Autorisations Shield pour la ressource Administrateurs.
 */
class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Liste des administrateurs.
     *
     * @param  AuthUser  $authUser  Admin connecté
     * @return bool
     */
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Admin');
    }

    /**
     * Voir un administrateur.
     *
     * @param  AuthUser  $authUser  Admin connecté
     * @param  Admin  $admin  Cible
     * @return bool
     */
    public function view(AuthUser $authUser, Admin $admin): bool
    {
        return $authUser->can('View:Admin');
    }

    /**
     * Créer un administrateur.
     *
     * @param  AuthUser  $authUser  Admin connecté
     * @return bool
     */
    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Admin');
    }

    /**
     * Modifier un administrateur.
     *
     * @param  AuthUser  $authUser  Admin connecté
     * @param  Admin  $admin  Cible
     * @return bool
     */
    public function update(AuthUser $authUser, Admin $admin): bool
    {
        return $authUser->can('Update:Admin');
    }

    /**
     * Supprimer un administrateur.
     *
     * @param  AuthUser  $authUser  Admin connecté
     * @param  Admin  $admin  Cible
     * @return bool
     */
    public function delete(AuthUser $authUser, Admin $admin): bool
    {
        if ((int) $authUser->getAuthIdentifier() === (int) $admin->id) {
            return false;
        }

        return $authUser->can('Delete:Admin');
    }

    /**
     * Suppression en masse.
     *
     * @param  AuthUser  $authUser  Admin connecté
     * @return bool
     */
    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Admin');
    }

    /**
     * Restaurer.
     *
     * @param  AuthUser  $authUser  Admin connecté
     * @param  Admin  $admin  Cible
     * @return bool
     */
    public function restore(AuthUser $authUser, Admin $admin): bool
    {
        return $authUser->can('Restore:Admin');
    }

    /**
     * Suppression définitive.
     *
     * @param  AuthUser  $authUser  Admin connecté
     * @param  Admin  $admin  Cible
     * @return bool
     */
    public function forceDelete(AuthUser $authUser, Admin $admin): bool
    {
        if ((int) $authUser->getAuthIdentifier() === (int) $admin->id) {
            return false;
        }

        return $authUser->can('ForceDelete:Admin');
    }

    /**
     * Suppression définitive en masse.
     *
     * @param  AuthUser  $authUser  Admin connecté
     * @return bool
     */
    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Admin');
    }

    /**
     * Restauration en masse.
     *
     * @param  AuthUser  $authUser  Admin connecté
     * @return bool
     */
    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Admin');
    }

    /**
     * Répliquer.
     *
     * @param  AuthUser  $authUser  Admin connecté
     * @param  Admin  $admin  Cible
     * @return bool
     */
    public function replicate(AuthUser $authUser, Admin $admin): bool
    {
        return $authUser->can('Replicate:Admin');
    }

    /**
     * Réordonner.
     *
     * @param  AuthUser  $authUser  Admin connecté
     * @return bool
     */
    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Admin');
    }
}
