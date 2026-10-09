<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaPublicController;
use App\Http\Controllers\GaleriPublicController;
use App\Http\Controllers\StrukturOrganisasiPublicController;
use App\Http\Controllers\KurikulumPublicController;

use App\Http\Controllers\Admin\ProfilStatistikController;
use App\Http\Controllers\Admin\KategoriBeritaController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\Admin\KurikulumController as AdminKurikulumController;


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


Route::get(
    '/akademik/kurikulum',
    [KurikulumPublicController::class, 'index']
)->name('kurikulum.public');


// =========================
// DASHBOARD
// =========================

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth'])
    ->name('dashboard');


// =========================
// PROFILE
// =========================

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');
});


// =========================
// ROUTE ADMIN
// =========================

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // =========================
        // PROFIL & STATISTIK
        // =========================

        Route::get(
            '/profil-statistik',
            [ProfilStatistikController::class, 'edit']
        )->name('profil-statistik.edit');

        Route::put(
            '/profil-statistik',
            [ProfilStatistikController::class, 'update']
        )->name('profil-statistik.update');


        // =========================
        // KURIKULUM
        // =========================

        Route::resource(
            'kurikulum',
            AdminKurikulumController::class
        )->except(['show']);


        // =========================
        // KATEGORI BERITA
        // =========================

        Route::resource(
            'kategori-berita',
            KategoriBeritaController::class
        )
            ->parameters([
                'kategori-berita' => 'kategori_berita',
            ])
            ->except(['show']);


        // =========================
        // BERITA
        // =========================

        Route::resource(
            'berita',
            BeritaController::class
        )
            ->parameters([
                'berita' => 'berita',
            ])
            ->except(['show']);


        // =========================
        // GALERI
        // =========================

        Route::delete(
            'galeri/foto/{foto}',
            [GaleriController::class, 'destroyFoto']
        )->name('galeri.foto.destroy');


        Route::resource(
            'galeri',
            GaleriController::class
        )->except(['show']);


        // =========================
        // STRUKTUR ORGANISASI
        // =========================

        Route::resource(
            'struktur-organisasi',
            StrukturOrganisasiController::class
        )->except(['show']);
    });


// =========================
// ROUTE AUTH
// =========================

require __DIR__ . '/auth.php';