<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminControllers\RolesPermissionController;

use App\Http\Middleware\Sub_Branch\SubHeadAdminMiddleware\SubHeadAdminAssignPermissionMiddleware;
use App\Http\Middleware\Sub_Branch\SubHeadAdminMiddleware\SubHeadAdminAssignRoleMiddleware;

use App\Http\Middleware\Sub_Branch\SubHeadAdminMiddleware\SubHeadAdminRevokePermissionMiddleware;
use App\Http\Middleware\Sub_Branch\SubHeadAdminMiddleware\SubHeadAdminRevokeRoleMiddleware;



Route::prefix('subheadadmin') // Grouping routes under 'superadmin' prefix
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('roles/assign', [RolesPermissionController::class, 'assignRole'])->middleware(SubHeadAdminAssignRoleMiddleware::class);

                Route::post('roles/revoke', [RolesPermissionController::class, 'revokeRole'])->middleware(SubHeadAdminRevokeRoleMiddleware::class);

                Route::post('permissions/assign', [RolesPermissionController::class, 'assignPermission'])->middleware(SubHeadAdminAssignPermissionMiddleware::class);

                Route::post('permissions/revoke', [RolesPermissionController::class, 'revokePermission'])->middleware(SubHeadAdminRevokePermissionMiddleware::class);
            });


