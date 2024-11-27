<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EmployeeController extends Controller

{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'mobile_no' => 'required|string|regex:/^\d{10}$/|unique:employees,mobile_no',
            'email' => 'required|email|unique:employees,email',
            'branch_id' => 'required|exists:branches,id',
            'reporting_manager' => 'nullable|exists:employees,id',
            'relationship_manager' => 'nullable|exists:employees,id',
            'level' => 'required|string|max:50',
            'grade' => 'required|string|max:50',
            'is_bqp' => 'required|boolean',
            'joining_date' => 'required|date',
            'active' => 'required|boolean',
            'role_id' => 'required|exists:roles,id', // Validate role ID
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $branchCode = $request->branch_id == 1 ? "NIBHO" : "NIBSO" . $request->branch_id; // Add branch ID dynamically

$lastEmployee = Employee::where('employee_code', 'like', "{$branchCode}%")
    ->orderBy('employee_code', 'desc')
    ->first();

$lastNumber = $lastEmployee
    ? (int)substr($lastEmployee->employee_code, -3)
    : 0;

$newEmployeeCode = sprintf("%s%03d", $branchCode, $lastNumber + 1);



        // Create the employee
        $employee = Employee::create([
            'title' => $request->title,
            'name' => $request->name,
            'department' => $request->department,
            'designation' => $request->designation,
            'employee_code' => $newEmployeeCode,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'branch_id' => $request->branch_id,
            'reporting_manager' => $request->reporting_manager,
            'relationship_manager' => $request->relationship_manager,
            'level' => $request->level,
            'grade' => $request->grade,
            'is_bqp' => $request->is_bqp,
            'joining_date' => $request->joining_date,
            'password' => Hash::make('default_password'),
            'active' => $request->active,
            'role_id' => $request->role_id,  // Make sure this is passed in the request
        ]);






        // Find role by ID and ensure it's using the 'sanctum' guard
        $role = Role::where('id', $request->role_id)
            ->where('guard_name', 'sanctum') // Ensure the guard matches
            ->firstOrFail();

        // Check if employee already has the role
        if ($employee->hasRole($role->name)) {
            return response()->json([
                'message' => 'The employee already has this role and cannot be assigned the same role again.',
            ], 409); // 409 Conflict
        }

        // Remove all existing roles from the employee
        $employee->syncRoles([]);

        // Assign the new role to the employee
        $employee->assignRole($role);

        // Assign the corresponding permissions based on the role
        $permissions = $role->permissions;
        foreach ($permissions as $permission) {
            $employee->givePermissionTo($permission);
        }

        return response()->json([
            'message' => 'Employee registered successfully with role and permissions!',
            'employee' => $employee,
            'role' => $role->name,
            'permissions' => $permissions->pluck('name'),
        ], 201);
    }



    public function login(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',  // Ensure password is at least 6 characters
        ]);

        // Return validation error if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Check if the user exists and the password is correct
        $user = Employee::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Generate a new API token for the user
            $token = $user->createToken('API Token')->plainTextToken;

            // Return success response with token, user data, roles, and permissions
            return response()->json([
                'token' => $token,
                'message' => 'Login successful.',
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ]);
        } else {
            // Return error if authentication fails
            return response()->json(['error' => 'Unauthorized, incorrect credentials'], 401);
        }
    }



    //     public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:2',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 422);
    //     }

    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         $employee = Auth::user();

    //         $roles = $employee->roles->pluck('id'); // Get roles by ID
    //         $permissions = $employee->getAllPermissions()->pluck('name'); // Get all permissions

    //         $token = $employee->createToken('API Token')->plainTextToken;

    //         return response()->json([
    //             'token' => $token,
    //             'message' => 'Login successful.',
    //             'employee' => $employee,
    //             'roles' => $roles, // Role IDs
    //             'permissions' => $permissions,
    //         ]);
    //     }

    //     return response()->json(['error' => 'Unauthorized'], 401);
    // }

}
