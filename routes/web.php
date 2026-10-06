<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\StrukturOrganisasiPublicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProfilStatistikController;


// Ubah rute utama ('/') agar mengarah ke BerandaController
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::get('/profil/struktur-organisasi', [StrukturOrganisasiPublicController::class, 'index'])
    ->name('struktur-organisasi.public');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('admin/struktur-organisasi', StrukturOrganisasiController::class)
    ->names('admin.struktur-organisasi')
    ->except(['show']); // halaman "show" tunggal tidak dipakai, cukup index/create/edit
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // ... (route modul lain)
    
    // Route Profil & Statistik (Hanya edit & update)
    Route::get('/profil-statistik', [ProfilStatistikController::class, 'edit'])->name('profil-statistik.edit');
    Route::put('/profil-statistik', [ProfilStatistikController::class, 'update'])->name('profil-statistik.update');
});

require __DIR__.'/auth.php';