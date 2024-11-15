<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureSuperAdmin;
// Register and Login Routes
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

// Sanctum protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);

    Route::post('assignpermission', [UserController::class, 'assignPermission'])->middleware(EnsureSuperAdmin::class);
    Route::post('assignrole', [UserController::class, 'assignRole']);
 

  
    // Routes with permission-based access
    Route::middleware('permission:view customers')->group(function () {
        Route::get('customers', [CustomerController::class, 'index']);
        Route::get('customers/{id}', [CustomerController::class, 'show']);
    });
    
    Route::middleware('permission:add customers')->group(function () {
        Route::post('addcustomers', [CustomerController::class, 'store']);
    });
    
    Route::middleware('permission:edit customers')->group(function () {
        Route::put('customers/{id}', [CustomerController::class, 'update']);
    });
    
    Route::middleware('permission:delete customers')->group(function () {
        Route::delete('customers/{id}', [CustomerController::class, 'destroy']);
    });
});
