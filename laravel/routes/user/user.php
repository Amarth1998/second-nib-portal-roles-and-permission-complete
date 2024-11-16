<?php
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


// Register and Login Routes
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');