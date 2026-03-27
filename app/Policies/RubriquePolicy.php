<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Rubrique;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class RubriquePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Rubrique');
    }

    public function view(AuthUser $authUser, Rubrique $rubrique): bool
    {
        return $authUser->can('View:Rubrique');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Rubrique');
    }

    public function update(AuthUser $authUser, Rubrique $rubrique): bool
    {
        return $authUser->can('Update:Rubrique');
    }

    public function delete(AuthUser $authUser, Rubrique $rubrique): bool
    {
        return $authUser->can('Delete:Rubrique');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Rubrique');
    }

    public function restore(AuthUser $authUser, Rubrique $rubrique): bool
    {
        return $authUser->can('Restore:Rubrique');
    }

    public function forceDelete(AuthUser $authUser, Rubrique $rubrique): bool
    {
        return $authUser->can('ForceDelete:Rubrique');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Rubrique');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Rubrique');
    }

    public function replicate(AuthUser $authUser, Rubrique $rubrique): bool
    {
        return $authUser->can('Replicate:Rubrique');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Rubrique');
    }
}
