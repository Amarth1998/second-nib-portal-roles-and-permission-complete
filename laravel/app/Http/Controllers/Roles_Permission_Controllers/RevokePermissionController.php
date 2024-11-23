<?php

namespace App\Http\Controllers\Roles_Permission_Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RevokePermissionController extends Controller
{
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