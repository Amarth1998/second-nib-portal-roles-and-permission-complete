<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminControllers\RolesPermissionController;

use App\Http\Middleware\HrMiddleware\HrAssignRoleMiddleware;
use App\Http\Middleware\HrMiddleware\HrRevokeRoleMiddleware;



Route::prefix('hr') // Grouping routes under 'superadmin' prefix
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('roles/assign', [RolesPermissionController::class, 'assignRole'])->middleware(HrAssignRoleMiddleware::class);
                Route::post('roles/revoke', [RolesPermissionController::class, 'revokeRole'])->middleware(HrRevokeRoleMiddleware::class);

                
            });


