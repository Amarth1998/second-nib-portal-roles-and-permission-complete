<?php

namespace App\Http\Middleware\HrMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;

class HrAssignRoleMiddleware
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
        $authUser = Auth::user();

        // Check if the authenticated user has the HeadAdmin role
        if ($authUser->hasRole('Hr')) {
            // Retrieve the target user_id from the request
            $targetUserId = $request->input('user_id');

            // Find the target user
            $targetUser = User::find($targetUserId);

            // If the target user does not exist, return an error
            if (!$targetUser) {
                return response()->json(['message' => 'Target user not found.'], 404);
            }

            // Check if the target user already has a restricted role
            if ($targetUser->hasRole(['SuperAdmin', 'HeadAdmin', 'HrHead', 'SubHeadAdmin', 'SubHrHeadAdmin', 'Hr'])) {
                return response()->json([
                    'message' => 'You are not authorized to assign a role to a user'
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
            if (in_array($role->name, ['SuperAdmin', 'HeadAdmin', 'HrHead', 'SubHeadAdmin', 'SubHrHeadAdmin', 'Hr'])) {
                return response()->json([
                    'message' => 'You are not authorized to assign the SuperAdmin or HeadAdmin role.'
                ], 403);
            }
        }
        //     // Ensure the target user is in the same branch as the current user
        if ($authUser->branch_id !== $targetUser->branch_id) {
            return response()->json(['message' => 'You are not authorized to assign roles to users outside your branch.'], 403);
        }

        // Proceed to the next middleware or the controller
        return $next($request);
    }

    // public function handle(Request $request, Closure $next)
    // {
    //     // Get the authenticated user
    //     $currentUser = Auth::user();

    //     // Ensure the user is authenticated
    //     if (!$currentUser) {
    //         return response()->json(['message' => 'Unauthorized.'], 401);
    //     }

    //     // Retrieve the target user and role from the request
    //     $targetUserId = $request->input('user_id');
    //     $roleId = $request->input('role_id');

    //     $targetUser = User::find($targetUserId);
    //     $role = Role::find($roleId);

    //     // Ensure the target user and role exist
    //     if (!$targetUser) {
    //         return response()->json(['message' => 'Target user not found.'], 404);
    //     }

    //     if (!$role) {
    //         return response()->json(['message' => 'Role not found.'], 404);
    //     }

    //     // Restrict assigning roles to "SuperAdmin", "HeadAdmin", "SubHeadAdmin", "SubHrHeadAdmin", or "Hr"
    //     if (in_array($role->name, ['SuperAdmin', 'HeadAdmin', 'SubHeadAdmin', 'SubHrHeadAdmin', 'Hr'])) {
    //         return response()->json(['message' => 'You are not authorized to assign this role.'], 403);
    //     }

    //     // Ensure the target user is in the same branch as the current user
    //     if ($currentUser->branch_id !== $targetUser->branch_id) {
    //         return response()->json(['message' => 'You are not authorized to assign roles to users outside your branch.'], 403);
    //     }

    //     // Allow the request to proceed if all checks pass
    //     return $next($request);
    // }
}
