<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class GetUsersRolesPermissions extends Controller
{
    /**
     * Get all users with their roles and permissions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUsersWithRolesAndPermissions()
    {
        // Get all users with their roles and permissions
        $users = User::all();

        // Map through each user to fetch roles and permissions
        $response = $users->map(function ($user) {
            return [
                'user_id' => $user->id,
                'name' => $user->name,
                'roles' => $user->roles->map(function ($role) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name,
                    ];
                }), // Get role IDs and names
                'permissions' => $user->getAllPermissions()->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                    ];
                }), // Get permission IDs and names
            ];
        });

        return response()->json($response);
    }




    public function getUserRolesAndPermissions($user_id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($user_id);

            // Fetch roles and permissions
            $roles = $user->getRoleNames(); // Get all role names
            $permissions = $user->getAllPermissions(); // Get all permissions

            // Return roles and permissions in the response
            return response()->json([
                'user' => $user->name,
                'roles' => $roles,
                'permissions' => $permissions->pluck('name'), // Extract permission names
            ], 200);
        } catch (\Exception $e) {
            // Handle errors
            return response()->json([
                'error' => 'User not found or an error occurred.',
                'message' => $e->getMessage(),
            ], 404);
        }
    }


    //     public function getUserRolesAndPermissions($user_id)
    // {
    //     try {
    //         $user = User::findOrFail($user_id);

    //         // Fetch roles and permissions
    //         $roles = $user->getRoleNames(); // Get all role names
    //         $permissions = $user->getAllPermissions(); // Get all permissions

    //           // Clear cached permissions
    //           app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    //           // Re-fetch the updated permissions for the user
    //           $permissions->load('permissions'); // Load fresh permissions

    //         return response()->json([
    //             'user' => $user->name,
    //             'roles' => $roles,
    //             'permissions' => $permissions->pluck('name'), // Extract permission names
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'User not found or an error occurred.',
    //             'message' => $e->getMessage(),
    //         ], 404);
    //     }
    // }





    // public function getUserPermissions(Request $request)
    // {
    //     $validated = $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //     ]);

    //     // Find the user
    //     $user = User::findOrFail($validated['user_id']);

    //     // Get the user's permissions
    //     $permissions = $user->permissions()->get(['id', 'name']);


    //     // Return the permissions as a JSON response
    //     return response()->json([
    //         'user_id' => $user->id,
    //         'permissions' => $permissions,
    //     ]);
    // }

//     public function getUserPermissions(Request $request)
// {
//     $validated = $request->validate([
//         'user_id' => 'required|exists:users,id',
//     ]);

//     // Find the user
//     $user = User::findOrFail($validated['user_id']);

//     // Get the user's permissions with only 'id' and 'name'
//     $permissions = $user->permissions()->get(['id', 'name'])->makeHidden('pivot');

//     // Return the permissions as a JSON response
//     return response()->json([
//         'user_id' => $user->id,
//         'permissions' => $permissions,
//     ]);
// }

public function getUserPermissions(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    // Find the user
    $user = User::findOrFail($validated['user_id']);

    // Get the user's permissions sorted by 'id' in ascending order
    $permissions = $user->permissions()->orderBy('id', 'asc')->get(['id', 'name'])->makeHidden('pivot');

    // Return the permissions as a JSON response
    return response()->json([
        'user_id' => $user->id,
        'permissions' => $permissions,
    ]);
}


}
