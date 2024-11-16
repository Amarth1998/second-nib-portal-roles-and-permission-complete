<?php

namespace App\Http\Controllers\RolesAndPermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class RolePermissionController extends Controller
{
    // Assign role to a user
    public function assignRole(Request $request, $userId)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|string|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::findOrFail($userId);
 
        // HRHead and OperationHead cannot assign SuperAdmin or Admin roles
        if (in_array($request->role, ['SuperAdmin', 'Admin'])) {
            return response()->json(['error' => 'You are not allowed to assign SuperAdmin or Admin role.'], 403);
        }

        $role = Role::findByName($request->role);
        $user->assignRole($role);

        return response()->json(['message' => 'Role assigned successfully.']);
    }

    // Assign permission to a user
    public function assignPermission(Request $request, $userId)
    {
        $validator = Validator::make($request->all(), [
            'permission' => 'required|string|exists:permissions,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::findOrFail($userId);
        $permission = Permission::findByName($request->permission);
        $user->givePermissionTo($permission);

        return response()->json(['message' => 'Permission assigned successfully.']);
    }

    // Revoke permission from a user
    public function revokePermission(Request $request, $userId)
    {
        $validator = Validator::make($request->all(), [
            'permission' => 'required|string|exists:permissions,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::findOrFail($userId);
        $permission = Permission::findByName($request->permission);
        $user->revokePermissionTo($permission);

        return response()->json(['message' => 'Permission revoked successfully.']);
    }
}
