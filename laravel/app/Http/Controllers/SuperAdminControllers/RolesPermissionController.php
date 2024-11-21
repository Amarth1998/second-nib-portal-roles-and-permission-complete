<?php

namespace App\Http\Controllers\SuperAdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionController extends Controller
{
    // Assign Role and Permissions to a User
    public function assignRole(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Find the user and role
        $userToAssignRole = User::findOrFail($validated['user_id']);
        $role = Role::findOrFail($validated['role_id']);

        // Remove all existing roles from the user
        $userToAssignRole->syncRoles([]);

        // Assign the new role to the user
        $userToAssignRole->assignRole($role);

        // Assign the corresponding permissions to the user based on the role
        $permissions = $role->permissions;
        foreach ($permissions as $permission) {
            $userToAssignRole->givePermissionTo($permission);
        }

        return response()->json(['message' => 'Role and permissions assigned successfully.']);
    }

    // Assign specific permission to a user
    public function assignPermission(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        // Find the user and permission
        $user = User::findOrFail($validated['user_id']);
        $permission = Permission::findOrFail($validated['permission_id']);

        // Check if the user has a role before assigning permission
        if ($user->roles->isEmpty()) {
            return response()->json(['message' => 'Permission cannot be assigned. User does not have any role.'], 403);
        }

        // Assign the permission to the user
        $user->givePermissionTo($permission);

        return response()->json(['message' => 'Permission assigned successfully.']);
    }

    // Revoke Role and Associated Permissions from a User
    public function revokeRole(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Find the user and role
        $userToRevokeRole = User::findOrFail($validated['user_id']);
        $role = Role::findOrFail($validated['role_id']);

        // Check if the user has the role and revoke the permissions associated with the role
        if ($userToRevokeRole->hasRole($role->name)) {
            $permissions = $role->permissions;
            foreach ($permissions as $permission) {
                if ($userToRevokeRole->hasPermissionTo($permission->name)) {
                    $userToRevokeRole->revokePermissionTo($permission);
                }
            }

            // Remove the role from the user
            $userToRevokeRole->removeRole($role);

            return response()->json(['message' => 'Role and associated permissions revoked successfully.']);
        }

        return response()->json(['error' => 'User does not have the specified role.'], 404);
    }

   

    public function revokePermission(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);
    
        // Find the user
        $user = User::findOrFail($validated['user_id']);
    
        // Check if the user has the specified permission
        if ($user->permissions()->where('id', $validated['permission_id'])->exists()) {
            // Remove the permission
            $user->permissions()->detach($validated['permission_id']);
    
            // Return a response indicating the permission was removed
            return response()->json([
                'user_id' => $user->id,
                'permission_id' => $validated['permission_id'],
                'message' => 'Permission has been removed.',
            ]);
        }
    
        // If the user does not have the permission
        return response()->json([
            'message' => 'User does not have this permission.',
        ], 404);
    }
    


}

