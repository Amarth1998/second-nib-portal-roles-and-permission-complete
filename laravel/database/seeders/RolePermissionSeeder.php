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




// namespace Database\Seeders;
// use Dotenv\Parser\Entry;
// use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

// class RolePermissionSeeder extends Seeder
// {
//     public function run()
//     {
//         // Define the guard name
//         $guardName = 'sanctum';

//         // Create roles with the specified guard name

//         $super_Admin_Role = Role::create(['name' => 'SuperAdmin', 'guard_name' => $guardName]);
//         $head_Admin_Role = Role::create(['name' => 'HeadAdmin', 'guard_name' => $guardName]);
//         $hr_Head_Role = Role::create(['name' => 'HrHead', 'guard_name' => $guardName]);

//         $operation_Head_Role = Role::create(['name' => 'OperationHead', 'guard_name' => $guardName]);


//         $hr_Role = Role::create(['name' => 'Hr', 'guard_name' => $guardName]);
//         $operation_Role = Role::create(['name' => 'Operation', 'guard_name' => $guardName]);


//         $sub_Admin_Role = Role::create(['name' => 'SubHeadAdmin', 'guard_name' => $guardName]);
//         $sub_Hr_Head_Role = Role::create(['name' => 'SubHrHead', 'guard_name' => $guardName]);
//         $sub_operation_Head_Role = Role::create(['name' => 'SubOperationHead', 'guard_name' => $guardName]);






//         // List of HR Head permissions
//         $hrdepartmentPermissions = [
//             'Employee_Create',
//             'Employee_Update',
//             'Employee_Delete',
//             'Employee_Read',

//             'POSP_Create',
//             'POSP_Update',
//             'POSP_Delete',
//             'POSP_Read',

//             'MISP_Create',
//             'MISP_Update',
//             'MISP_Delete',
//             'MISP_Read',

//             'Broker_Branch_Create',
//             'Broker_Branch_Update',
//             'Broker_Branch_Delete',
//             'Broker_Branch_Read',

//             'Group_Create',
//             'Group_Update',
//             'Group_Delete',
//             'Group_Read',

//             'Sub_Group_Create',
//             'Sub_Group_Update',
//             'Sub_Group_Delete',
//             'Sub_Group_Read',

//             'Designation_Create',
//             'Designation_Update',
//             'Designation_Delete',
//             'Designation_Read',

//             'Zone_Create',
//             'Zone_Update',
//             'Zone_Delete',
//             'Zone_Read',

//             'Regions_Create',
//             'Regions_Update',
//             'Regions_Delete',
//             'Regions_Read',

//             'City_Create',
//             'City_Update',
//             'City_Delete',
//             'City_Read',

//             'Bank_Master_Create',
//             'Bank_Master_Update',
//             'Bank_Master_Delete',
//             'Bank_Master_Read',

//             'Policy_Refers_By_Data_Create',
//             'Policy_Refers_By_Data_Update',
//             'Policy_Refers_By_Data_Delete',
//             'Policy_Refers_By_Data_Read',

//             'Leave_Master_Create',
//             'Leave_Master_Update',
//             'Leave_Master_Delete',
//             'Leave_Master_Read',

//             'Inventory_Create',
//             'Inventory_Update',
//             'Inventory_Delete',
//             'Inventory_Read',

//             'Target_Create',
//             'Target_Update',
//             'Target_Delete',
//             'Target_Read',


//             'Employee_Relieving_Letter',
//             'Employee_Experience_Letter',
//             'Employee_Appointment_Letter',
//             'Employee_Offer_Letter',
//             'Employee_Termination_Letter',
//             'Employee_Full_and_Final_Settlement',
//             'POSP_Certificate',
//             'POSP_Relieving_Letter',


//             //HR REPORTS - DOWNLOAD
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


//         // sales ,opertion ,  posp , operation head
//         $polices = [
//             'Life_create',
//             'Life_delete',
//             'Life_update',
//             'Life_read',
//             'Life_health_create',
//             'Life_health_delete',
//             'Life_health_update',
//             'Life_health_read',
//             'Group_life_create',
//             'Group_life_delete',
//             'Group_life_update',
//             'Group_life_read',
//             'Motor_create',
//             'Motor_delete',
//             'Motor_update',
//             'Motor_read',
//             'Non_life_health_create',
//             'Non_life_health_delete',
//             'Non_life_health_update',
//             'Non_life_health_read',
//             'Non_motor_create',
//             'Non_motor_delete',
//             'Non_motor_update',
//             'Non_motor_read',
//             'Non_life_group_health_create',
//             'Non_life_group_health_delete',
//             'Non_life_group_health_update',
//             'Non_life_group_health_read'
//         ];

