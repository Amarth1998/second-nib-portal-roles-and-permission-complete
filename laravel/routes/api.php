<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuperAdminControllers\RolesPermissionController;

Route::post('/roles-permissions/{user_id}', [RolesPermissionController::class, 'getUserRolesAndPermissions']);


// Include the user routes
require __DIR__ . '/user/user.php';
require __DIR__ . '/customer/customer.php';
// require __DIR__ . '/assignrolepermission/rolesandpermission.php';
// require __DIR__ . '/operationroute/operationroute.php';
require __DIR__ .'/super_admin_route.php';
require __DIR__ .'/admin_route.php';
