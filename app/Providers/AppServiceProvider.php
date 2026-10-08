<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\ProfilSekolah;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Supaya nama sekolah, alamat, email, dsb. otomatis tersedia sebagai
        // $profilLayout di navbar/footer SETIAP halaman publik, tanpa tiap
        // controller (Profil, Akademik, Fasilitas, dst.) harus query ulang
        // ProfilSekolah::current() cuma untuk layout.
        View::composer('layouts.public', function ($view) {
            $view->with('profilLayout', ProfilSekolah::current());
        });
    }
}