//         $Requisition=[
//             'Requisition_Create',
//             'Requisition_Update',
//             'Requisition_Delete',
//             'Requisition_Read',
//         ];


//         // Create permissions with the specified guard name and assign them to roles
//         foreach ($hrdepartmentPermissions as $permissionName) {
//             $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => $guardName]);

//             $hr_Head_Role->givePermissionTo($permission);
//             $sub_Hr_Head_Role->givePermissionTo($permission);
//             $hr_Role->givePermissionTo($permission);
//         }


//         // Assign all permissions to Super Admin and Head Admin roles
//         $super_Admin_Role->syncPermissions(Permission::where('guard_name', $guardName)->get());
//         $head_Admin_Role->syncPermissions(Permission::where('guard_name', $guardName)->get());

//         // Assign HR permissions to HR-related roles
//         $hr_Head_Role->syncPermissions(Permission::where('guard_name', $guardName)->whereIn('name', $hrdepartmentPermissions)->get());
//         $sub_Hr_Head_Role->syncPermissions(Permission::where('guard_name', $guardName)->whereIn('name', $hrdepartmentPermissions)->get());
//         $hr_Role->syncPermissions(Permission::where('guard_name', $guardName)->whereIn('name', $hrdepartmentPermissions)->get());


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
        // Define the guard name
        $guardName = 'sanctum';

        // Create roles
        $roles = [
            'SuperAdmin',
            'HeadAdmin',
            'HrHead',
            'OperationHead',
            'Hr',
            'SubHrHead',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => $guardName]);
        }

        // Define permissions
        $permissions = [
            'policies' => [
                'Life_create',
                'Life_delete',
                'Life_update',
                'Life_read',
                'Life_health_create',
                'Life_health_delete',
                'Life_health_update',
                'Life_health_read',
                'Group_life_create',
                'Group_life_delete',
                'Group_life_update',
                'Group_life_read',
                'Motor_create',
                'Motor_delete',
                'Motor_update',
                'Motor_read',
                'Non_life_health_create',
                'Non_life_health_delete',
                'Non_life_health_update',
                'Non_life_health_read',
                'Non_motor_create',
                'Non_motor_delete',
                'Non_motor_update',
                'Non_motor_read',
                'Non_life_group_health_create',
                'Non_life_group_health_delete',
                'Non_life_group_health_update',
                'Non_life_group_health_read',
            ],
            'requisition' => [
                'Requisition_Create',
                'Requisition_Update',
                'Requisition_Delete',
                'Requisition_Read',
            ],
            'hr_department' => [
                'Employee_Create',
                'Employee_Update',
                'Employee_Delete',
                'Employee_Read',
                'POSP_Create',
                'POSP_Update',
                'POSP_Delete',
                'POSP_Read',
                'MISP_Create',
                'MISP_Update',
                'MISP_Delete',
                'MISP_Read',
                'Broker_Branch_Create',
                'Broker_Branch_Update',
                'Broker_Branch_Delete',
                'Broker_Branch_Read',
                'Group_Create',
                'Group_Update',
                'Group_Delete',
                'Group_Read',
                'Sub_Group_Create',
                'Sub_Group_Update',
                'Sub_Group_Delete',
                'Sub_Group_Read',
                'Designation_Create',
                'Designation_Update',
                'Designation_Delete',
                'Designation_Read',
                'Zone_Create',
                'Zone_Update',
                'Zone_Delete',
                'Zone_Read',
                'Regions_Create',
                'Regions_Update',
                'Regions_Delete',
                'Regions_Read',
                'City_Create',
                'City_Update',
                'City_Delete',
                'City_Read',
                'Bank_Master_Create',
                'Bank_Master_Update',
                'Bank_Master_Delete',
                'Bank_Master_Read',
                'Policy_Refers_By_Data_Create',
                'Policy_Refers_By_Data_Update',
                'Policy_Refers_By_Data_Delete',
                'Policy_Refers_By_Data_Read',
                'Leave_Master_Create',
                'Leave_Master_Update',
                'Leave_Master_Delete',
                'Leave_Master_Read',
                'Inventory_Create',
                'Inventory_Update',
                'Inventory_Delete',
                'Inventory_Read',
                'Target_Create',
                'Target_Update',
                'Target_Delete',
                'Target_Read',
                'Employee_Relieving_Letter',
                'Employee_Experience_Letter',
                'Employee_Appointment_Letter',
                'Employee_Offer_Letter',
                'Employee_Termination_Letter',
                'Employee_Full_and_Final_Settlement',
                'POSP_Certificate',
                'POSP_Relieving_Letter',
                // HR Reports
                "Employee_Application_Report",
                "Employee_Report",
                "Employee_Account_Details_Reports",
                'Employee_Login_Reports',
                "Employee_Relieving_Letter",
                'Employee_Terminate_Reports',
                'Employee_Attendance_Reports',
                'Employee_Salary_Report',
                'Employee_Appointment_Letter_Reports',
                'Requisition_Reports',
                'Sales_Employee_Target_Reports',
                'Employee_CTC_Reports',
                'Employee_Offer_Letter_Reports',
                "POSP_Report",
                'POSP_Application_Report',
                'POSP_Relieving_Letter',
                'POSP_Account_Details_Reports',
                'POSP_Certificate_Report',
            ],
        ];

        // Assign permissions to roles
        foreach ($permissions['policies'] as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => $guardName]);
            Role::findByName('OperationHead', $guardName)->givePermissionTo($permission);
        }

        foreach ($permissions['requisition'] as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => $guardName]);

            $rolesToAssign = ['HrHead', 'Hr', 'SubHrHead'];
            foreach ($rolesToAssign as $role) {
                Role::findByName($role, $guardName)->givePermissionTo($permission);
            }
        }

        foreach ($permissions['hr_department'] as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => $guardName]);

            $rolesToAssign = ['HrHead', 'Hr', 'SubHrHead'];
            foreach ($rolesToAssign as $role) {
                Role::findByName($role, $guardName)->givePermissionTo($permission);
            }
        }

        // Assign all permissions to SuperAdmin and HeadAdmin
        $allPermissions = Permission::where('guard_name', $guardName)->get();
        Role::findByName('SuperAdmin', $guardName)->syncPermissions($allPermissions);
        Role::findByName('HeadAdmin', $guardName)->syncPermissions($allPermissions);
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
//         // Clear cache to avoid conflicts
//         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

