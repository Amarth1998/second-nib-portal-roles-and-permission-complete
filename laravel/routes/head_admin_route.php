<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminControllers\RolesPermissionController;

// use App\Http\Controllers\SuperAdminControllers\Roles_And_Permission_Controllers\AssignPermissionController;

use App\Http\Controllers\SuperAdminControllers\Roles_Permission_Controllers\AssignPermissionController;
use App\Http\Middleware\Head_Branch\HeadAdminMiddleware\HeadAdminAssignRoleMiddleware;
use App\Http\Middleware\Head_Branch\HeadAdminMiddleware\HeadAdminRevokeRoleMiddleware;

use App\Http\Middleware\Head_Branch\HeadAdminMiddleware\HeadAdminAssignPermissionMiddleware;
use App\Http\Middleware\Head_Branch\HeadAdminMiddleware\HeadAdminRevokePermissionMiddleware;


Route::prefix('headadmin') // Grouping routes under 'superadmin' prefix
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('roles/assign', [RolesPermissionController::class, 'assignRole'])->middleware(HeadAdminAssignRoleMiddleware::class);

                Route::post('roles/revoke', [RolesPermissionController::class, 'revokeRole'])->middleware(HeadAdminRevokeRoleMiddleware::class);

                Route::post('permissions/assign', [AssignPermissionController::class, 'assignPermission'])->middleware(HeadAdminAssignPermissionMiddleware::class);

                Route::post('permissions/revoke', [RolesPermissionController::class, 'revokePermission'])->middleware(HeadAdminRevokePermissionMiddleware::class);
            });


