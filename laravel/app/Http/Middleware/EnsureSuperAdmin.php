<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSuperAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Check if the user is authenticated and has the 'superadmin' role
        if (!$user || !$user->hasRole('superadmin')) {
            return response()->json(['error' => 'Access denied. Only Super Admins are allowed.'], 403);
        }

        return $next($request);
    }
}

