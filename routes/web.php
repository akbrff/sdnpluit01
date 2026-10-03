<?php

use Illuminate\Support\Facades\Route;

// --- Controller Publik ---
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StrukturOrganisasiPublicController;
use App\Http\Controllers\KurikulumPublicController;

// --- Controller Admin ---
use App\Http\Controllers\Admin\StrukturOrganisasiController as AdminStrukturOrganisasiController;
use App\Http\Controllers\Admin\KurikulumController as AdminKurikulumController;
use App\Http\Controllers\Admin\ProfilStatistikController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE PUBLIK (Siswa & Pengunjung) ---
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/profil/struktur-organisasi', [StrukturOrganisasiPublicController::class, 'index'])->name('struktur-organisasi.public');
Route::get('/akademik/kurikulum', [KurikulumPublicController::class, 'index'])->name('kurikulum.index');

// --- RUTE BAWAAN LARAVEL BREEZE (WAJIB ADA) ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- RUTE ADMIN (MEMERLUKAN LOGIN) ---
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Struktur Organisasi
    Route::resource('struktur-organisasi', AdminStrukturOrganisasiController::class)->except(['show']);
    
    // Admin Kurikulum
    Route::resource('kurikulum', AdminKurikulumController::class)->except(['show']);
    
    // Admin Profil & Statistik
    Route::get('/profil-statistik', [ProfilStatistikController::class, 'edit'])->name('profil-statistik.edit');
    Route::put('/profil-statistik', [ProfilStatistikController::class, 'update'])->name('profil-statistik.update');
});

// Rute Autentikasi (Login, Register, Logout, dll.)
require __DIR__.'/auth.php';