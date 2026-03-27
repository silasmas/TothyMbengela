<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PartnerCommitment;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PartnerCommitmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PartnerCommitment');
    }

    public function view(AuthUser $authUser, PartnerCommitment $partnerCommitment): bool
    {
        return $authUser->can('View:PartnerCommitment');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PartnerCommitment');
    }

    public function update(AuthUser $authUser, PartnerCommitment $partnerCommitment): bool
    {
        return $authUser->can('Update:PartnerCommitment');
    }

    public function delete(AuthUser $authUser, PartnerCommitment $partnerCommitment): bool
    {
        return $authUser->can('Delete:PartnerCommitment');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PartnerCommitment');
    }

    public function restore(AuthUser $authUser, PartnerCommitment $partnerCommitment): bool
    {
        return $authUser->can('Restore:PartnerCommitment');
    }

    public function forceDelete(AuthUser $authUser, PartnerCommitment $partnerCommitment): bool
    {
        return $authUser->can('ForceDelete:PartnerCommitment');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PartnerCommitment');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PartnerCommitment');
    }

    public function replicate(AuthUser $authUser, PartnerCommitment $partnerCommitment): bool
    {
        return $authUser->can('Replicate:PartnerCommitment');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PartnerCommitment');
    }
}
