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
            ['email' => 'superadmin@gmail.com'],
            [
                'branch_id' => 1,
                'name' => 'SUPER Admin',
                // 'password'=>'123'
                'password' => bcrypt('123'), // Default password
            ]
        );

        // Ensure the Super Admin role exists with guard_name "sanctum"
        $SuperAdminRole = Role::where('name', 'SuperAdmin')
            ->where('guard_name', 'sanctum')
            ->first();

        if ($SuperAdminRole) {
            // Assign the Super Admin role to the user
            $user->assignRole($SuperAdminRole);

            // Fetch all permissions with guard_name "sanctum"
            $permissions = Permission::where('guard_name', 'sanctum')->get();

            // Sync permissions to the Super Admin user
            $user->syncPermissions($permissions);

            // Log success message
            $this->command->info('Super Admin created successfully with role and permissions.');
        } else {
            // Log failure message if SuperAdmin role does not exist
            $this->command->error('Super Admin role does not exist. Run RolePermissionSeeder first.');
        }
    }
}
