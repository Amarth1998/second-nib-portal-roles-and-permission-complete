<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HrHeadSeeder extends Seeder
{
    public function run()
    {
        // Create the Super Admin user
        $user = User::firstOrCreate(
            ['email' => 'hrhead@gmail.com'],
            [
                'name' => 'Hr Head',
                'password' => bcrypt('password123'), // Default password
            ]
        );

        // Check if Super Admin role exists
        $hrHeadRole = Role::where('name', 'HrHead')->first();
        if ($hrHeadRole) {
            // Assign hrHead role to the user
            $user->assignRole($hrHeadRole);

            // Assign all permissions to the Super Admin user
            // $permissions = Permission::all(); // Fetch all permissions
            // $user->syncPermissions($permissions);

            // Log success message
            $this->command->info('Hr Head created successfully with role and permissions.');
        } else {
            // Log failure message
            $this->command->error('Hr Head role does not exist. Run RolePermissionSeeder first.');
        }
    }
}