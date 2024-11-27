<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetDataController;


use App\Http\Controllers\GetUsersRolesPermissions;


Route::post('/roles-permissions/{user_id}', [GetUsersRolesPermissions::class, 'getUserRolesAndPermissions']);

Route::get('/get-all-roles-permission', [GetUsersRolesPermissions::class, 'getAllUsersWithRolesAndPermissions']);

Route::post('/getUserPermissions', [GetUsersRolesPermissions::class, 'getUserPermissions']);

//Route::middleware('auth:sanctum')->get('/getdata', [GetDataController::class, 'getAllUsersWithRolesAndPermissions']);

//Route::get('/getdata', [GetDataController::class, 'getAllUsersWithRolesAndPermissions']);




// Include the user routes
require __DIR__ . '/user/user.php';

require __DIR__ . '/super_admin_route.php';

// Head branch route 
require __DIR__ . '/head_admin_route.php';
require __DIR__ . '/hr_head_route.php';


//Sub branch route
require __DIR__ . '/sub_head_admin_route.php';

require __DIR__ . '/sub_hr_head_route.php';


//common  branch condition
require __DIR__ . '/hr_routes.php';
require __DIR__ . '/operation_head_route.php';



require __DIR__ . '/employee_route.php';







