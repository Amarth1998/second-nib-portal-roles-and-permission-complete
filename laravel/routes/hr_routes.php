<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Roles_Permission_Controllers\AssignRoleController;
use App\Http\Controllers\Roles_Permission_Controllers\RevokeRoleController;


use App\Http\Middleware\HrMiddleware\HrAssignRoleMiddleware;
use App\Http\Middleware\HrMiddleware\HrRevokeRoleMiddleware;



Route::prefix('hr') // Grouping routes under 'superadmin' prefix
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('roles/assign', [AssignRoleController::class, 'assignRole'])->middleware(HrAssignRoleMiddleware::class);
                Route::post('roles/revoke', [RevokeRoleController::class, 'revokeRole'])->middleware(HrRevokeRoleMiddleware::class);

                
            });


