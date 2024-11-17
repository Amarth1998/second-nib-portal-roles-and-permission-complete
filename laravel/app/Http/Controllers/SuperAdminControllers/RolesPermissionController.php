<?php

namespace App\Http\Controllers\SuperAdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
// use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionController extends Controller
{

    public function getUserRolesAndPermissions($user_id)
    {
        // Find the user by ID
        $user = User::findOrFail($user_id);

        // Get the roles and permissions associated with the user
        $roles = $user->getRoleNames(); // Get all role names
        $permissions = $user->getAllPermissions(); // Get all permissions

        // Return the roles and permissions in the response
        return response()->json([
            'user' => $user->name,
            'roles' => $roles,
            'permissions' => $permissions->pluck('name') // Extract permission names
        ]);
    }
public function assignRole(Request $request)
{

    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'role_id' => 'required|exists:roles,id',
    ]);

    $userToAssignRole = User::findOrFail($validated['user_id']);
    $role = Role::findOrFail($validated['role_id']);

    $userToAssignRole->assignRole($role);

    return response()->json(['message' => 'Role assigned successfully.']);
}

public function assignPermission(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'permission' => 'required|exists:permissions,name',
    ]);

    $user = User::findOrFail($validated['user_id']);
    $permission = Permission::where('name', $validated['permission'])->first();

    if ($permission) {
        $user->givePermissionTo($permission);
        return response()->json(['message' => 'Permission assigned successfully.']);
    }

    return response()->json(['message' => 'Permission not found.'], 404);
}

public function revokeRole(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'role_id' => 'required|exists:roles,id',
    ]);

    $userToRevokeRole = User::findOrFail($validated['user_id']);
    $role = Role::findOrFail($validated['role_id']);

    if ($userToRevokeRole->hasRole($role)) {
        $userToRevokeRole->removeRole($role);
        return response()->json(['message' => 'Role revoked successfully.']);
    }

    return response()->json(['error' => 'User does not have the specified role.'], 404);
}

public function revokePermission(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'permission' => 'required|exists:permissions,name',
    ]);

    $userToRevokePermission = User::findOrFail($validated['user_id']);
    $permission = Permission::where('name', $validated['permission'])->first();

    if ($permission && $userToRevokePermission->hasPermissionTo($permission)) {
        $userToRevokePermission->revokePermissionTo($permission);
        return response()->json(['message' => 'Permission revoked successfully.']);
    }

    return response()->json(['error' => 'User does not have the specified permission.'], 404);
}


}
