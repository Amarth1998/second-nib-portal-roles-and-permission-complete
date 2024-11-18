<?php

namespace App\Http\Controllers\SuperAdminControllers;
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
    
}
