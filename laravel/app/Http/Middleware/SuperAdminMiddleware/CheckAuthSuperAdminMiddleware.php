<?php

namespace App\Http\Middleware\SuperAdminMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthSuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the authenticated user has the "SuperAdmin" role
            if (Auth::user()->hasRole('SuperAdmin')) {
                return $next($request);  // Allow the request to proceed
            } else {
                return response()->json(['error' => 'You do not have authority to access this resource.'], 403);
            }
        }

        return response()->json(['error' => 'Unauthenticated.'], 401);  // User is not authenticated
    }
}
