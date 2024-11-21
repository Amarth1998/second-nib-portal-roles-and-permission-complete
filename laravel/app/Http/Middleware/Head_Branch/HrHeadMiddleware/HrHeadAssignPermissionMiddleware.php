<?php

namespace App\Http\Middleware\Head_Branch\HrHeadMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class HrHeadAssignPermissionMiddleware
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
    if ($targetUser->hasRole(['SuperAdmin', 'HeadAdmin', 'HrHead'])) {
        return response()->json(['message' => 'You are not authorized to assign permissions to users with SuperAdmin, Admin, or HrHead roles.'], 403);
    }

    // Ensure the HrHead can only assign permissions they have
    if (!$currentUser->hasPermissionTo($permission)) {
        return response()->json(['message' => 'You do not have the required permission to assign this permission.'], 403);
    }

  

    return $next($request);
}

}
