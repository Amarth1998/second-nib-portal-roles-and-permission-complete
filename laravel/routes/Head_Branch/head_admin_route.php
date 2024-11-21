<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminControllers\RolesPermissionController;

use App\Http\Middleware\Head_branch\HeadAdminMiddleware\HeadAdminAssignRoleMiddleware;
use App\Http\Middleware\Head_branch\HeadAdminMiddleware\HeadAdminRevokeRoleMiddleware;

use App\Http\Middleware\Head_branch\HeadAdminMiddleware\HeadAdminAssignPermissionMiddleware;
use App\Http\Middleware\Head_branch\HeadAdminMiddleware\HeadAdminRevokePermissionMiddleware;


Route::prefix('headadmin') // Grouping routes under 'superadmin' prefix
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('roles/assign', [RolesPermissionController::class, 'assignRole'])->middleware(HeadAdminAssignRoleMiddleware::class);

                Route::post('roles/revoke', [RolesPermissionController::class, 'revokeRole'])->middleware(HeadAdminRevokeRoleMiddleware::class);

                Route::post('permissions/assign', [RolesPermissionController::class, 'assignPermission'])->middleware(HeadAdminAssignPermissionMiddleware::class);

                Route::post('permissions/revoke', [RolesPermissionController::class, 'revokePermission'])->middleware(HeadAdminRevokePermissionMiddleware::class);
            });


