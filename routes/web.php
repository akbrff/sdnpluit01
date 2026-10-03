<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaPublicController;
use App\Http\Controllers\GaleriPublicController;
use App\Http\Controllers\StrukturOrganisasiPublicController;
use App\Http\Controllers\Admin\KategoriBeritaController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;

// --- ROUTE PUBLIK (@extends('layouts.public')) ---
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/berita', [BeritaPublicController::class, 'index'])->name('berita.public');
Route::get('/berita/{beritaPengumuman:slug}', [BeritaPublicController::class, 'show'])->name('berita.detail.public');
Route::get('/galeri', [GaleriPublicController::class, 'index'])->name('galeri.public');
Route::get('/galeri/{galeri:slug}', [GaleriPublicController::class, 'show'])->name('galeri.detail.public');
Route::get('/profil/struktur-organisasi', [StrukturOrganisasiPublicController::class, 'index'])->name('struktur-organisasi.public');

// --- ROUTE DASHBOARD (Pengalihan Setelah Login) ---
Route::get('/dashboard', function () {
    return redirect()->route('admin.kategori-berita.index');
})->middleware(['auth'])->name('dashboard');

// --- ROUTE ADMIN (<x-app-layout>) ---
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('kategori-berita', KategoriBeritaController::class)->except(['show']);
    Route::resource('berita', BeritaController::class);
    Route::resource('galeri', GaleriController::class);
    Route::delete('galeri/foto/{id}', [GaleriController::class, 'destroyFoto'])->name('galeri.foto.destroy');
    
    // Modul Struktur Organisasi (Modul Acuan Febian)
    Route::resource('struktur-organisasi', StrukturOrganisasiController::class)->except(['show']);
});

// --- ROUTE AUTENTIKASI ---
require __DIR__.'/auth.php';