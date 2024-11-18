<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create the Super Admin user
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password123'), // Default password
            ]
        );

        // Check if Super Admin role exists
        $AdminRole = Role::where('name', 'Admin')->first();
        if ($AdminRole) {
            // Assign  Admin role to the user
            $user->assignRole($AdminRole);

            // Assign all permissions to the Super Admin user
            // $permissions = Permission::all(); // Fetch all permissions
            // $user->syncPermissions($permissions);

            // Log success message
            $this->command->info('Admin created successfully with role and permissions.');
        } else {
            // Log failure message
            $this->command->error(' Admin role does not exist. Run RolePermissionSeeder first.');
        }
    }
}