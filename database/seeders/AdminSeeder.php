<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view_dashboard',
            'manage_users',
            'view_users',
            'manage_roles',
            'view_roles',
            'manage_permissions',
            'view_permissions',
            'system_settings',
            'manage_categories',
            'view_categories',
            'manage_products',
            'view_products',
            'manage_orders',
            'view_orders',
            'manage_tasks',
            'view_tasks',
            'manage_settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions to roles
        // Admin role should always have all permissions
        $adminRole->syncPermissions(Permission::all());

        $moderatorRole->givePermissionTo([
            'view_dashboard',
            'manage_users',
            'view_users',
            'view_roles',
            'view_permissions',
            'manage_categories',
            'view_categories',
            'manage_products',
            'view_products',
            'manage_orders',
            'view_orders',
            'manage_tasks',
            'view_tasks'
        ]);

        $userRole->givePermissionTo([
            'view_dashboard',
            'view_categories',
            'view_products',
            'view_orders',
            'view_tasks'
        ]);

        // Create users
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        $moderatorUser = User::firstOrCreate(
            ['email' => 'moderator@example.com'],
            [
                'name' => 'Moderator User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        $regularUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Assign roles to users
        $adminUser->assignRole('admin');
        $moderatorUser->assignRole('moderator');
        $regularUser->assignRole('user');

        $this->command->info('Admin seeder completed successfully!');
        $this->command->info('Admin login: admin@example.com / password123');
        $this->command->info('Moderator login: moderator@example.com / password123');
        $this->command->info('User login: user@example.com / password123');
    }
}
