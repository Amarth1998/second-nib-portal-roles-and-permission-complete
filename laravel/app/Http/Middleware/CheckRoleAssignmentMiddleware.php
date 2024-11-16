<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleAssignmentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Get the role from the request
        $role = $request->input('role');

        // Check if the role is either 'SuperAdmin' or 'Admin'
        if (in_array($role, ['SuperAdmin', 'Admin'])) {
            return response()->json(['error' => 'You are not allowed to assign SuperAdmin or Admin role.'], 403);
        }

        return $next($request);
    }
}
