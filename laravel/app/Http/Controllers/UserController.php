<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UserController extends Controller


{

    // Method to assign a role to a user (by Super Admin)
    // public function assignRole(Request $request)
    // {
    //     // Ensure the current user is logged in and is a Super Admin
    //     $user = Auth::user(); // Get the currently authenticated user

    //     if (!$user->hasRole('superadmin')) {
    //         return response()->json(['error' => 'You do not have permission to assign roles.'], 403); 
    //     }

    //     // Validate the incoming data
    //     $validated = $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'role_id' => 'required|exists:roles,id', // Ensure the role ID exists in the roles table
    //     ]);

    //     // Find the user by ID
    //     $userToAssignRole = User::findOrFail($validated['user_id']);

    //     // Find the role by ID
    //     $role = Role::find($validated['role_id']);

    //     if ($role) {
    //         // Assign the role to the user
    //         $userToAssignRole->assignRole($role); 
    //         return response()->json(['message' => 'Role assigned successfully.']);
    //     }

    //     return response()->json(['message' => 'Role not found.'], 404);
    // }


    public function assignRole(Request $request)
    {
        // Step 1: Ensure the current user is authenticated and has the 'superadmin' role
        $user = Auth::user(); // Get the currently authenticated user
        echo $user->name;
        echo $user->email;
        echo $user->password;
        echo $user->getRoleNames();

        // Step 2: Check if the user has the 'superadmin' role
        if (!$user->hasRole('superadmin')) {
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



    // Register method
    public function register(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
        ]);

        // Return validation error if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password before storing
        ]);



        // Return success response with token and user data
        return response()->json([
            'message' => 'Registration successful.',
            'user' => $user,

        ], 201);
    }

    // Login method
    // public function login(Request $request)
    // {
    //     // Validate the incoming request
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:3',
    //     ]);

    //     // Return validation error if validation fails
    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 422);
    //     }

    //     // Check if the user exists and the password is correct
    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         // Get the authenticated user
    //         $user = Auth::user();

    //              // Generate a new API token for the user
    //     $token = $user->createToken('API Token')->plainTextToken;
    //     $roles = $user->getRoleNames(); // Returns a collection of roles

    //     // Get the permissions associated with the user
    //     $permissions = $user->getAllPermissions();

    //         // Return success response with token and user data
    //         return response()->json([
    //             'message' => 'Login successful.',
    //             'user' => $user,
    //             'token' => $token,
    //         ]);
    //     } else {
    //         // Return error if authentication fails
    //         return response()->json(['error' => 'Unauthorized, incorrect credentials'], 401);
    //     }
    // }

    public function login(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:3',
        ]);

        // Return validation error if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Check if the user exists and the password is correct
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Get the authenticated user
            $user = Auth::user();

            // Get the roles associated with the user
            $roles = $user->getRoleNames(); // Returns a collection of roles

            // Get the permissions associated with the user
            $permissions = $user->getAllPermissions(); // Returns a collection of permissions

            // Generate a new API token for the user
            $token = $user->createToken('API Token')->plainTextToken;

            // Return success response with token, user data, roles, and permissions
            return response()->json([
                'message' => 'Login successful.',
                'user' => $user,
                'roles' => $roles,  // Include roles in the response
                'permissions' => $permissions->pluck('name'),  // Include permissions in the response
                'token' => $token,
            ]);
        } else {
            // Return error if authentication fails
            return response()->json(['error' => 'Unauthorized, incorrect credentials'], 401);
        }
    }
}
