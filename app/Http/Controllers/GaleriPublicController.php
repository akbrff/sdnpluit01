<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

class GaleriPublicController extends Controller
{
    public function index()
    {
        $galeri = Galeri::with('foto')
            ->where('aktif', true)
            ->latest('tanggal_kegiatan')
            ->paginate(9);

        return view('galeri.index', [
            'galeri' => $galeri,
        ]);
    }

    public function show(Galeri $galeri)
    {
        if (! $galeri->aktif) {
            abort(404);
        }

        $galeri->load('foto');

        return view('galeri.show', [
            'galeri' => $galeri,
        ]);
    }
}