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
//         $super_Admin_Role = Role::create(['name' => 'SuperAdmin']);

//         //admins role 
//         $head_Admin_Role = Role::create(['name' => 'HeadAdmin']);
//         $sub_Admin_Role = Role::create(['name' => 'SubHeadAdmin']);

//         // HR Department Roles
//         $hr_Head_Role = Role::create(['name' => 'HrHead']);
//         $sub_Hr_Head_Role = Role::create(['name' => 'SubHrHead']);

//         //hr role
//         $hr_Role = Role::create(['name' => 'Hr']);



//         $hrHeadPermissions = [

//             // 'HR-master details',
//             'Employee_Create',
//             'Employee_Update',
//             'Employee_Delete',
//             'Employee_View',

//             'POSP_Create',
//             'POSP_Update',
//             'POSP_Delete',
//             'POSP_View',

//             'MISP_Create',
//             'MISP_Update',
//             'MISP_Delete',
//             'MISP_View',

//             'Broker_Branch_Create',
//             'Broker_Branch_Update',
//             'Broker_Branch_Delete',
//             'Broker_Branch_View',

//             'Group_Create',
//             'Group_Update',
//             'Group_Delete',
//             'Group_View',

//             'Sub_Group_Create',
//             'Sub_Group_Update',
//             'Sub_Group_Delete',
//             'Sub_Group_View',


//             'Designation_Create',
//             'Designation_Update',
//             'Designation_Delete',
//             'Designation_View',

//             'Zone_Create',
//             'Zone_Update',
//             'Zone_Delete',
//             'Zone_View',

//             'Regions_Create',
//             'Regions_Update',
//             'Regions_Delete',
//             'Regions_View',

//             'City_Create',
//             'City_Update',
//             'City_Delete',
//             'City_View',

//             'Bank_Master_Create',
//             'Bank_Master_Update',
//             'Bank_Master_Delete',
//             'Bank_Master_View',

//             'Policy_Refers_By_Data_Create',
//             'Policy_Refers_By_Data_Update',
//             'Policy_Refers_By_Data_Delete',
//             'Policy_Refers_By_Data_View',

//             'Leave_Master_Create',
//             'Leave_Master_Update',
//             'Leave_Master_Delete',
//             'Leave_Master_View',


//             // 'HR Entry-HR SECTION',
//             'Requisition_Create',
//             'Requisition_Update',
//             'Requisition_Delete',
//             'Requisition_View',

//             'Inventory_Create',
//             'Inventory_Update',
//             'Inventory_Delete',
//             'Inventory_View',

//             'Target_Create',
//             'Target_Update',
//             'Target_Delete',
//             'Target_View',


//             // 'HR-Generate details',
//             'Employee_Relieving_Letter',
//             'Employee_Experience_Letter',
//             'Employee_Appointment_Letter',
//             'Employee_Offer_Letter',
//             'Employee_Termination_Letter',
//             'Employee_Full_and_Final_Settlement',
//             'POSP_Certificate',
//             'POSP_Relieving_Letter',

//             // 'HR Reports',
//             "Employee_Application_Report",
//             "Employee_Report",
//             "Employee_Account_Details_Reports",
//             'Employee_Login_Reports',
//             "Employee_Relieving_Letter",
//             'Employee_Terminate_Reports',
//             'Employee_Attendance_Reports',
//             'Employee_Salary_Report',
//             'Employee_Appointment_Letter_Reports',
//             'Requisition_Reports',
//             'Sales_Employee_Target_Reports',
//             'Employee_CTC_Reports',
//             'Employee_Offer_Letter_Reports',
//             "POSP_Report",
//             'POSP_Application_Report',
//             'POSP_Relieving_Letter',
//             'POSP_Account_Details_Reports',
//             'POSP_Certificate_Report',

//         ];

//         // Create permissions and assign them to the respective roles
//         foreach ($hrHeadPermissions as $permissionName) {
//             $permission = Permission::firstOrCreate(['name' => $permissionName]);
//             $hr_Head_Role->givePermissionTo($permission);
//             $sub_Hr_Head_Role->givePermissionTo($permission);
//             $hr_Role->givePermissionTo($permission);
//         }

