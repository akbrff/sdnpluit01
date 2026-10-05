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


// =========================
// ROUTE PUBLIC
// =========================

Route::get(
    '/',
    [BerandaController::class, 'index']
)->name('beranda');


Route::get(
    '/berita',
    [BeritaPublicController::class, 'index']
)->name('berita.public');


Route::get(
    '/berita/{beritaPengumuman:slug}',
    [BeritaPublicController::class, 'show']
)->name('berita.detail.public');


Route::get(
    '/galeri',
    [GaleriPublicController::class, 'index']
)->name('galeri.public');


Route::get(
    '/galeri/{galeri:slug}',
    [GaleriPublicController::class, 'show']
)->name('galeri.detail.public');


Route::get(
    '/profil/struktur-organisasi',
    [StrukturOrganisasiPublicController::class, 'index']
)->name('struktur-organisasi.public');


// =========================
// DASHBOARD
// =========================

Route::get('/dashboard', function () {
    return redirect()
        ->route('admin.kategori-berita.index');
})
    ->middleware(['auth'])
    ->name('dashboard');


// =========================
// ROUTE ADMIN
// =========================

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource(
            'kategori-berita',
            KategoriBeritaController::class
        )
            ->parameters([
                'kategori-berita' => 'kategori_berita',
            ])
            ->except(['show']);


        Route::resource(
            'berita',
            BeritaController::class
        )
            ->parameters([
                'berita' => 'berita',
            ])
            ->except(['show']);


        Route::delete(
            'galeri/foto/{foto}',
            [GaleriController::class, 'destroyFoto']
        )->name('galeri.foto.destroy');


        Route::resource(
            'galeri',
            GaleriController::class
        )->except(['show']);


        Route::resource(
            'struktur-organisasi',
            StrukturOrganisasiController::class
        )->except(['show']);
    });


// =========================
// ROUTE AUTH
// =========================

require __DIR__ . '/auth.php';