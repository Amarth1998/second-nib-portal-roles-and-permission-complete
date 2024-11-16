<?php

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
        $operationsRole = Role::create(['name' => 'Operations']);
        $operationHeadRole = Role::create(['name' => 'OperationHead']);

        // Define permissions for Operations role
        $operationsPermissions = [
            'Relieving Letter (for employees)',
            'POSP Relieving Letter (for POSP)',
            'Experience Letter (for employees)',
            'Appointment Letter (for employees)',
            'Offer Letter (for employees)',
            'POSP certificate (for POSP)',
            'Termination Letter (for employees)',
            'Full and final Settlement (for employee)',
        ];

        foreach ($operationsPermissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $operationsRole->givePermissionTo($permission);
            $operationHeadRole->givePermissionTo($permission);
        }

        // Additional permissions for OperationHead to manage roles and permissions
        $operationHeadPermissions = [
            'assign roles',
            'assign permissions',
            'revoke permissions',
        ];

        foreach ($operationHeadPermissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $operationHeadRole->givePermissionTo($permission);
        }

        // Assign all permissions to Super Admin
        $superAdminRole->syncPermissions(Permission::all());
    }
}

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

//         //admin  
//         $adminRole = Role::create(['name' => 'Admin']);

//         // Departments
//         $hrRole = Role::create(['name' => 'HR']);
//         $operationsRole = Role::create(['name' => 'Operations']);
//         $salesRole = Role::create(['name' => 'Sales']);
//         $salesAndMarketing = Role::create(['name' => 'SalesAndMarketing']);
//         $pospRole = Role::create(['name' => 'Posp']);
//         $supportRole = Role::create(['name' => 'Support']);
//         $itRole = Role::create(['name' => 'IT']);
//         $claimsRole = Role::create(['name' => 'Claims']);
//         $renewalasRole = Role::create(['name' => 'Renewal']);
//         $accountsRole = Role::create(['name' => 'Accounts']);


//         // Create permissions
//         $permissions = [
//             'view customers',
//             'add customers',
//             'edit customers',
//             'delete customers'
//         ];



//         foreach ($permissions as $permission) {
//             Permission::create(['name' => $permission]);
//         }

//         // Assign all permissions to Super Admin
//         $superAdminRole->syncPermissions(Permission::all());
//     }
// }
