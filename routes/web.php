<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\StrukturOrganisasiPublicController;
use App\Http\Controllers\Admin\EkstrakurikulerController;
use App\Http\Controllers\EkstrakurikulerPublicController;
use Illuminate\Support\Facades\Route;

// Ubah rute utama ('/') agar mengarah ke BerandaController
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::get('/profil/struktur-organisasi', [StrukturOrganisasiPublicController::class, 'index'])
    ->name('struktur-organisasi.public');

// Rute Publik Ekstrakurikuler
Route::get('/akademik/ekstrakurikuler', [EkstrakurikulerPublicController::class, 'index'])
    ->name('ekstrakurikuler.public');

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

    // Rute Admin Ekstrakurikuler
    Route::resource('admin/ekstrakurikuler', EkstrakurikulerController::class)
        ->names('admin.ekstrakurikuler')
        ->except(['show']);
});

require __DIR__.'/auth.php';