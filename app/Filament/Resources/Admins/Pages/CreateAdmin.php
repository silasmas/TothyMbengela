<?php

namespace App\Filament\Resources\Admins\Pages;

use App\Filament\Resources\Admins\AdminResource;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Role;

/**
 * Création d’un administrateur Filament.
 */
class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    /**
     * Après création : attribue super_admin si aucun rôle n’a été choisi.
     *
     * @return void
     */
    protected function afterCreate(): void
    {
        $admin = $this->record;

        if ($admin->roles()->exists()) {
            return;
        }

        $role = Role::query()->firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'admin'],
        );

        $admin->assignRole($role);
    }
}
