<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionDetailsSeeder extends Seeder
{
    public function run()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        foreach ($roles as $role) {
            foreach ($role->permissions as $permission) {
                DB::table('role_permission_details')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission->id,
                    'role_name' => $role->name,
                    'permission_name' => $permission->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
