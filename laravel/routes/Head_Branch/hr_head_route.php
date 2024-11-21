<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminControllers\RolesPermissionController;

use App\Http\Middleware\Head_branch\HrHeadMiddleware\HrheadAssignRoleMiddleware;
use App\Http\Middleware\Head_branch\HrHeadMiddleware\HrheadRevokeRoleMiddleware;

use App\Http\Middleware\Head_branch\HrHeadMiddleware\HrheadAssignPermissionMiddleware;
use App\Http\Middleware\Head_branch\HrHeadMiddleware\HrheadRevokePermissionMiddleware;


Route::prefix('hrhead') // Grouping routes under 'superadmin' prefix
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('roles/assign', [RolesPermissionController::class, 'assignRole'])->middleware(HrHeadAssignRoleMiddleware::class);

                Route::post('roles/revoke', [RolesPermissionController::class, 'revokeRole'])->middleware(HrHeadRevokeRoleMiddleware::class);

                Route::post('permissions/assign', [RolesPermissionController::class, 'assignPermission'])->middleware(HrHeadAssignPermissionMiddleware::class);

                Route::post('permissions/revoke', [RolesPermissionController::class, 'revokePermission'])->middleware(HrHeadRevokePermissionMiddleware::class);
            });


