<?php

namespace App\Http\Middleware\HrMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class CheckHrHeadRevokePermissionMiddleware
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

        // Restrict revoking permissions from users with "SuperAdmin" or "Admin" or "HR Head" roles
        if ($targetUser->hasRole(['SuperAdmin', 'Admin','HrHead'])) {
            return response()->json(['message' => 'You are not authorized to revoke permissions from users with SuperAdmin or Admin roles.'], 403);
        }

        // Ensure the Hr Head can only revoke permissions they have
        if (!$currentUser->hasPermissionTo($permission)) {
            return response()->json(['message' => 'You do not have the required permission to revoke this permission.'], 403);
        }

        // Proceed to the next middleware or the controller
        return $next($request);
    }
}
