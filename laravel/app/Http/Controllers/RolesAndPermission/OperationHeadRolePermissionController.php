<?php


namespace App\Http\Controllers\RolesAndPermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class OperationHeadRolePermissionController extends Controller
{
    // Assign role to a user
    public function assignRole(Request $request, $userId)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->assignRole($request->role);
        return response()->json(['message' => 'Role assigned successfully']);
    }

    // Assign permission to a user
    public function assignPermission(Request $request, $userId)
    {
        $request->validate([
            'permission' => 'required|string|exists:permissions,name',
        ]);

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->givePermissionTo($request->permission);
        return response()->json(['message' => 'Permission assigned successfully']);
    }

    // Revoke permission from a user
    public function revokePermission(Request $request, $userId)
    {
        $request->validate([
            'permission' => 'required|string|exists:permissions,name',
        ]);

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->revokePermissionTo($request->permission);
        return response()->json(['message' => 'Permission revoked successfully']);
    }
}
