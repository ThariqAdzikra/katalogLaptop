<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\StokController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Pembelian\PembelianController;
use App\Http\Controllers\Penjualan\PenjualanController;

// Public Routes
Route::get('/', [KatalogController::class, 'index'])->name('home');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');

// Authenticated Routes
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

Route::middleware('auth')->group(function () {
    
    // Rute Profil (SUDAH DISESUAIKAN)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Stok Management Routes
    Route::resource('stok', StokController::class)->parameters([
        'stok' => 'stok'
    ])->except(['show']);
    
    // Additional route for updating stock quantity only
    Route::patch('/stok/{stok}/update-stok', [StokController::class, 'updateStok'])->name('stok.update-stok');
    
    // Rute Pembelian juga butuh login
    Route::resource('pembelian', PembelianController::class);

    // Rute Penjualan juga butuh login
    Route::resource('penjualan', PenjualanController::class);

    // Rute Pelanggan juga butuh login
    Route::resource('pelanggan', \App\Http\Controllers\PelangganController::class)->except(['show']);

});

// Rute 'show' kita buat PUBLIK di sini
Route::get('stok/{stok}', [StokController::class, 'show'])->name('stok.show');

Route::get('/laporan-penjualan', [PenjualanController::class, 'laporan'])->name('penjualan.laporan');

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

// Catatan: Saya telah menghapus '}' ekstra dan duplikat kode 
// yang ada di file yang Anda unggah.