<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();

        // Check if user is logged in and has the permission
        if (!$user || !$user->can($permission)) {
            return response()->json(['error' => 'Unauthorized, insufficient permissions'], 403);
        }

        return $next($request);
    }
}
