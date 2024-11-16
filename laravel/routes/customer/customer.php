<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\CheckPermissionMiddleware;

// Apply CheckPermission middleware to customer routes
Route::middleware(['auth:sanctum'])->prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])
        ->middleware(CheckPermissionMiddleware::class . ':view customers');

    Route::post('/', [CustomerController::class, 'store'])
        ->middleware(CheckPermissionMiddleware::class . ':add customers');

    Route::get('/{id}', [CustomerController::class, 'show'])
        ->middleware(CheckPermissionMiddleware::class . ':view customers');

    Route::put('/{id}', [CustomerController::class, 'update'])
        ->middleware(CheckPermissionMiddleware::class . ':edit customers');

    Route::delete('/{id}', [CustomerController::class, 'destroy'])
        ->middleware(CheckPermissionMiddleware::class . ':delete customers');
});
