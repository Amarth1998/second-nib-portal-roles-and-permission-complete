<?php

namespace App\Http\Middleware\SuperAdminMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class SuperAdminRevokeRoleMiddleware
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

        // Restrict revoking "SuperAdmin" or "HeadAdmin" roles
        $roleId = $request->input('role_id');
        $role = Role::find($roleId);

        if ($role && in_array($role->name, ['SuperAdmin'])) {
            return response()->json(['message' => 'You are not authorized to revoke this role.'], 403);
        }

        // Proceed to the next middleware or the controller
        return $next($request);
    }
}
