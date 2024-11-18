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
        
        // HR Department Roles
        $hrHeadRole = Role::create(['name' => 'HrHead']);
        $hrRole = Role::create(['name' => 'Hr']);


        // Define permissions for HR operations
        // $hrPermissions = [
        //     'view customers',
        //     'add customers',
        //     'edit customers',
        //     'delete customers'

        // ];

        $hrHeadPermissions=[
                // 'HR-master details',
                'Create Employee',
                'Create POSP',
                'Create MISP',
                'New Broker Branch',
                'Add Group',
                'Add Sub Group',
                'Add Designation',
                'Add Zone',
                'Add Regions',
                'Add City',
                'Bank Master',
                'Leave Master',
                'Policy refers by data',
                'Policy refers by add',
                // 'HR-Generate details',
                'Relieving Letter (for employees)',
                'POSP Relieving Letter (for POSP)',
                'Experience Letter (for employees)',
                'Appointment Letter (for employees)',
                'Offer Letter (for employees)',
                'POSP certificate (for POSP)',
                'Termination Letter (for employees)',
                'Full and final Settlement (for employee)',
                // 'HR Reports',
                'POSP and employee application form',
                'POSP and employee Reports',
                'POSP Certificate',
                'POSP and employee account details Reports',
                'Employee Login Reports',
                'POSP and employee Relieving letter',
                'Employee terminate Reports',
                'Employee Attendance Reports',
                'Employee salary report',
                'Appointment Letter employee Reports',
                'Requisition Reports',
                'Target Reports (for employee in sales person)',
                'CTC Reports (for employee)',
                'Offer letter Reports (for employee)',
                // 'HR Entry-HR SECTION',
                'Requisition form',
                'Target form',
                'Add Inventory form'
            ];
    

        foreach ($hrHeadPermissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $hrHeadRole->givePermissionTo($permission);
        }

        // Define additional permissions for HR Head
        // $hrHeadPermissions = [
        //     'assign_roles',
        //     'assign_permissions',
        //     'revoke_permissions',
        // ];

        foreach ($hrHeadPermissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $hrHeadRole->givePermissionTo($permission);
        }

        // Admin permissions: Cannot assign Super Admin role
        // $adminPermissions = [
        //     'assign_roles',
        //     'assign_permissions',
        //     'revoke_permissions',
        // ];


        // foreach ($adminPermissions as $permissionName) {
        //     $permission = Permission::firstOrCreate(['name' => $permissionName]);
        //     $adminRole->givePermissionTo($permission);
        // }

        // HR Head Restrictions: Cannot assign Super Admin or Admin roles
        $hrHeadRole->syncPermissions($hrHeadPermissions );


        // Assign all permissions to Super Admin
        $superAdminRole->syncPermissions(Permission::all());
    }
}
