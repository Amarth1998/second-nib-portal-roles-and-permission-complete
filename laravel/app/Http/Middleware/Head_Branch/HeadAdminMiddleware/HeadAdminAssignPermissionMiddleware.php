<?php

namespace App\Http\Middleware\Head_Branch\HeadAdminMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class HeadAdminAssignPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the authenticated user
        $currentUser = Auth::user();

        // Ensure the user is authenticated
        if (!$currentUser) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        // Retrieve the target user and permission from the request
        $targetUserId = $request->input('user_id');
        $permissionName = $request->input('permission');

        $targetUser = User::find($targetUserId);
        $permission = Permission::where('name', $permissionName)->first();

        // Ensure the target user and permission exist
        if (!$targetUser) {
            return response()->json(['message' => 'Target user not found.'], 404);
        }

        if (!$permission) {
            return response()->json(['message' => 'Permission not found.'], 404);
        }

        // Restrict assigning permissions to users with "SuperAdmin" or "Head Admin" roles
        if ($targetUser->hasRole(['SuperAdmin', 'HeadAdmin'])) {
            return response()->json(['message' => 'You are not authorized to assign permissions to users with SuperAdmin or Admin roles.'], 403);
        }

        // Ensure the admin can only assign permissions they have
        if (!$currentUser->hasPermissionTo($permission)) {
            return response()->json(['message' => 'You do not have the required permission to assign this permission.'], 403);
        }

       
          
        // Proceed to the next middleware or the controller
        return $next($request);
    }
}
