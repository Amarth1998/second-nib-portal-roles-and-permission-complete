<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\HrHeadMiddleware\HrHeadAssignRoleMiddleware;
use App\Http\Middleware\HrHeadMiddleware\HrHeadRevokeRoleMiddleware;

use App\Http\Middleware\HrHeadMiddleware\HrHeadAssignPermissionMiddleware;
use App\Http\Middleware\HrHeadMiddleware\HrHeadRevokePermissionMiddleware;

//***************************controller*********************

use App\Http\Controllers\Roles_Permission_Controllers\AssignPermissionController;
use App\Http\Controllers\Roles_Permission_Controllers\AssignRoleController;

use App\Http\Controllers\Roles_Permission_Controllers\RevokeRoleController;
use App\Http\Controllers\Roles_Permission_Controllers\RevokePermissionController;




Route::prefix('hrhead') // Grouping routes under 'superadmin' prefix
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('roles/assign', [AssignRoleController::class, 'assignRole'])->middleware(HrHeadAssignRoleMiddleware::class);

                Route::post('roles/revoke', [RevokeRoleController::class, 'revokeRole'])->middleware(HrHeadRevokeRoleMiddleware::class);

                Route::post('permissions/assign', [AssignPermissionController::class, 'assignPermission'])->middleware(HrHeadAssignPermissionMiddleware::class);

                Route::post('permissions/revoke', [RevokePermissionController::class, 'revokePermission'])->middleware(HrHeadRevokePermissionMiddleware::class);
            });


