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
        //admin  
        $adminRole = Role::create(['name' => 'Admin']);

        // Departments
        $hrRole = Role::create(['name' => 'HR']);
        $operationsRole = Role::create(['name' => 'Operations']);
        $salesRole = Role::create(['name' => 'Sales']);
        $salesAndMarketing = Role::create(['name' => 'SalesAndMarketing']);
        $pospRole = Role::create(['name' => 'Posp']);
        $supportRole = Role::create(['name' => 'Support']);
        $itRole = Role::create(['name' => 'IT']);
        $claimsRole = Role::create(['name' => 'Claims']);
        $renewalasRole = Role::create(['name' => 'Renewal']);
        $accountsRole = Role::create(['name' => 'Accounts']);


        // Create permissions
        $permissions = [
            'view customers',
            'add customers',
            'edit customers',
            'delete customers'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to Super Admin
        $superAdminRole->syncPermissions(Permission::all());
    }
}
