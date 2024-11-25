<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\SuperAdminControllers\RolesPermissionController;

// use App\Http\Controllers\SuperAdminControllers\Roles_And_Permission_Controllers\AssignPermissionController;


//*************************Controllers*********************************************** 

use App\Http\Controllers\Roles_Permission_Controllers\AssignPermissionController;
use App\Http\Controllers\Roles_Permission_Controllers\AssignRoleController;

use App\Http\Controllers\Roles_Permission_Controllers\RevokeRoleController;
use App\Http\Controllers\Roles_Permission_Controllers\RevokePermissionController;

//*************************middleware*********************************************** 
use App\Http\Middleware\SuperAdminMiddleware\SuperAdminAssignRoleMiddleware;
use App\Http\Middleware\SuperAdminMiddleware\SuperAdminRevokeRoleMiddleware;

use App\Http\Middleware\SuperAdminMiddleware\SuperAdminAssignPermissionMiddleware;
use App\Http\Middleware\SuperAdminMiddleware\SuperAdminRevokePermissionMiddleware;


// Route::prefix('superadmin') // Grouping routes under 'superadmin' prefix
//     ->middleware('auth:sanctum') // Ensuring the user is authenticated
//     ->group(function () {
       
//                 Route::post('roles/assign', [AssignRoleController::class, 'assignRole'])->middleware(SuperAdminAssignRoleMiddleware::class);

//                 Route::post('roles/revoke', [RevokeRoleController::class, 'revokeRole'])->middleware(SuperAdminRevokeRoleMiddleware::class);

//                 Route::post('permissions/assign', [AssignPermissionController::class, 'assignPermission'])->middleware(SuperAdminAssignPermissionMiddleware::class);

//                 Route::post('permissions/revoke', [RevokePermissionController::class, 'revokePermission'])->middleware(SuperAdminRevokePermissionMiddleware::class);
//             });



Route::prefix('superadmin') // Grouping routes under 'superadmin' prefix
    
    ->group(function () {
       
                Route::post('roles/assign', [AssignRoleController::class, 'assignRole']);

                Route::post('roles/revoke', [RevokeRoleController::class, 'revokeRole']);

                Route::post('permissions/assign', [AssignPermissionController::class, 'assignPermission']);

                Route::post('permissions/revoke', [RevokePermissionController::class, 'revokePermission']);
            });






