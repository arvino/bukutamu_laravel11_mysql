<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BukutamuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [BukutamuController::class, 'index'])->name('home');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Member routes
    Route::middleware(['auth', 'verified'])->group(function () {
        // Bukutamu routes - Perhatikan urutan
        Route::get('/bukutamu/create', [BukutamuController::class, 'create'])->name('bukutamu.create');
        Route::post('/bukutamu', [BukutamuController::class, 'store'])->name('bukutamu.store');
        Route::get('/bukutamu/{bukutamu}/edit', [BukutamuController::class, 'edit'])->name('bukutamu.edit');
        Route::put('/bukutamu/{bukutamu}', [BukutamuController::class, 'update'])->name('bukutamu.update');
        Route::delete('/bukutamu/{bukutamu}', [BukutamuController::class, 'destroy'])->name('bukutamu.destroy');
        
        // Profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
    
    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/members', [AdminController::class, 'members'])->name('members.index');
        Route::get('/members/{member}/edit', [AdminController::class, 'editMember'])->name('members.edit');
        Route::put('/members/{member}', [AdminController::class, 'updateMember'])->name('members.update');
        Route::delete('/members/{member}', [AdminController::class, 'destroyMember'])->name('members.destroy');
        Route::get('/export/bukutamu', [AdminController::class, 'exportBukutamu'])->name('export.bukutamu');
    });
});

// Public bukutamu route - Pindahkan ke bawah setelah route create
Route::get('/bukutamu/{bukutamu}', [BukutamuController::class, 'show'])->name('bukutamu.show');

// Development routes
if (app()->environment('local')) {
    Route::get('/dev/verify/{id}', function ($id) {
        $user = \App\Models\Member::findOrFail($id);
        $user->markEmailAsVerified();
        return redirect()->route('home')
            ->with('success', 'Email berhasil diverifikasi!');
    })->name('dev.verify');
}

require __DIR__.'/auth.php';
