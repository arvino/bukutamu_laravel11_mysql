<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BukutamuController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [BukutamuController::class, 'index'])->name('home');
Route::get('/bukutamu/{bukutamu}', [BukutamuController::class, 'show'])->name('bukutamu.show');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Member routes
    Route::resource('bukutamu', BukutamuController::class)
        ->except(['show']);
    
    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('admin/members', AdminController::class)
            ->except(['show', 'create', 'store'])
            ->names('admin.members');
    });
});
