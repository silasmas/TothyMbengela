<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AppointmentRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentRequestPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AppointmentRequest');
    }

    public function view(AuthUser $authUser, AppointmentRequest $appointmentRequest): bool
    {
        return $authUser->can('View:AppointmentRequest');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AppointmentRequest');
    }

    public function update(AuthUser $authUser, AppointmentRequest $appointmentRequest): bool
    {
        return $authUser->can('Update:AppointmentRequest');
    }

    public function delete(AuthUser $authUser, AppointmentRequest $appointmentRequest): bool
    {
        return $authUser->can('Delete:AppointmentRequest');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:AppointmentRequest');
    }

    public function restore(AuthUser $authUser, AppointmentRequest $appointmentRequest): bool
    {
        return $authUser->can('Restore:AppointmentRequest');
    }

    public function forceDelete(AuthUser $authUser, AppointmentRequest $appointmentRequest): bool
    {
        return $authUser->can('ForceDelete:AppointmentRequest');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AppointmentRequest');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AppointmentRequest');
    }

    public function replicate(AuthUser $authUser, AppointmentRequest $appointmentRequest): bool
    {
        return $authUser->can('Replicate:AppointmentRequest');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AppointmentRequest');
    }

}