//         // foreach ($hrHeadPermissions as $permissionName) {
//         //     $permission = Permission::firstOrCreate(['name' => $permissionName]);
//         //     $hr_Head_Role->givePermissionTo($permission);
//         // }

//         // foreach ($hrHeadPermissions as $permissionName) {
//         //     $permission = Permission::firstOrCreate(['name' => $permissionName]);
//         //     $sub_Hr_Head_Role->givePermissionTo($permission);
//         // }

//         // foreach ($hrHeadPermissions as $permissionName) {
//         //     $permission = Permission::firstOrCreate(['name' => $permissionName]);
//         //     $hr_Role->givePermissionTo($permission);
//         // }


//         //********************* Head branch ************************
//         // Assign all permissions to Super Admin
//         $super_Admin_Role->syncPermissions(Permission::all());

//         // Assign all permissions to Head Admin
//         $head_Admin_Role->syncPermissions(Permission::all());

//         // Assign all HR Head role permissions to HR Head Role
//         $hr_Head_Role->syncPermissions($hrHeadPermissions);



//         //********************* Sub branch ************************

//         // Assign all permissions to Sub  Admin
//         $sub_Admin_Role->syncPermissions(Permission::all());

//         // Assign  all  HR Head role permissions to sub HR Head Role
//         $sub_Hr_Head_Role->syncPermissions($hrHeadPermissions);




//         //********************* common  ************************

//         // Assign  all  HR Head role permissions to  HR Role
//         $hr_Role->syncPermissions($hrHeadPermissions);
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
        // Clear cache to avoid conflicts
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
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
            'Broker_Branch_Create',
            'Broker_Branch_Update',
            'Broker_Branch_Delete',
            'Broker_Branch_View',
            'Employee_Reports',
            'POSP_Reports',
            'Branch_Reports',
            'Sales_Reports',
        ];

        // Define roles
        $roles = [
            'SuperAdmin',
            'HeadAdmin',
            'SubHeadAdmin',
            'HrHead',
            'SubHrHead',
            'Hr',
        ];

        // Step 1: Create permissions with guard_name "sanctum"
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(
                ['name' => $permissionName, 'guard_name' => 'sanctum']
            );
        }

        // Step 2: Create roles with guard_name "sanctum"
        foreach ($roles as $roleName) {
            Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => 'sanctum']
            );
        }

        // Step 3: Assign permissions to roles
        // Assign all permissions to SuperAdmin
        $superAdmin = Role::where('name', 'SuperAdmin')->where('guard_name', 'sanctum')->first();
        $superAdmin->syncPermissions(Permission::where('guard_name', 'sanctum')->get());

        // Assign all permissions to HeadAdmin
        $headAdmin = Role::where('name', 'HeadAdmin')->where('guard_name', 'sanctum')->first();
        $headAdmin->syncPermissions(Permission::where('guard_name', 'sanctum')->get());

        // Assign specific permissions to HrHead
        $hrHead = Role::where('name', 'HrHead')->where('guard_name', 'sanctum')->first();
        $hrHead->givePermissionTo([
            'Employee_Create',
            'Employee_Update',
            'Employee_Delete',
            'Employee_View',
            'POSP_Create',
            'POSP_Update',
            'POSP_Delete',
            'POSP_View',
            'Employee_Reports',
        ]);

        // Assign permissions to SubHrHead
        $subHrHead = Role::where('name', 'SubHrHead')->where('guard_name', 'sanctum')->first();
        $subHrHead->givePermissionTo([
            'Employee_Create',
            'Employee_Update',
            'Employee_View',
            'POSP_View',
        ]);

        // Assign limited permissions to Hr
        $hr = Role::where('name', 'Hr')->where('guard_name', 'sanctum')->first();
        $hr->givePermissionTo([
            'Employee_View',
        ]);

        // Assign permissions to SubHeadAdmin
        $subHeadAdmin = Role::where('name', 'SubHeadAdmin')->where('guard_name', 'sanctum')->first();
        $subHeadAdmin->givePermissionTo([
            'Broker_Branch_View',
            'Sales_Reports',
        ]);

        // Log seeded data
        $this->command->info('Roles and permissions with guard_name "sanctum" have been successfully seeded.');
    }
}
