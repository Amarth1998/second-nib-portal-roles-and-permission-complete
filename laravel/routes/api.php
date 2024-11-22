<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Head_Branch_Data_Retreive\GetDataController;


use App\Http\Controllers\SuperAdminControllers\GetUsersRolesPermissions;
// use App\Http\Controllers\SuperAdminControllers\RolesPermissionController;



Route::post('/roles-permissions/{user_id}', [GetUsersRolesPermissions::class, 'getUserRolesAndPermissions']);


Route::get('/get-all-roles-permission', [GetUsersRolesPermissions::class, 'getAllUsersWithRolesAndPermissions']);


Route::post('/getUserPermissions', [GetUsersRolesPermissions::class, 'getUserPermissions']);



Route::middleware('auth:sanctum')->get('/getdata', [GetDataController::class, 'getAllUsersWithRolesAndPermissions']);

// Include the user routes
require __DIR__ . '/user/user.php';
// require __DIR__ . '/customer/customer.php';



// Head branch route 
require __DIR__ . '/Head_Branch/super_admin_route.php';
require __DIR__ . '/head_admin_route.php';
require __DIR__ . '/Head_Branch/hr_head_route.php';


//Sub branch route
require __DIR__ . '/Sub_Branch/sub_head_admin_route.php';


//common 
require __DIR__ . '/hr_routes.php';








