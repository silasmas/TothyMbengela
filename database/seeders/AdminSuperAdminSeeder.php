<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSuperAdminSeeder extends Seeder
{
    /**
     * Crée le rôle super_admin (guard admin), y attache toutes les permissions guard admin,
     * puis l’assigne à l’administrateur id = 1 (et aux autres sans ce rôle).
     *
     * Avec define_via_gate=true (config/filament-shield.php), le super_admin passe déjà
     * toutes les policies via Gate::before ; syncPermissions sert surtout à la cohérence
     * en base et aux écrans Shield « rôles ».
     */
    public function run(): void
    {
        $role = Role::query()->firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'admin'],
        );

        $permissions = Permission::query()->where('guard_name', 'admin')->get();
        if ($permissions->isNotEmpty()) {
            $role->syncPermissions($permissions);
        }

        // Tous les admins sans rôle reçoivent super_admin (accès dashboard Filament).
        Admin::query()->each(function (Admin $admin) use ($role): void {
            if (! $admin->hasRole($role)) {
                $admin->assignRole($role);
            }
        });
    }
}

