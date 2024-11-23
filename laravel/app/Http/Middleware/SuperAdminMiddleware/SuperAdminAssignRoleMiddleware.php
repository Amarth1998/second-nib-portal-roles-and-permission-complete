<?php

namespace App\Http\Middleware\SuperAdminMiddleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;
// use Spatie\Permission\Models\Permission;

class SuperAdminAssignRoleMiddleware
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
         if ($authUser->hasRole('SuperAdmin')) {
             // Retrieve the target user_id from the request
             $targetUserId = $request->input('user_id');
             
             // Find the target user
             $targetUser = User::find($targetUserId);
 
             // If the target user does not exist, return an error
             if (!$targetUser) {
                 return response()->json(['message' => 'Target user not found.'], 404);
             }
 
             // Check if the target user already has a restricted role
             if ($targetUser->hasRole(['SuperAdmin'])) {
                 return response()->json([
                     'message' => 'You are not authorized to assign a role to a user with the SuperAdmin role'
                 ], 403);
             }
 
             // Retrieve the role being assigned
             $roleId = $request->input('role_id');
             $role = Role::find($roleId);
 
             // If the role does not exist, return an error
             if (!$role) {
                 return response()->json(['message' => 'Role not found.'], 404);
             }
 
             // Prevent assigning "SuperAdmin" roles
             if (in_array($role->name, ['SuperAdmin'])) {
                 return response()->json([
                     'message' => 'You are not authorized to assign the SuperAdmin role.'
                 ], 403);
             }
         }
 
         // Proceed to the next middleware or the controller
         return $next($request);
     }


}
