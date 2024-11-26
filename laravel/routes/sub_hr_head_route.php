<?php

use Illuminate\Support\Facades\Route;


use App\Http\Middleware\SubHrHeadMiddleware\SubHrHeadAssignRoleMiddleware;
use App\Http\Middleware\SubHrHeadMiddleware\SubHrHeadRevokeRoleMiddleware;

use App\Http\Middleware\SubHrHeadMiddleware\SubHrHeadAssignPermissionMiddleware;
use App\Http\Middleware\SubHrHeadMiddleware\SubHrHeadRevokePermissionMiddleware;



//**************************controllers************************************** */
use App\Http\Controllers\Roles_Permission_Controllers\AssignPermissionController;
use App\Http\Controllers\Roles_Permission_Controllers\AssignRoleController;

use App\Http\Controllers\Roles_Permission_Controllers\RevokeRoleController;
use App\Http\Controllers\Roles_Permission_Controllers\RevokePermissionController;



Route::prefix('subhrhead') 
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('roles/assign', [AssignRoleController::class, 'assignRole'])->middleware(SubHrHeadAssignRoleMiddleware::class);

                Route::post('roles/revoke', [RevokeRoleController::class, 'revokeRole'])->middleware(SubHrHeadRevokeRoleMiddleware::class);

                Route::post('permissions/assign', [AssignPermissionController::class, 'assignPermission'])->middleware(SubHrHeadAssignPermissionMiddleware::class);

                Route::post('permissions/revoke', [RevokePermissionController::class, 'revokePermission'])->middleware(SubHrHeadRevokePermissionMiddleware::class);
            });


