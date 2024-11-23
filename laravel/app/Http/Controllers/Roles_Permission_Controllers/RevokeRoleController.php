<?php

namespace App\Http\Controllers\Roles_Permission_Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RevokeRoleController extends Controller
{

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

}