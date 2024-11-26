<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class GetDataController extends Controller
{
    /**
     * Get all users with their roles and permissions.
     * The data displayed depends on the user's role and the branch they belong to.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUsersWithRolesAndPermissions(Request $request)
    {
        // Get the currently authenticated user using Auth() helper
        $user = Auth::user();

        // Check for the role of the user and fetch data accordingly
        if ($user->hasRole('Super Admin') || $user->hasRole('Head Admin') || $user->hasRole('Head HR')) {
            // Super Admin, Head Admin, and Head HR can see all users across all branches
            $users = User::with('branch')->get(); // Fetch all users from all branches
        } elseif ($user->hasRole('Sub Head Admin') || $user->hasRole('Sub Head HR') || $user->hasRole('HR')) {
            // Sub Head Admin, Sub Head HR, and HR can only see users from their own branch
            $users = User::where('branch_id', $user->branch_id)->get(); // Fetch users from the same branch as the logged-in user
        } else {
            // For any other role, restrict access (optional)
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Map through each user to fetch roles and permissions
        $response = $users->map(function ($user) {
            return [
                'user_id' => $user->id,
                'name' => $user->name,
                'roles' => $user->roles->map(function ($role) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name,
                    ];
                }), // Get role IDs and names
                'permissions' => $user->getAllPermissions()->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                    ];
                }), // Get permission IDs and names
            ];
        });

        return response()->json($response);
    }
}
