<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesAndPermission\OperationHeadRolePermissionController;
use App\Http\Middleware\CheckOperationHeadMiddleware;

// Apply authentication middleware
// Route::middleware(['auth:sanctum'])->group(function () {
    
//     // Apply the custom middleware for OperationHead role
//     Route::middleware(['check.operation.head'])->group(function () {
        
//         // Assign role to a user
//         Route::post('users/{userId}/assign-role', [OperationHeadRolePermissionController::class, 'assignRole']);
        
//         // Assign permission to a user
//         Route::post('users/{userId}/assign-permission', [OperationHeadRolePermissionController::class, 'assignPermission']);
        
//         // Revoke permission from a user
//         Route::post('users/{userId}/revoke-permission', [OperationHeadRolePermissionController::class, 'revokePermission']);
//     });
// });


// Route::middleware(['auth:sanctum'])->group(function () {
        
//         // Assign role to a user
//         Route::post('users/{userId}/assign-role', [OperationHeadRolePermissionController::class, 'assignRole'])->middleware(CheckOperationHeadMiddleware::class);
        
//         // Assign permission to a user
//         Route::post('users/{userId}/assign-permission', [OperationHeadRolePermissionController::class, 'assignPermission'])->middleware(CheckOperationHeadMiddleware::class);
        
//         // Revoke permission from a user
//         Route::post('users/{userId}/revoke-permission', [OperationHeadRolePermissionController::class, 'revokePermission'])->middleware(CheckOperationHeadMiddleware::class);
   
// });


// use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesAndPermission\RolePermissionController;
use App\Http\Middleware\CheckRoleAssignmentMiddleware;

// Route group for authenticated users
// Route::middleware(['auth:sanctum'])->group(function () {
//     // HRHead and OperationHead role middleware to assign roles and permissions
//     Route::middleware([CheckHRHeadMiddleware::class, CheckRoleAssignmentMiddleware::class])->group(function () {
//         // Assign role to user
//         Route::post('users/{userId}/assign-role', [RolePermissionController::class, 'assignRole']);
//         // Assign permission to user
//         Route::post('users/{userId}/assign-permission', [RolePermissionController::class, 'assignPermission']);
//         // Revoke permission from user
//         Route::post('users/{userId}/revoke-permission', [RolePermissionController::class, 'revokePermission']);
//     });

//     // You can add additional role-based middleware for OperationHead similarly
//     Route::middleware([CheckOperationHeadMiddleware::class, CheckRoleAssignmentMiddleware::class])->group(function () {
//         // Assign role to user
//         Route::post('users/{userId}/assign-role', [RolePermissionController::class, 'assignRole']);
//         // Assign permission to user
//         Route::post('users/{userId}/assign-permission', [RolePermissionController::class, 'assignPermission']);
//         // Revoke permission from user
//         Route::post('users/{userId}/revoke-permission', [RolePermissionController::class, 'revokePermission']);
//     });
// });



Route::middleware(['auth:sanctum'])->group(function () {
  
   
        // Assign role to user
        Route::post('users/{userId}/assign-role', [RolePermissionController::class, 'assignRole']);
        // Assign permission to user
        Route::post('users/{userId}/assign-permission', [RolePermissionController::class, 'assignPermission']);
        // Revoke permission from user
        Route::post('users/{userId}/revoke-permission', [RolePermissionController::class, 'revokePermission']);
   

    });
