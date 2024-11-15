<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Create the Super Admin user
        $user = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123'), // Default password
            ]
        );

        // Check if Super Admin role exists
        $superAdminRole = Role::where('name', 'superadmin')->first();
        if ($superAdminRole) {
            // Assign Super Admin role to the user
            $user->assignRole($superAdminRole);

            // Assign all permissions to the Super Admin user
            $permissions = Permission::all(); // Fetch all permissions
            $user->syncPermissions($permissions);

            // Log success message
            $this->command->info('Super Admin created successfully with role and permissions.');
        } else {
            // Log failure message
            $this->command->error('Super Admin role does not exist. Run RolePermissionSeeder first.');
        }
    }
}

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use App\Models\User;
// use Spatie\Permission\Models\Role;

// class SuperAdminSeeder extends Seeder
// {
//     public function run()
//     {
//         // Create the Super Admin user
//         $user = User::firstOrCreate(
//             ['email' => 'superadmin@example.com'],
//             [
//                 'name' => 'Super Admin',
//                 'password' => bcrypt('password123'), // Default password
//             ]
//         );

//         // Check if Super Admin role exists
//         $superAdminRole = Role::where('name', 'Super Admin')->first();

//         if ($superAdminRole) {
//             // Assign Super Admin role to the user
//             $user->assignRole($superAdminRole);

//             // Log success message
//             $this->command->info('Super Admin created successfully with role.');
//         } else {
//             // Log failure message
//             $this->command->error('Super Admin role does not exist. Run RolePermissionSeeder first.');
//         }
//     }
// }

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use App\Models\User;
// use Spatie\Permission\Models\Role;

// class SuperAdminSeeder extends Seeder
// {
//     public function run()
//     {
//         // Create the Super Admin user
//         $user = User::firstOrCreate(
//             ['email' => 'superadmin@example.com'],
//             [
//                 'name' => 'Super Admin',
//                 'password' => bcrypt('password123'), // Default password
//             ]
//         );

//         // Assign Super Admin role to the user
//         $superAdminRole = Role::where('name', 'Super Admin')->first();
//         if ($superAdminRole) {
//             $user->assignRole($superAdminRole);
//         }
//     }
// }
