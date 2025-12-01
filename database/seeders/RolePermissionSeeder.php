<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permissions
        $permissions = [
            'manage users',
            'view bookings',
            'manage vendors',
            'process payouts',
            'moderate reviews',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $roles = [
            'Super Admin',
            'Admin',
            'Finance Manager',
            'Vendor Manager',
            'Support Staff',
            'Quality Control',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Assign permissions
        Role::findByName('Super Admin')->givePermissionTo(Permission::all());
        Role::findByName('Admin')->givePermissionTo(['manage users', 'view bookings']);
        Role::findByName('Finance Manager')->givePermissionTo(['process payouts']);
        Role::findByName('Vendor Manager')->givePermissionTo(['manage vendors']);
        Role::findByName('Support Staff')->givePermissionTo(['manage users']);
        Role::findByName('Quality Control')->givePermissionTo(['moderate reviews']);
    }
}
