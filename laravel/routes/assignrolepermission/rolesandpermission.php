<?php
use App\Http\Controllers\RolesAndPermission\RolesController;
use App\Http\Controllers\RolesAndPermission\PermissionsController;

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureSuperAdminMiddleware;


Route::middleware('auth:sanctum')->group(function () { 
    Route::post('assignpermission', [PermissionsController::class, 'assignPermission'])->middleware(EnsureSuperAdminMiddleware::class);
    Route::post('assignrole', [RolesController::class, 'assignRole']);

}
);