//         // Define permissions
//         $permissions = [
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
//             'Employee_Reports',
//             'POSP_Reports',
//             'Branch_Reports',
//             'Sales_Reports',
//         ];

//         // Define roles
//         $roles = [
//             'SuperAdmin',
//             'HeadAdmin',
//             'SubHeadAdmin',
//             'HrHead',
//             'SubHrHead',
//             'Hr',
//         ];

//         // Step 1: Create permissions with guard_name "sanctum"
//         foreach ($permissions as $permissionName) {
//             Permission::firstOrCreate(
//                 ['name' => $permissionName, 'guard_name' => 'sanctum']
//             );
//         }

//         // Step 2: Create roles with guard_name "sanctum"
//         foreach ($roles as $roleName) {
//             Role::firstOrCreate(
//                 ['name' => $roleName, 'guard_name' => 'sanctum']
//             );
//         }

//         // Step 3: Assign permissions to roles
//         // Assign all permissions to SuperAdmin
//         $superAdmin = Role::where('name', 'SuperAdmin')->where('guard_name', 'sanctum')->first();
//         $superAdmin->syncPermissions(Permission::where('guard_name', 'sanctum')->get());

//         // Assign all permissions to HeadAdmin
//         $headAdmin = Role::where('name', 'HeadAdmin')->where('guard_name', 'sanctum')->first();
//         $headAdmin->syncPermissions(Permission::where('guard_name', 'sanctum')->get());

//         // Assign specific permissions to HrHead
//         $hrHead = Role::where('name', 'HrHead')->where('guard_name', 'sanctum')->first();
//         $hrHead->givePermissionTo([
//             'Employee_Create',
//             'Employee_Update',
//             'Employee_Delete',
//             'Employee_View',
//             'POSP_Create',
//             'POSP_Update',
//             'POSP_Delete',
//             'POSP_View',
//             'Employee_Reports',
//         ]);

//         // Assign permissions to SubHrHead
//         $subHrHead = Role::where('name', 'SubHrHead')->where('guard_name', 'sanctum')->first();
//         $subHrHead->givePermissionTo([
//             'Employee_Create',
//             'Employee_Update',
//             'Employee_View',
//             'POSP_View',
//         ]);

//         // Assign limited permissions to Hr
//         $hr = Role::where('name', 'Hr')->where('guard_name', 'sanctum')->first();
//         $hr->givePermissionTo([
//             'Employee_View',
//         ]);

//         // Assign permissions to SubHeadAdmin
//         $subHeadAdmin = Role::where('name', 'SubHeadAdmin')->where('guard_name', 'sanctum')->first();
//         $subHeadAdmin->givePermissionTo([
//             'Broker_Branch_View',
//             'Sales_Reports',
//         ]);

//         // Log seeded data
//         $this->command->info('Roles and permissions with guard_name "sanctum" have been successfully seeded.');
//     }
// }
