<?php

use App\Http\Controllers\POSP\PospController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PospAuthMiddleware;

Route::prefix('posp')->group(function () {
    // Stage 1: Basic Registration
    Route::post('/register', [PospController::class, 'basicRegistration']);

    // Stage 2: Email Verification
    Route::get('/verify-email', [PospController::class, 'verifyEmail'])->name('posp.verify-email');


    // Stage 3: Document Submission
    Route::post('/document-submission', [PospController::class, 'documentSubmission'])
    ->middleware('auth:sanctum')
    ->middleware(PospAuthMiddleware::class);


    // Stage 4: Login
    Route::post('/login', [PospController::class, 'login']);
});
