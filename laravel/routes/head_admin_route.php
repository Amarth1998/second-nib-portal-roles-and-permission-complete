<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminControllers\RolesPermissionController;


use App\Http\Middleware\HeadAdminMiddleware\HeadAdminAssignRoleMiddleware;
use App\Http\Middleware\HeadAdminMiddleware\HeadAdminRevokeRoleMiddleware;

use App\Http\Middleware\HeadAdminMiddleware\HeadAdminAssignPermissionMiddleware;
use App\Http\Middleware\HeadAdminMiddleware\HeadAdminRevokePermissionMiddleware;


use App\Http\Controllers\Roles_Permission_Controllers\AssignPermissionController;
use App\Http\Controllers\Roles_Permission_Controllers\AssignRoleController;

use App\Http\Controllers\Roles_Permission_Controllers\RevokeRoleController;
use App\Http\Controllers\Roles_Permission_Controllers\RevokePermissionController;


Route::prefix('headadmin') // Grouping routes under 'superadmin' prefix
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('roles/assign', [AssignRoleController::class, 'assignRole'])->middleware(HeadAdminAssignRoleMiddleware::class);

                Route::post('roles/revoke', [RevokeRoleController::class, 'revokeRole'])->middleware(HeadAdminRevokeRoleMiddleware::class);

                Route::post('permissions/assign', [AssignPermissionController::class, 'assignPermission'])->middleware(HeadAdminAssignPermissionMiddleware::class);

                Route::post('permissions/revoke', [RevokePermissionController::class, 'revokePermission'])->middleware(HeadAdminRevokePermissionMiddleware::class);
            });


