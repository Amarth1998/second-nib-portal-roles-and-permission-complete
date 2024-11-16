<?php

namespace App\Http\Controllers\RolesAndPermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermission extends Controller

{

    public function assignRole(Request $request)
    {
        // Step 1: Ensure the current user is authenticated and has the 'superadmin' role
        $user = Auth::user(); // Get the currently authenticated user
        echo $user->name;
        echo $user->email;
        echo $user->password;
        echo $user->getRoleNames();

        // Step 2: Check if the user has the 'superadmin' role
        if (!$user->hasRole('SuperAdmin')) {
            // If the user is not a Super Admin, return a permission error
            return response()->json(['error' => 'You do not have permission to assign roles.'], 403);
        }

        // Step 3: Validate the incoming request to ensure proper data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',    // Ensure the user exists in the database
            'role_id' => 'required|exists:roles,id',    // Ensure the role exists in the roles table
        ]);

        // Step 4: Find the user by ID (user to be assigned the role)
        $userToAssignRole = User::findOrFail($validated['user_id']);

        // Step 5: Find the role by ID
        $role = Role::findOrFail($validated['role_id']);  // Make sure the role exists

        // Step 6: Assign the role to the user
        $userToAssignRole->assignRole($role);

        // Step 7: Return a success message
        return response()->json(['message' => 'Role assigned successfully.']);
    }

    // Method to assign permission (if needed)
    public function assignPermission(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission' => 'required|exists:permissions,name',
        ]);

        $user = User::findOrFail($validated['user_id']);
        $permission = Permission::where('name', $validated['permission'])->first();

        if ($permission) {
            $user->givePermissionTo($permission); // Assign the permission
            return response()->json(['message' => 'Permission assigned successfully.']);
        }

        return response()->json(['message' => 'Permission not found.'], 404);
    }

    // Method to check if the current user has access to a specific route
    public function checkPermission($permission)
    {
        if (Auth::user()->can($permission)) {
            return response()->json(['message' => 'Access granted'], 200);
        }
        return response()->json(['error' => 'Access denied'], 403);
    }


  
}
