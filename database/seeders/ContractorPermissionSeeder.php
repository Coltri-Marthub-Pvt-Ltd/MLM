<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ContractorPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create contractor management permissions
        $permissions = [
            'manage_contractors',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }
    }
}
