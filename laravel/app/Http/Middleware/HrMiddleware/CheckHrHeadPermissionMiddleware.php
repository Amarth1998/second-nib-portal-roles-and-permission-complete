<?php

namespace App\Http\Middleware\HrMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class CheckHrHeadPermissionMiddleware
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
    $currentUser = Auth::user();

    if (!$currentUser) {
        return response()->json(['message' => 'Unauthorized.'], 401);
    }

    $targetUserId = $request->input('user_id');
    $permissionName = $request->input('permission');

    $targetUser = User::find($targetUserId);
    $permission = Permission::where('name', $permissionName)->first();

    if (!$targetUser) {
        return response()->json(['message' => 'Target user not found.'], 404);
    }

    if (!$permission) {
        return response()->json(['message' => 'Permission not found.'], 404);
    }

    // Restrict assigning permissions to users with specific roles
    if ($targetUser->hasRole(['SuperAdmin', 'Admin', 'HrHead'])) {
        return response()->json(['message' => 'You are not authorized to assign permissions to users with SuperAdmin, Admin, or HrHead roles.'], 403);
    }

    // Ensure the HrHead can only assign permissions they have
    if (!$currentUser->hasPermissionTo($permission)) {
        return response()->json(['message' => 'You do not have the required permission to assign this permission.'], 403);
    }

    // Ensure the target user has at least one role
    if ($currentUser->hasRole('HrHead') && $targetUser->roles->isEmpty()) {
        return response()->json([
            'message' => 'HrHead can only assign permissions to users who already have a role.'
        ], 403);
    }

    return $next($request);
}

}
