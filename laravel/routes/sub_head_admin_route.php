<?php

use Illuminate\Support\Facades\Route;


use App\Http\Middleware\SubHeadAdminMiddleware\SubHeadAdminAssignPermissionMiddleware;
use App\Http\Middleware\SubHeadAdminMiddleware\SubHeadAdminAssignRoleMiddleware;

use App\Http\Middleware\SubHeadAdminMiddleware\SubHeadAdminRevokePermissionMiddleware;
use App\Http\Middleware\SubHeadAdminMiddleware\SubHeadAdminRevokeRoleMiddleware;



//**************************controllers************************************** */
use App\Http\Controllers\Roles_Permission_Controllers\AssignPermissionController;
use App\Http\Controllers\Roles_Permission_Controllers\AssignRoleController;

use App\Http\Controllers\Roles_Permission_Controllers\RevokeRoleController;
use App\Http\Controllers\Roles_Permission_Controllers\RevokePermissionController;



Route::prefix('subheadadmin') // Grouping routes under 'superadmin' prefix
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('roles/assign', [AssignRoleController::class, 'assignRole'])->middleware(SubHeadAdminAssignRoleMiddleware::class);

                Route::post('roles/revoke', [RevokeRoleController::class, 'revokeRole'])->middleware(SubHeadAdminRevokeRoleMiddleware::class);

                Route::post('permissions/assign', [AssignPermissionController::class, 'assignPermission'])->middleware(SubHeadAdminAssignPermissionMiddleware::class);

                Route::post('permissions/revoke', [RevokePermissionController::class, 'revokePermission'])->middleware(SubHeadAdminRevokePermissionMiddleware::class);
            });


