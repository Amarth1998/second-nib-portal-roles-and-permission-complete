<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminControllers\RolesPermissionController;

use App\Http\Middleware\HrMiddleware\CheckHrheadRoleMiddleware;
use App\Http\Middleware\HrMiddleware\CheckHrheadRevokeRoleMiddleware;

use App\Http\Middleware\HrMiddleware\CheckHrheadPermissionMiddleware;
use App\Http\Middleware\HrMiddleware\CheckHrheadRevokePermissionMiddleware;


Route::prefix('hrhead') // Grouping routes under 'superadmin' prefix
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('roles/assign', [RolesPermissionController::class, 'assignRole'])->middleware(CheckHrHeadRoleMiddleware::class);

                Route::post('roles/revoke', [RolesPermissionController::class, 'revokeRole'])->middleware(CheckHrHeadRevokeRoleMiddleware::class);

                Route::post('permissions/assign', [RolesPermissionController::class, 'assignPermission'])->middleware(CheckHrHeadPermissionMiddleware::class);

                Route::post('permissions/revoke', [RolesPermissionController::class, 'revokePermission'])->middleware(CheckHrHeadRevokePermissionMiddleware::class);
            });


