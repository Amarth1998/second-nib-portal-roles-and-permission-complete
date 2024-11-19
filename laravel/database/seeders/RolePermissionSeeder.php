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

                // '_Create',
                // '_Update',
                // '_Delete',
                // '_View',

        $hrHeadPermissions=[

                // 'HR-master details',
                'Employee_Create',
                'Employee_Update',
                'Employee_Delete',
                'Employee_View',

                'POSP_Create',
                'POSP_Update',
                'POSP_Delete',
                'POSP_View',

                'MISP_Create',
                'MISP_Update',
                'MISP_Delete',
                'MISP_View',

                'Broker Branch_Create',
                'Broker Branch_Update',
                'Broker Branch_Delete',
                'Broker Branch_View',

                'Group_Create',
                'Group_Update',
                'Group_Delete',
                'Group_View',

                'Sub Group_Create',
                'Sub Group_Update',
                'Sub Group_Delete',
                'Sub Group_View',

               
                'Designation_Create',
                'Designation_Update',
                'Designation_Delete',
                'Designation_View',

                'Zone_Create',
                'Zone_Update',
                'Zone_Delete',
                'Zone_View',

                'Regions_Create',
                'Regions_Update',
                'Regions_Delete',
                'Regions_View',

                'City_Create',
                'City_Update',
                'City_Delete',
                'City_View',

                'Bank Master_Create',
                'Bank Master_Update',
                'Bank Master_Delete',
                'Bank Master_View',
                
                'Policy Refers By Data_Create',
                'Policy Refers By Data_Update',
                'Policy Refers By Data_Delete',
                'Policy Refers By Data_View',
                
                'Leave Master_Create',
                'Leave Master_Update',
                'Leave Master_Delete',
                'Leave Master_View',
    

                // 'HR Entry-HR SECTION',

                'Requisition_Create',
                'Requisition_Update',
                'Requisition_Delete',
                'Requisition_View',
                
                'Inventory_Create',
                'Inventory_Update',
                'Inventory_Delete',
                'Inventory_View',

                'Target_Create',
                'Target_Update',
                'Target_Delete',
                'Target_View',


                // 'HR-Generate details',
                'Employee Relieving Letter',
                'Employee Experience Letter',
                'Employee Appointment Letter',
                'Employee Offer Letter',
                'Employee Termination Letter',
                'Employee Full and Final Settlement',
                'POSP Certificate',
                'POSP Relieving Letter',



                // 'Relieving Letter (for employees)',
                // 'POSP Relieving Letter (for POSP)',
                // 'Experience Letter (for employees)',
                // 'Appointment Letter (for employees)',
                // 'Offer Letter (for employees)',
                // 'POSP certificate (for POSP)',
                // 'Termination Letter (for employees)',
                // 'Full and final Settlement (for employee)',

                // 'HR Reports',

                // 'POSP and employee application form',
                // 'POSP and employee Reports',
                // 'POSP Certificate',
                // 'POSP and employee account details Reports',
                // 'Employee Login Reports',
                // 'POSP and employee Relieving letter',
                // 'Employee terminate Reports',
                // 'Employee Attendance Reports',
                // 'Employee salary report',
                // 'Appointment Letter employee Reports',
                // 'Requisition Reports',
                // 'Target Reports (for employee in sales person)',
                // 'CTC Reports (for employee)',
                // 'Offer letter Reports (for employee)',
            ];
    

        foreach ($hrHeadPermissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $hrHeadRole->givePermissionTo($permission);
        }


 
         // Assign all permissions to HR
        $hrHeadRole->syncPermissions($hrHeadPermissions );


        // Assign all permissions to Super Admin
        $superAdminRole->syncPermissions(Permission::all());
    }
}
