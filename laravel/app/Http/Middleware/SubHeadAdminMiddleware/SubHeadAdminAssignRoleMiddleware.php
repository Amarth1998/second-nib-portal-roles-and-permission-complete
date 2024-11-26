<?php

namespace App\Http\Middleware\SubHeadAdminMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;

class SubHeadAdminAssignRoleMiddleware
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
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        // Check if the authenticated user has the SubAdmin role
        if ($user->hasRole('SubHeadAdmin')) {
            // Retrieve the role being assigned
            $roleId = $request->role_id;

            // Get the role name using the ID
            $role = Role::find($roleId);

            // Restrict assigning "SuperAdmin", "HeadAdmin", or "SubAdmin" roles
            if ($role && in_array($role->name, ['SuperAdmin', 'SubHeadAdmin','HeadAdmin','HrHead'])) {
                return response()->json(['message' => 'You are not authorized to assign this role.'], 403);
            }

            // Ensure the user being assigned the role belongs to the same branch as the SubAdmin
            $userId = $request->user_id;
            $userToAssign = User::find($userId);

            if (!$userToAssign || $userToAssign->branch_id !== $user->branch_id) {
                return response()->json(['message' => 'You are not authorized to assign roles.'], 403);
            }
        }

        return $next($request);
    }
}
