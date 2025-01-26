<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BukutamuController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
	// Auth routes
	Route::post('/logout', [AuthController::class, 'logout']);
	Route::get('/profile', [AuthController::class, 'profile']);
	Route::put('/profile', [AuthController::class, 'updateProfile']);

	// Bukutamu routes
	Route::apiResource('bukutamu', BukutamuController::class);
});