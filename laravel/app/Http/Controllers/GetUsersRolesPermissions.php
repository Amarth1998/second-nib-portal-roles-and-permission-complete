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
    // Eager load roles and permissions for all users
    $users = User::with(['roles', 'permissions'])->get();

    // Map users to include roles and permissions in a structured format
    $response = $users->map(function ($user) {
        return [
            'user_id' => $user->id,
            'name' => $user->name,
            'roles' => $user->roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                ];
            }),
            'permissions' => $user->permissions->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                ];
            }),
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
