<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilSekolah;
use App\Models\BeritaPengumuman;
use App\Models\Galeri;

class BerandaController extends Controller
{
    public function index()
    {
        // Memanggil data single-row profil sekolah
        // Menggunakan method current() sesuai instruksi di panduan
        $profil = ProfilSekolah::current(); 

        // Memanggil 3 berita terbaru yang statusnya 'terbit'
        $berita_terbaru = BeritaPengumuman::where('status', 'terbit')
                            ->orderBy('diterbitkan_pada', 'desc')
                            ->take(3)
                            ->get();

        // Memanggil 4 galeri album terbaru yang aktif
        $galeri_pilihan = Galeri::where('aktif', true)
                            ->orderBy('dibuat_pada', 'desc')
                            ->take(4)
                            ->get();

        // Mengirim data ke tampilan (view) beranda
        return view('beranda', compact('profil', 'berita_terbaru', 'galeri_pilihan'));
    }
}