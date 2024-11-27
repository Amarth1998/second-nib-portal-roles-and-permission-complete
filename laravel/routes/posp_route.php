<?php
use App\Http\Controllers\POSP\POSPController;
use Illuminate\Support\Facades\Route;


// Register and Login Routes
Route::post('posp/register', [POSPController::class, 'register']);
Route::post('posp/login', [POSPController::class, 'login']);
// Route::post('employee/logout', [EmployeeController::class, 'logout'])->middleware('auth:sanctum');