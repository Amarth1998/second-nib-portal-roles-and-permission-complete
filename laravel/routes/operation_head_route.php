<?php

use Illuminate\Support\Facades\Route;


use App\Http\Middleware\OperationHeadMiddleware\OperationheadAssignPermissionMiddleware;
use App\Http\Middleware\OperationHeadMiddleware\OperationheadRevokePermissionMiddleware;

use App\Http\Controllers\Roles_Permission_Controllers\AssignPermissionController;
use App\Http\Controllers\Roles_Permission_Controllers\RevokePermissionController;




Route::prefix('operationhead') 
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
       
                Route::post('permissions/assign', [AssignPermissionController::class, 'assignPermission'])->middleware(OperationHeadAssignPermissionMiddleware::class);

                Route::post('permissions/revoke', [RevokePermissionController::class, 'revokePermission'])->middleware(OperationHeadRevokePermissionMiddleware::class);
            });


