<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BerandaController;

// --- Controller Publik ---
use App\Http\Controllers\StrukturOrganisasiPublicController;
use App\Http\Controllers\KurikulumPublicController;

// --- Controller Admin ---
use App\Http\Controllers\Admin\StrukturOrganisasiController as AdminStrukturOrganisasiController;
use App\Http\Controllers\Admin\KurikulumController as AdminKurikulumController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Beranda
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Rute Publik (Siswa & Pengunjung)
Route::get('/profil/struktur-organisasi', [StrukturOrganisasiPublicController::class, 'index'])->name('struktur-organisasi.public');
Route::get('/akademik/kurikulum', [KurikulumPublicController::class, 'index'])->name('kurikulum.public');

// Rute Admin (Memerlukan Login)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('struktur-organisasi', AdminStrukturOrganisasiController::class)->names('admin.struktur-organisasi')->except(['show']);
    Route::resource('kurikulum', AdminKurikulumController::class)->names('admin.kurikulum')->except(['show']);
});

// ==========================================
// RUTE BAWAAN LARAVEL BREEZE (WAJIB ADA)
// ==========================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Baris ini yang memuat rute /login, /register, dan lainnya
require __DIR__.'/auth.php';