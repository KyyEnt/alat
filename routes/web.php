<?php

use Illuminate\Support\Facades\Route;

// Import Middleware
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsPetugas;
use App\Http\Middleware\IsPeminjam;


// Import Controllers
use App\Http\Controllers\AdminPeminjamanController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PeminjamController;

// 1. PUBLIC ROUTE
Route::get('/', [PublicController::class, 'index'])->name('public.home');

// 2. DASHBOARD REDIRECTOR
Route::get('/dashboard', function () {
    $role = strtolower(auth()->user()->role->nama_role);

    if ($role === 'admin') {
        return redirect()->route('admin.index');
    } elseif ($role === 'petugas') {
        return redirect()->route('petugas.index');
    } elseif ($role === 'peminjam') {
        return redirect()->route('peminjam.index');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. PROFILE ROUTE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. FITUR KHUSUS ADMIN
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::resource('user', UserController::class)->except(['index']);
    Route::resource('kategori', KategoriController::class);
    Route::resource('alat', AlatController::class);
    
    // PEMINJAMAN KHUSUS ADMIN (Dipisah dari Petugas)
    Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{id}', [AdminPeminjamanController::class, 'show'])->name('peminjaman.show');

    Route::get('/log-aktifitas', function () {
        return view('admin.log.index');
    })->name('log.index');
});
// 5. FITUR KHUSUS PETUGAS
Route::middleware(['auth', IsPetugas::class])
    ->prefix('petugas')
    ->as('petugas.')
    ->group(function () {

        Route::get('/', [PetugasController::class, 'memantauPengembalian'])
            ->name('index');

        Route::get('/pemantauan', [PetugasController::class, 'memantauPengembalian'])
            ->name('pemantauan');

        Route::get('/persetujuan', [PetugasController::class, 'menyetujuiPeminjaman'])
            ->name('persetujuan');

        Route::patch('/persetujuan/{id}', [PetugasController::class, 'prosesPersetujuan'])
            ->name('persetujuan.proses');

        // DETAIL / LIHAT BERKAS PEMINJAMAN
        Route::get('/peminjaman/{id}', [PetugasController::class, 'showPeminjaman'])
            ->name('peminjaman.show');

        Route::get('/laporan/cetak', [PetugasController::class, 'cetakLaporan'])
            ->name('laporan.cetak');
    });
    
// 6. FITUR KHUSUS PEMINJAM
Route::middleware(['auth', IsPeminjam::class])->prefix('peminjam')->as('peminjam.')->group(function () {
    Route::get('/peminjaman', [PeminjamController::class, 'index'])->name('index');
    Route::get('/peminjaman/create', [PeminjamController::class, 'create'])->name('create');
    Route::post('/peminjaman', [PeminjamController::class, 'store'])->name('store');
    Route::get('/peminjaman/{id}', [PeminjamController::class, 'show'])->name('show');
    
    Route::get('/alat', [PeminjamController::class, 'daftarAlat'])->name('alat.index');
    Route::post('/pinjam', [PeminjamController::class, 'ajukanPeminjaman'])->name('pinjam.store');
    Route::post('/kembali/{id}', [PeminjamController::class, 'kembalikanAlat'])->name('kembali.update');
});

// 7. AUTHENTICATION ROUTE
require __DIR__.'/auth.php';