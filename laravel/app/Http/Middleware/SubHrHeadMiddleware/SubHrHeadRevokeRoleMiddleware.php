<?php

namespace App\Http\Middleware\SubHrHeadMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;

class SubHrHeadRevokeRoleMiddleware
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

        // Ensure the current user has the 'HrHead' role
        if ($currentUser->hasRole('SubHrHead')) {
            // Retrieve the target user and role from the request
            $targetUserId = $request->input('user_id');
            $roleId = $request->input('role_id');

            $targetUser = User::find($targetUserId);
            $role = Role::find($roleId);

            // Ensure the target user and role exist
            if (!$targetUser) {
                return response()->json(['message' => 'Target user not found.'], 404);
            }

            if (!$role) {
                return response()->json(['message' => 'Role not found.'], 404);
            }

            // Restrict revoking "SuperAdmin", "SubHeadAdmin", or "SubHrHead" roles
            if (in_array($role->name, ['SuperAdmin', 'SubHeadAdmin', 'SubHrHead'])) {
                return response()->json(['message' => 'You are not authorized to revoke this role.'], 403);
            }

            // Ensure the target user belongs to the same branch as the current user
            if ($currentUser->branch_id !== $targetUser->branch_id) {
                return response()->json(['message' => 'You are not authorized to revoke roles from users outside your branch.'], 403);
            }
        }

        // Proceed to the next middleware or the controller
        return $next($request);
    }
}
