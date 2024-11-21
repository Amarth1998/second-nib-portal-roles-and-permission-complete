<?php

namespace App\Http\Middleware\Head_Branch\HrHeadMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

class HrHeadAssignRoleMiddleware
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
        // $user = Auth()->user();
 // Get the authenticated user
 $user = Auth::user();
        // Check if the authenticated user has an hr head role
        if ($user->hasRole('HrHead')) {
            // Retrieve the role being assigned
            $roleId = $request->role_id;

            // Get the role name using the ID
            $role = Role::find($roleId);

            // Restrict assigning "Super Admin" or "head Admin" and " Hr head" roles
            if ($role && in_array($role->name, ['SuperAdmin', 'HeadAdmin','HrHead'])) {
                return response()->json(['message' => 'You are not authorized to assign this role.'], 403);
            }
        }

        return $next($request);
    }
}
