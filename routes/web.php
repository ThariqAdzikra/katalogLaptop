<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\StokController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Pembelian\PembelianController;

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Stok Management Routes
    // !!! PERUBAHAN 2: Tambahkan ->except(['show']) !!!
    // Ini mendaftarkan semua rute (index, create, edit, dll) KECUALI 'show'
    // karena 'show' sudah kita daftarkan di luar grup auth.
    Route::resource('stok', StokController::class)->parameters([
        'stok' => 'stok'
    ])->except(['show']); //
    
    // Additional route for updating stock quantity only
    Route::patch('/stok/{stok}/update-stok', [StokController::class, 'updateStok'])->name('stok.update-stok');
    
    // Rute Pembelian juga butuh login
    Route::resource('pembelian', PembelianController::class);
});

// !!! PERUBAHAN 1: Rute 'show' kita buat PUBLIK di sini !!!
// Rute ini menangani halaman detail produk (stok.show)
Route::get('stok/{stok}', [StokController::class, 'show'])->name('stok.show');

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

// Saya pindahkan rute pembelian ke dalam grup 'auth' utama di atas
// agar lebih rapi dan aman.
/*
Route::middleware(['auth', 'verified'])->group(function() {
    Route::resource('pembelian', PembelianController::class);
});
*/

require __DIR__ . '/auth.php';

// Hapus '}' ekstra jika ada di file Anda
// } // <-- Baris ini sepertinya salah ketik di file yang Anda kirim