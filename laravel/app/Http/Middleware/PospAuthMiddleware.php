<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class PospAuthMiddleware
{
    
public function handle(Request $request, Closure $next)
{
    $posp = Auth::user();

    if (!$posp) {
        return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
    }

    // Email verification check
    // if (!$posp->hasVerifiedEmail()) {
    //     return response()->json(['message' => 'Email not verified.'], 403);
    // }

    if (!$posp->email_verified) {
        return response()->json(['message' => 'Email not verified.'], 403);
    }
    

    // Add any further custom checks here

    return $next($request);
}

}
