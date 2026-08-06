<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ShopSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopSettingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ShopSetting');
    }

    public function view(AuthUser $authUser, ShopSetting $shopSetting): bool
    {
        return $authUser->can('View:ShopSetting');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ShopSetting');
    }

    public function update(AuthUser $authUser, ShopSetting $shopSetting): bool
    {
        return $authUser->can('Update:ShopSetting');
    }

    public function delete(AuthUser $authUser, ShopSetting $shopSetting): bool
    {
        return $authUser->can('Delete:ShopSetting');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ShopSetting');
    }

    public function restore(AuthUser $authUser, ShopSetting $shopSetting): bool
    {
        return $authUser->can('Restore:ShopSetting');
    }

    public function forceDelete(AuthUser $authUser, ShopSetting $shopSetting): bool
    {
        return $authUser->can('ForceDelete:ShopSetting');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ShopSetting');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ShopSetting');
    }

    public function replicate(AuthUser $authUser, ShopSetting $shopSetting): bool
    {
        return $authUser->can('Replicate:ShopSetting');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ShopSetting');
    }

}