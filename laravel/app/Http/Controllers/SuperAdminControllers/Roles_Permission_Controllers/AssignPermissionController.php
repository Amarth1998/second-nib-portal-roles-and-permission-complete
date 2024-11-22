<?php

namespace App\Http\Controllers\SuperAdminControllers\Roles_Permission_Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPermissionController extends Controller
{
   

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
        return response()->json(['message' => 'The user already have.'], 409);
    }

    // Assign the permission to the user
    $user->givePermissionTo($permission);

    return response()->json(['message' => 'Permission assigned successfully.'], 200);
}

}

