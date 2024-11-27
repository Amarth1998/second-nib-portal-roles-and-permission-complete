<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller

{

    // Register method
    public function register(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:2',
           'branch_id' => 'required|exists:branches,id',
           
        ]);

        // Return validation error if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // 'password'=>$request->password,
            'password' => Hash::make($request->password), // Hash password before storing
        'branch_id' => $request->branch_id,  // Save branch ID
        ]);



        // Return success response with token and user data
        return response()->json([
            'message' => 'Registration successful.',
            'user' => $user,

        ], 201);
    }



    public function login(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:2',
        ]);

        // Return validation error if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Check if the user exists and the password is correct
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Get the authenticated user
            $user = Auth::user();

            // Get the roles associated with the user
            $roles = $user->getRoleNames(); // Returns a collection of roles

            // Get the permissions associated with the user
            $permissions = $user->getAllPermissions(); // Returns a collection of permissions

            // Generate a new API token for the user
            $token = $user->createToken('API Token')->plainTextToken;

            // Return success response with token, user data, roles, and permissions
            return response()->json([
                'token' => $token, 
                'message' => 'Login successful.',
                // 'user' => $user,
                'roles' => $roles,  // Include roles in the response
                'permissions' => $permissions->pluck('name'),  // Include permissions in the response
                
            ]);
        } else {
            // Return error if authentication fails
            return response()->json(['error' => 'Unauthorized, incorrect credentials'], 401);
        }
    }
}
