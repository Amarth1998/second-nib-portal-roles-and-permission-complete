<?php

namespace App\Http\Controllers\Roles_Permission_Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignRoleController extends Controller
{

    public function assignRole(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'role_id' => 'required|exists:roles,id',
    ]);

    // Find the user and role
    $userToAssignRole = User::findOrFail($validated['user_id']);
    $role = Role::findOrFail($validated['role_id']);

    // Check if the user already has the role
    if ($userToAssignRole->hasRole($role->name)) {
        return response()->json([
            'message' => 'The user already has this role and cannot be assigned the same role again.',
        ], 409); // 409 Conflict
    }

    // Remove all existing roles from the user
    $userToAssignRole->syncRoles([]);

    // Assign the new role to the user
    $userToAssignRole->assignRole($role);

    // Assign the corresponding permissions to the user based on the role
    $permissions = $role->permissions;
    foreach ($permissions as $permission) {
        $userToAssignRole->givePermissionTo($permission);
    }

    // Return success response
    return response()->json([
        'message' => 'Role and associated permissions assigned successfully.',
    ], 200);
}

}