<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PastorActivity;
use Illuminate\Auth\Access\HandlesAuthorization;

class PastorActivityPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PastorActivity');
    }

    public function view(AuthUser $authUser, PastorActivity $pastorActivity): bool
    {
        return $authUser->can('View:PastorActivity');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PastorActivity');
    }

    public function update(AuthUser $authUser, PastorActivity $pastorActivity): bool
    {
        return $authUser->can('Update:PastorActivity');
    }

    public function delete(AuthUser $authUser, PastorActivity $pastorActivity): bool
    {
        return $authUser->can('Delete:PastorActivity');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PastorActivity');
    }

    public function restore(AuthUser $authUser, PastorActivity $pastorActivity): bool
    {
        return $authUser->can('Restore:PastorActivity');
    }

    public function forceDelete(AuthUser $authUser, PastorActivity $pastorActivity): bool
    {
        return $authUser->can('ForceDelete:PastorActivity');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PastorActivity');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PastorActivity');
    }

    public function replicate(AuthUser $authUser, PastorActivity $pastorActivity): bool
    {
        return $authUser->can('Replicate:PastorActivity');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PastorActivity');
    }

}