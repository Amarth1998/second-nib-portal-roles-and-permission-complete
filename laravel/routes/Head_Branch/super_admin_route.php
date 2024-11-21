<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminControllers\RolesPermissionController;
use App\Http\Middleware\SuperAdminMiddleware\CheckAuthSuperAdminMiddleware;

Route::prefix('superadmin') // Grouping routes under 'superadmin' prefix
    ->middleware('auth:sanctum') // Ensuring the user is authenticated
    ->group(function () {
        Route::middleware(CheckAuthSuperAdminMiddleware::class) // Checking if the user is SuperAdmin
            ->group(function () {
                Route::post('roles/assign', [RolesPermissionController::class, 'assignRole']);
                Route::post('roles/revoke', [RolesPermissionController::class, 'revokeRole']);
                Route::post('permissions/assign', [RolesPermissionController::class, 'assignPermission']);
                Route::post('permissions/revoke', [RolesPermissionController::class, 'revokePermission']);
            });
    });

