<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminControllers\RolesPermissionController;

use App\Http\Middleware\AdminMiddleware\CheckAdminRoleMiddleware;
use App\Http\Middleware\AdminMiddleware\CheckAdminRevokeRoleMiddleware;

use App\Http\Middleware\AdminMiddleware\CheckAdminPermissionMiddleware;
use App\Http\Middleware\AdminMiddleware\CheckAdminRevokePermissionMiddleware;


Route::prefix('admin') // Grouping routes under 'superadmin' prefix
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('/roles-permissions/{user_id}', [RolesPermissionController::class, 'getUserRolesAndPermissions']);

                Route::post('roles/assign', [RolesPermissionController::class, 'assignRole'])->middleware(CheckAdminRoleMiddleware::class);

                Route::post('roles/revoke', [RolesPermissionController::class, 'revokeRole'])->middleware(CheckAdminRevokeRoleMiddleware::class);

                Route::post('permissions/assign', [RolesPermissionController::class, 'assignPermission'])->middleware(CheckAdminPermissionMiddleware::class);

                Route::post('permissions/revoke', [RolesPermissionController::class, 'revokePermission'])->middleware(CheckAdminRevokePermissionMiddleware::class);
            });


