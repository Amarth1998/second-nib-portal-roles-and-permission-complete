<?php

namespace App\Http\Middleware\Head_Branch\HeadAdminMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class HeadAdminAssignPermissionMiddleware
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

        // Retrieve the target user and permission ID from the request
        $targetUserId = $request->input('user_id');
        $permissionId = $request->input('permission_id'); // Using permission_id instead of permission name

        // Find the target user and permission by ID
        $targetUser = User::find($targetUserId);
        $permission = Permission::find($permissionId); // Retrieve by ID

        // Ensure the target user and permission exist
        if (!$targetUser) {
            return response()->json(['message' => 'Target user not found.'], 404);
        }

        if (!$permission) {
            return response()->json(['message' => 'Permission not found.'], 404);
        }

        // Restrict assign permissions from "SuperAdmin" or "HeadAdmin"
        if ($targetUser->hasRole(['SuperAdmin', 'HeadAdmin'])) {
            return response()->json(['message' => 'You are not authorized to assign permissions from SuperAdmin or HeadAdmin.'], 403);
        }

        // Ensure the logged-in user has the required permission
        if (!$currentUser->hasPermissionTo($permission)) {
            return response()->json(['message' => 'You do not have the required permission to assign php this permission.'], 403);
        }

        // Proceed to the next middleware or the controller
        return $next($request);
    }
}



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
//         // Get the authenticated user
//         $currentUser = Auth::user();

//         // Ensure the user is authenticated
//         if (!$currentUser) {
//             return response()->json(['message' => 'Unauthorized.'], 401);
//         }

//         // Retrieve the target user and permission from the request
//         $targetUserId = $request->input('user_id');
//         $permissionName = $request->input('permission_id');

//         $targetUser = User::find($targetUserId);
//         $permission = Permission::where('name', $permissionName)->first();

//         // Ensure the target user and permission exist
//         if (!$targetUser) {
//             return response()->json(['message' => 'Target user not found.'], 404);
//         }

//         if (!$permission) {
//             return response()->json(['message' => 'Permission not found.'], 404);
//         }

//         // Restrict assigning permissions to users with "SuperAdmin" or "Head Admin" roles
//         if ($targetUser->hasRole(['SuperAdmin', 'HeadAdmin'])) {
//             return response()->json(['message' => 'You are not authorized to assign permissions to users with SuperAdmin or Admin roles.'], 403);
//         }

//         // Ensure the admin can only assign permissions they have
//         if (!$currentUser->hasPermissionTo($permission)) {
//             return response()->json(['message' => 'You do not have the required permission to assign this permission.'], 403);
//         }

//         // Proceed to the next middleware or the controller
//         return $next($request);
//     }
// }




// namespace App\Http\Middleware\Head_Branch\HeadAdminMiddleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Spatie\Permission\Models\Permission;
// use App\Models\User;

// class HeadAdminAssignPermissionMiddleware
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
//         // Get the authenticated user
//         $currentUser = Auth::user();

//         // Ensure the user is authenticated
//         if (!$currentUser) {
//             return response()->json(['message' => 'Unauthorized.'], 401);
//         }

//         // Retrieve the target user and permission from the request
//         $targetUserId = $request->input('user_id');
//         $permissionId = $request->input('permission_id');

//         // Find the target user and permission
//         $targetUser = User::find($targetUserId);
//         $permission = Permission::find($permissionId);

//         // Validate existence of the target user and permission
//         if (!$targetUser) {
//             return response()->json(['message' => 'Target user not found.'], 404);
//         }

//         if (!$permission) {
//             return response()->json(['message' => 'Permission not found.'], 404);
//         }

//         // Restrict assigning permissions to users with "SuperAdmin" or "HeadAdmin" roles
//         if ($targetUser->hasRole(['SuperAdmin', 'HeadAdmin'])) {
//             return response()->json(['message' => 'You are not authorized to assign permissions to users with SuperAdmin or HeadAdmin roles.'], 403);
//         }

//         // Ensure the current user has the permission they want to assign
//         if (!$currentUser->hasPermissionTo($permission->name)) {
//             return response()->json([
//                 'message' => 'You do not have the required permission to assign this permission.',
//             ], 403);
//         }

