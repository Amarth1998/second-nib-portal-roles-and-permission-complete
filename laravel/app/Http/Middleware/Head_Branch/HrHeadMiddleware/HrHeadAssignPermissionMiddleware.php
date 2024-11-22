<?php

// namespace App\Http\Middleware\Head_Branch\HrHeadMiddleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
// use App\Models\User;

// use function Laravel\Prompts\alert;

// class HrHeadAssignPermissionMiddleware
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \Closure  $next
//      * @return \Symfony\Component\HttpFoundation\Response
//      */
//     public function handle(Request $request, Closure $next)
//     {
//         echo "hello1";
//         // Step 1: Check if the user is authenticated
//         $currentUser = Auth::user();
//         if (!$currentUser) {
//             return response()->json(['message' => 'Unauthorized.'], 401);
//         }

//       echo "hello2";
//         // Step 2: Check if the target user exists
//         $targetUserId = $request->input('user_id');
//         $targetUser = User::find($targetUserId);
        
//         if (!$targetUser) {
//             return response()->json(['message' => 'Target user not found.'], 404);
//         }

//         echo "hello3";
//         // Step 3: Check if the permission exists in the logged-in user's permissions
//         $permissionId = $request->input('permission_id');
//         $permission = Permission::find($permissionId);

//         if (!$permission) {
//             return response()->json(['message' => 'Permission not found.'], 404);
//         }

//         // Step 4: Ensure the target user is not a SuperAdmin, HeadAdmin, or HrHead
//         if ($targetUser->hasRole(['SuperAdmin', 'HeadAdmin', 'HrHead'])) {
//             return response()->json([
//                 'message' => 'You are not authorized to assign permissions to users with SuperAdmin, HeadAdmin, or HrHead roles.',
//             ], 403);
//         }

//         // Ensure the logged-in user has the permission to assign this permission
//         if (!$currentUser->hasPermissionTo($permission->name)) {
//             return response()->json([
//                 'message' => 'You do not have the required permission to assign this permission.',
//             ], 403);
//         }

//         // Continue with the request processing if all checks pass
//         return $next($request);
//     }

// }




namespace App\Http\Middleware\Head_Branch\HrHeadMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class HrHeadAssignPermissionMiddleware
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
        // Step 1: Check if the user is authenticated
        $currentUser = Auth::user();
        if (!$currentUser) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        // Step 2: Check if the target user exists
        $targetUserId = $request->input('user_id');
        $targetUser = User::find($targetUserId);
        if (!$targetUser) {
            return response()->json(['message' => 'Target user not found.'], 404);
        }

        // Step 3: Check if the permission exists
        $permissionId = $request->input('permission_id');
        $permission = Permission::find($permissionId);
        if (!$permission) {
            return response()->json(['message' => 'Permission not found.'], 404);
        }

        // Step 4: Ensure the target user is not a restricted role
        if ($targetUser->hasRole(['SuperAdmin', 'HeadAdmin', 'HrHead'])) {
            return response()->json([
                'message' => 'You are not authorized to assign permissions to users with SuperAdmin, HeadAdmin, or HrHead roles.',
            ], 403);
        }

        // Step 5: Check if the target user already has the permission
        if ($targetUser->hasPermissionTo($permission->name)) {
            return response()->json([
                'message' => 'The user already has this permission.',
            ], 409); // Conflict status code
        }

        // Step 6: Ensure the current user has the right to assign this permission
        if (!$currentUser->hasPermissionTo($permission->name)) {
            return response()->json([
                'message' => 'You do not have the required permission to assign this permission.',
            ], 403);
        }

        // Continue with the request processing if all checks pass
        return $next($request);
    }
}
