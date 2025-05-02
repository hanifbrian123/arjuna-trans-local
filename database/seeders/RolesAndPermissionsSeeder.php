<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage booking',
            'booking index',
            'booking create',
            'booking show',
            'booking accept',
            'booking complete',
            'booking destroy',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        $roles = [
            'admin',
            'driver',
            'customer',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
