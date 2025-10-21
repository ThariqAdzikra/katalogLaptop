<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KatalogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\DashboardController;
use Illuminate\Support\Facades\Auth;

// Public Routes
Route::get('/', [KatalogController::class, 'index'])->name('home');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');

// Authenticated Routes
// --- PERUBAHAN DI SINI ---
// Rute ini sekarang bertindak sebagai router pasca-login berdasarkan peran
Route::get('/dashboard', function () {
    $user = Auth::user();

    // Asumsi Anda memiliki kolom 'role' di tabel users
    if ($user->role == 'superadmin') {
        return redirect()->route('superadmin.dashboard');
    }
    
    // Jika rolenya 'pegawai' atau peran lain selain superadmin
    if ($user->role == 'pegawai') {
        return redirect()->route('katalog.index');
    }

    // Fallback default jika peran tidak terdefinisi
    return redirect()->route('katalog.index');

})->middleware(['auth', 'verified'])->name('dashboard');
// --- AKHIR PERUBAHAN ---

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/superadmin/dashboard', [DashboardController::class, 'index'])
    ->name('superadmin.dashboard');
});

Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});


require __DIR__ . '/auth.php';