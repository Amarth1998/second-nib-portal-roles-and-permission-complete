<?php

namespace App\Http\Middleware\SubHeadAdminMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;

class SubHeadAdminRevokeRoleMiddleware
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

        // Check if the authenticated user has the SubAdmin role
        if ($currentUser->hasRole('SubHeadAdmin')) {
            // Get the role being revoked
            $roleId = $request->role_id;
            $role = Role::find($roleId);

            // Restrict revoking "SuperAdmin", "HeadAdmin", or "SubAdmin" roles
            if ($role && in_array($role->name, ['SuperAdmin', 'HeadAdmin', 'SubHeadAdmin','HrHead'])) {
                return response()->json(['message' => 'You are not authorized to revoke this role.'], 403);
            }

            // Ensure the user whose role is being revoked belongs to the same branch
            $userId = $request->user_id;
            $userToRevoke = User::find($userId);

            if (!$userToRevoke || $userToRevoke->branch_id !== $currentUser->branch_id) {
                return response()->json(['message' => 'You are not authorized to revoke roles from users outside your branch.'], 403);
            }
        }

        // Proceed to the next middleware or the controller
        return $next($request);
    }
}
