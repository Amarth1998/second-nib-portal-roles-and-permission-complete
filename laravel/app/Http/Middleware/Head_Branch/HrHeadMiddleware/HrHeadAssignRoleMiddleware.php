<?php

namespace App\Http\Middleware\Head_Branch\HrHeadMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use APP\Models\User;
class HrHeadAssignRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     // $user = Auth()->user();
    //      // Get the authenticated user
    //       $user = Auth::user();
    //     // Check if the authenticated user has an hr head role
    //     if ($user->hasRole('HrHead')) {
    //         // Retrieve the role being assigned
    //         $roleId = $request->role_id;

    //         // Get the role name using the ID
    //         $role = Role::find($roleId);

    //         // Restrict assigning "Super Admin" or "head Admin" and " Hr head" roles
    //         if ($role && in_array($role->name, ['SuperAdmin', 'HeadAdmin','HrHead'])) {
    //             return response()->json(['message' => 'You are not authorized to assign this role.'], 403);
    //         }
    //     }

    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next)
    {
        // Get the authenticated user
        $authUser = Auth::user();

        // Check if the authenticated user has the HeadAdmin role
        if ($authUser->hasRole('HrHead')) {
            // Retrieve the target user_id from the request
            $targetUserId = $request->input('user_id');

            // Find the target user
            $targetUser = User::find($targetUserId);

            // If the target user does not exist, return an error
            if (!$targetUser) {
                return response()->json(['message' => 'Target user not found.'], 404);
            }

            // Check if the target user already has a restricted role
            if ($targetUser->hasRole(['SuperAdmin', 'HeadAdmin','HrHead'])) {
                return response()->json([
                    'message' => 'You are not authorized to assign a role to a user with the SuperAdmin or HeadAdmin role.'
                ], 403);
            }

            // Retrieve the role being assigned
            $roleId = $request->input('role_id');
            $role = Role::find($roleId);

            // If the role does not exist, return an error
            if (!$role) {
                return response()->json(['message' => 'Role not found.'], 404);
            }

            // Prevent assigning "SuperAdmin" or "HeadAdmin" roles
            if (in_array($role->name, ['SuperAdmin', 'HeadAdmin','HrHead'])) {
                return response()->json([
                    'message' => 'You are not authorized to assign the SuperAdmin or HeadAdmin role.'
                ], 403);
            }
        }

        // Proceed to the next middleware or the controller
        return $next($request);
    }


}
