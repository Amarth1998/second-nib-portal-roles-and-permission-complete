<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOperationHeadMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the 'OperationHead' role
        $user = Auth::user();

        if (!$user || !$user->hasRole('OperationHead')) {
            return response()->json(['error' => 'Unauthorized', 'message' => 'You do not have permission to access this resource.'], 403);
        }

        // Allow the request to proceed to the next middleware/controller
        return $next($request);
    }
}
