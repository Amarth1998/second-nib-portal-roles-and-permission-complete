<?php
use App\Http\Controllers\Employee\EmployeeController;
use Illuminate\Support\Facades\Route;


// Register and Login Routes
Route::post('employee/register', [EmployeeController::class, 'register']);
Route::post('employee/login', [EmployeeController::class, 'login']);
// Route::post('employee/logout', [EmployeeController::class, 'logout'])->middleware('auth:sanctum');