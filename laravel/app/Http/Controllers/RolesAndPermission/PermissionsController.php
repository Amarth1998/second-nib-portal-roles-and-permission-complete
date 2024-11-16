<?php

namespace App\Http\Controllers\RolesAndPermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller

{

    // Method to assign permission (if needed)
    public function assignPermission(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission' => 'required|exists:permissions,name',
        ]);

        $user = User::findOrFail($validated['user_id']);
        $permission = Permission::where('name', $validated['permission'])->first();

        if ($permission) {
            $user->givePermissionTo($permission); // Assign the permission
            return response()->json(['message' => 'Permission assigned successfully.']);
        }

        return response()->json(['message' => 'Permission not found.'], 404);
    }

    
    
  

  
}