//         // Check if the target user already has the permission
//         if ($targetUser->hasPermissionTo($permission->name)) {
//             return response()->json([
//                 'message' => 'The user already has this permission.',
//             ], 409); // Use HTTP 409 for conflict
//         }

//         // Proceed to the next middleware or controller
//         return $next($request);
//     }
// }





// namespace App\Http\Middleware\Head_Branch\HeadAdminMiddleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Spatie\Permission\Models\Permission;
// use App\Models\User;

// class HeadAdminAssignPermissionMiddleware
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
//         // Get the authenticated user
//         $currentUser = Auth::user();

//         // Ensure the user is authenticated
//         if (!$currentUser) {
//             return response()->json(['message' => 'Unauthorized.'], 401);
//         }

//         // Retrieve the target user and permission from the request
//         $targetUserId = $request->input('user_id');
//         $permissionId = $request->input('permission_id');

//         // Find the target user and permission
//         $targetUser = User::find($targetUserId);
//         $permission = Permission::find($permissionId);

//         // Validate existence of the target user and permission
//         if (!$targetUser) {
//             return response()->json(['message' => 'Target user not found.'], 404);
//         }

//         if (!$permission) {
//             return response()->json(['message' => 'Permission not found.'], 404);
//         }

//         // Restrict assigning permissions to users with "SuperAdmin" or "HeadAdmin" roles
//         if ($targetUser->hasRole(['SuperAdmin', 'HeadAdmin'])) {
//             return response()->json(['message' => 'You are not authorized to assign permissions to users with SuperAdmin or HeadAdmin roles.'], 403);
//         }

//         // Ensure the current user has the permission they want to assign
//         if (!$currentUser->hasPermissionTo($permission->name)) {
//             return response()->json([
//                 'message' => 'You do not have the required permission to assign this permission.',
//             ], 403);
//         }

//         // Check if the target user already has the permission
//         if ($targetUser->hasPermissionTo($permission->name)) {
//             return response()->json([
//                 'message' => 'The user already has this permission.',
//             ], 409); // Use HTTP 409 for conflict
//         }

//         // Proceed to the next middleware or controller
//         return $next($request);
//     }
// }





// namespace App\Http\Middleware\Head_Branch\HeadAdminMiddleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Spatie\Permission\Models\Permission;
// use App\Models\User;

// class HeadAdminAssignPermissionMiddleware
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
//         // Get the authenticated user
//         $currentUser = Auth::user();

//         // Step 1: Ensure the user is authenticated
//         if (!$currentUser) {
//             return response()->json(['message' => 'Unauthorized.'], 401);
//         }

//         // Step 2: Retrieve the target user and permission ID from the request
//         $targetUserId = $request->input('user_id');
//         $permissionId = $request->input('permission_id'); // Using permission_id instead of permission name

//         // Find the target user and permission by ID
//         $targetUser = User::find($targetUserId);
//         $permission = Permission::find($permissionId); // Retrieve by ID

//         // Step 3: Ensure the target user and permission exist
//         if (!$targetUser) {
//             return response()->json(['message' => 'Target user not found.'], 404);
//         }

//         if (!$permission) {
//             return response()->json(['message' => 'Permission not found.'], 404);
//         }

//         // Step 4: Restrict assigning permissions to "SuperAdmin" or "HeadAdmin"
//         if ($targetUser->hasRole(['SuperAdmin', 'HeadAdmin'])) {
//             return response()->json([
//                 'message' => 'You are not authorized to assign permissions to users with SuperAdmin or HeadAdmin roles.'
//             ], 403);
//         }

//         // Step 5: Ensure the logged-in user has the required permission to assign this permission
//         if (!$currentUser->hasPermissionTo($permission->name)) {
//             return response()->json([
//                 'message' => 'You do not have the required permission to assign this permission.'
//             ], 403);
//         }

//         // Step 6: Ensure the target user does not already have the permission
//         if ($targetUser->hasPermissionTo($permission->name)) {
//             return response()->json([
//                 'message' => 'The user already has this permission.'
//             ], 409); // Conflict status code
//         }

//         // Proceed to the next middleware or the controller
//         return $next($request);
//     }
// }
