<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BukutamuController;
use App\Http\Controllers\ProfileController;
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
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::resource('bukutamu', BukutamuController::class);
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
    
    // Admin routes
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/members', [AdminController::class, 'members'])->name('members.index');
        Route::get('/members/{member}/edit', [AdminController::class, 'editMember'])->name('members.edit');
        Route::put('/members/{member}', [AdminController::class, 'updateMember'])->name('members.update');
        Route::delete('/members/{member}', [AdminController::class, 'destroyMember'])->name('members.destroy');
        Route::get('/export/bukutamu', [AdminController::class, 'exportBukutamu'])->name('export.bukutamu');
    });
});

require __DIR__.'/auth.php';
