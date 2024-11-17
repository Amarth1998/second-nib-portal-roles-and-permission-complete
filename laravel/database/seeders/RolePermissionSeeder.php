<?php 

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

// class RolePermissionSeeder extends Seeder
// {
//     public function run()
//     {
//         // Create roles
//         $superAdminRole = Role::create(['name' => 'SuperAdmin']);
//         $adminRole = Role::create(['name' => 'Admin']);
        
//         //hr department
//         $hrHeadRole = Role::create(['name' => 'HrHead']);
//         $hrSubHeadRole = Role::create(['name' => 'HrSubHead']);
//         $hrRole = Role::create(['name' => 'Hr']);


//         $operationsRole = Role::create(['name' => 'Operations']);
//         $operationHeadRole = Role::create(['name' => 'OperationHead']);

//         // Define permissions for Operations role
//         $operationsPermissions = [
//             'Relieving Letter (for employees)',
//             'POSP Relieving Letter (for POSP)',
//             'Experience Letter (for employees)',
//             'Appointment Letter (for employees)',
//             'Offer Letter (for employees)',
//             'POSP certificate (for POSP)',
//             'Termination Letter (for employees)',
//             'Full and final Settlement (for employee)',
//         ];

//         foreach ($operationsPermissions as $permissionName) {
//             $permission = Permission::firstOrCreate(['name' => $permissionName]);
//             $operationsRole->givePermissionTo($permission);
//             $operationHeadRole->givePermissionTo($permission);
//         }

//         // Additional permissions for OperationHead to manage roles and permissions
//         $operationHeadPermissions = [
//             'assign roles',
//             'assign permissions',
//             'revoke permissions',
//         ];

//         foreach ($operationHeadPermissions as $permissionName) {
//             $permission = Permission::firstOrCreate(['name' => $permissionName]);
//             $operationHeadRole->givePermissionTo($permission);
//         }

//         // Assign all permissions to Super Admin
//         $superAdminRole->syncPermissions(Permission::all());
//     }
// }





// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

// class RolePermissionSeeder extends Seeder
// {
//     public function run()
//     {
//         // Create roles
//         $superAdminRole = Role::create(['name' => 'SuperAdmin']);
//         $adminRole = Role::create(['name' => 'Admin']);
        
//         //hr department
//         $hrHeadRole = Role::create(['name' => 'HrHead']);
//         $hrSubHeadRole = Role::create(['name' => 'HrSubHead']);
//         $hrRole = Role::create(['name' => 'Hr']);


//         // Define permissions for Operations role
//         $hrPermissions = [
//             'Relieving Letter (for employees)',
//             'POSP Relieving Letter (for POSP)',
//             'Experience Letter (for employees)',
//             'Appointment Letter (for employees)',
//             'Offer Letter (for employees)',
//             'POSP certificate (for POSP)',
//             'Termination Letter (for employees)',
//             'Full and final Settlement (for employee)',
//         ];

//         foreach ($hrPermissions as $permissionName) {
//             $permission = Permission::firstOrCreate(['name' => $permissionName]);
//             $hrHeadRole->givePermissionTo($permission);
//             $hrSubHeadRole->givePermissionTo($permission);
//             $hrRole->givePermissionTo($permission);

//         }

//         // Additional permissions for OperationHead to manage roles and permissions
//         $hrHeadPermissions = [
//             'assign roles',
//             'assign permissions',
//             'revoke permissions',
//         ];

//         foreach ($hrHeadPermissions  as $permissionName) {
//             $permission = Permission::firstOrCreate(['name' => $permissionName]);
//             $hrHeadRole->givePermissionTo($permission);
//         }

//         // Assign all permissions to Super Admin
//         $superAdminRole->syncPermissions(Permission::all());
//     }
// }







namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $superAdminRole = Role::create(['name' => 'SuperAdmin']);
        $adminRole = Role::create(['name' => 'Admin']);
        
        // HR Department Roles
        $hrHeadRole = Role::create(['name' => 'HrHead']);
        $hrSubHeadRole = Role::create(['name' => 'HrSubHead']);
        $hrRole = Role::create(['name' => 'Hr']);


        $hrHeadRole

        // Define permissions for HR operations
        $hrPermissions = [
            'view customers',
            'add customers',
            'edit customers',
            'delete customers'
        ];




        foreach ($hrPermissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $hrHeadRole->givePermissionTo($permission);
            $hrSubHeadRole->givePermissionTo($permission);
            $hrRole->givePermissionTo($permission);
        }

        // Define additional permissions for HR Head
        $hrHeadPermissions = [
            'assign_roles',
            'assign_permissions',
            'revoke_permissions',
        ];

        foreach ($hrHeadPermissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $hrHeadRole->givePermissionTo($permission);
        }

        // Admin permissions: Cannot assign Super Admin role
        $adminPermissions = [
            'assign_roles',
            'assign_permissions',
            'revoke_permissions',
        ];

        foreach ($adminPermissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $adminRole->givePermissionTo($permission);
        }

        // HR Head Restrictions: Cannot assign Super Admin or Admin roles
        $hrHeadRole->syncPermissions($hrHeadPermissions + $hrPermissions);

        // HR Sub Head Restrictions: Cannot assign Super Admin, HR Head, or Admin roles
        $hrSubHeadRole->syncPermissions($hrPermissions);

        // HR Role Restrictions: Cannot assign Super Admin, Admin, or HR Head roles
        $hrRole->syncPermissions($hrPermissions);

        // Assign all permissions to Super Admin
        $superAdminRole->syncPermissions(Permission::all());
    }
}
