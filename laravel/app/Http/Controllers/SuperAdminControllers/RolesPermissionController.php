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
    // public function assignPermission(Request $request)
    // {
    //     $validated = $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'permission_id' => 'required|exists:permissions,id',
    //     ]);

    //     // Find the user and permission
    //     $user = User::findOrFail($validated['user_id']);
    //     $permission = Permission::findOrFail($validated['permission_id']);

    //     // Check if the user has a role before assigning permission
    //     if ($user->roles->isEmpty()) {
    //         return response()->json(['message' => 'Permission cannot be assigned. User does not have any role.'], 403);
    //     }

    //     // Assign the permission to the user
    //     $user->givePermissionTo($permission);

    //     return response()->json(['message' => 'Permission assigned successfully.']);
    // }

//     public function assignPermission(Request $request)
// {
//     $validated = $request->validate([
//         'user_id' => 'required|exists:users,id',
//         'permission_id' => 'required|exists:permissions,id',
//     ]);

//     // Find the user and permission
//     $user = User::findOrFail($validated['user_id']);
//     $permission = Permission::findOrFail($validated['permission_id']);

//     // Check if the user has a role before assigning permission
//     if ($user->roles->isEmpty()) {
//         return response()->json(['message' => 'Permission cannot be assigned. User does not have any role.'], 403);
//     }

//     // Check if the user already has the permission
//     if ($user->hasPermissionTo($permission)) {
//         return response()->json(['message' => 'User already has this permission.'], 200);
//     }

//     // Assign the permission to the user
//     $user->givePermissionTo($permission);

//     return response()->json(['message' => 'Permission assigned successfully.']);
// }


// public function assignPermission(Request $request)
// {
//     $validated = $request->validate([
//         'user_id' => 'required|exists:users,id',
//         'permission_id' => 'required|exists:permissions,id',
//     ]);

//     // Find the user and permission
//     $user = User::findOrFail($validated['user_id']);
//     $permission = Permission::findOrFail($validated['permission_id']);

//     // Check if the user has a role before assigning permission
//     if ($user->roles->isEmpty()) {
//         return response()->json(['message' => 'Permission cannot be assigned. User does not have any role.'], 403);
//     }

//     // Check if the user already has the permission directly
//     $directPermissions = $user->getDirectPermissions();
//     if ($directPermissions->contains('id', $permission->id)) {
//         return response()->json(['message' => 'User already has this permission directly assigned.'], 200);
//     }

//     // Assign the permission to the user
//     $user->givePermissionTo($permission);

//     return response()->json(['message' => 'Permission assigned successfully.']);
// }


// public function assignPermission(Request $request)
// {
//     // Validate the request data
//     $validated = $request->validate([
//         'user_id' => 'required|exists:users,id',
//         'permission_id' => 'required|exists:permissions,id',
//     ]);

//     // Find the user and permission
//     $user = User::findOrFail($validated['user_id']);
//     $permission = Permission::findOrFail($validated['permission_id']);

//     // Check if the user has a role before assigning permission
//     if ($user->roles->isEmpty()) {
//         return response()->json(['message' => 'Permission cannot be assigned. User does not have any role.'], 403);
//     }

//     // Check if the user already has the permission directly assigned
//     $directPermissions = $user->getDirectPermissions();
//     if ($directPermissions->contains('id', $permission->id)) {
//         return response()->json(['message' => 'User already has this permission directly assigned.'], 200);
//     }

//     // Check if the user inherits the permission through any role
//     if ($user->hasPermissionTo($permission->name)) {
//         return response()->json(['message' => 'User already has this permission through their role.'], 200);
//     }

//     // Assign the permission to the user
//     $user->givePermissionTo($permission);

//     return response()->json(['message' => 'Permission assigned successfully.']);
// }


// public function assignPermission(Request $request)
// {
//     // Validate the request data
//     $validated = $request->validate([
//         'user_id' => 'required|exists:users,id',
//         'permission_id' => 'required|exists:permissions,id',
//     ]);

//     // Find the user and permission
//     $user = User::findOrFail($validated['user_id']);
//     $permission = Permission::findOrFail($validated['permission_id']);

//     // Check if the user has a role
//     if ($user->roles->isEmpty()) {
//         return response()->json(['message' => 'Permission cannot be assigned. User does not have any role.'], 403);
//     }

//     // Check if the user already has the permission directly assigned or inherited
//     if ($user->hasPermissionTo($permission->name)) {
//         return response()->json(['message' => 'User already has this permission.'], 200);
//     }

//     // Assign the permission to the user
//     $user->givePermissionTo($permission);

//     return response()->json(['message' => 'Permission assigned successfully.'], 200);
// }

// public function assignPermission(Request $request)
// {
//     // Validate the request data
//     $validated = $request->validate([
//         'user_id' => 'required|exists:users,id',
//         'permission_id' => 'required|exists:permissions,id',
//     ]);

//     // Find the user and permission
//     $user = User::findOrFail($validated['user_id']);
//     $permission = Permission::findOrFail($validated['permission_id']);

//     // Check if the user has any role
//     if ($user->roles->isEmpty()) {
//         return response()->json(['message' => 'Permission cannot be assigned. User does not have any role.'], 403);
//     }

//     // Check if the user already has the permission directly or indirectly (through roles)
//     if ($user->hasPermissionTo($permission)) {
//         return response()->json(['message' => 'User already has this permission.'], 200);
//     }

//     // Assign the permission to the user
//     $user->givePermissionTo($permission);

//     return response()->json(['message' => 'Permission assigned successfully.'], 200);
// }


// public function assignPermission(Request $request)
// {
//     // Validate the request data
//     $validated = $request->validate([
//         'user_id' => 'required|exists:users,id',
//         'permission_id' => 'required|exists:permissions,id',
//     ]);

//     // Find the user and permission
//     $user = User::findOrFail($validated['user_id']);
//     $permission = Permission::findOrFail($validated['permission_id']);

//     // Check if the user has any role
//     if ($user->roles->isEmpty()) {
//         return response()->json(['message' => 'Permission cannot be assigned. User does not have any role.'], 403);
//     }

//     // Check if the permission is already directly assigned to the user
//     $directPermissions = $user->getDirectPermissions();
//     if ($directPermissions->contains('id', $permission->id)) {
//         return response()->json(['message' => 'User already has this permission directly assigned.'], 200);
//     }

//     // Check if the user has the permission via roles (inherited permission)
//     if ($user->hasPermissionTo($permission)) {
//         return response()->json(['message' => 'User already has this permission through their roles.'], 200);
//     }

//     // If permission is not found, assign it to the user
//     $user->givePermissionTo($permission);

//     return response()->json(['message' => 'Permission assigned successfully.'], 200);
// }

public function assignPermission(Request $request)
{
    // Validate the request data
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'permission_id' => 'required|exists:permissions,id',
    ]);

    // Find the user and permission by their IDs
    $user = User::findOrFail($validated['user_id']);
    $permission = Permission::findOrFail($validated['permission_id']);

    // Check if the user has any role
    if ($user->roles->isEmpty()) {
        return response()->json(['message' => 'Permission cannot be assigned. User does not have any role.'], 403);
    }

    if ($user->permissions()->where('id', $validated['permission_id'])->exists())
    {
        return response()->json(['message' => 'The user already have permission.'], 409);
    }

    // Check if the user already has this permission
    // if ($user->hasPermissionTo($permission->name)) {
    //     return response()->json(['message' => 'The user already has this permission.'], 409);
    // }

    // Assign the permission to the user
    $user->givePermissionTo($permission);

    return response()->json(['message' => 'Permission assigned successfully.'], 200);
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

