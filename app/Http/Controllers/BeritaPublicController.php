<?php

namespace App\Http\Controllers;

use App\Models\BeritaPengumuman;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;

class BeritaPublicController extends Controller
{
    public function index(Request $request)
    {
        $query = BeritaPengumuman::with('kategori')
            ->where('status', 'terbit')
            ->latest('diterbitkan_pada');

        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        $berita = $query
            ->paginate(9)
            ->withQueryString();

        $kategori = KategoriBerita::orderBy('nama')->get();

        return view('berita.index', [
            'berita' => $berita,
            'kategori' => $kategori,
        ]);
    }

    public function show(BeritaPengumuman $beritaPengumuman)
    {
        if ($beritaPengumuman->status !== 'terbit') {
            abort(404);
        }

        $beritaPengumuman->load('kategori');

        $beritaTerkait = BeritaPengumuman::with('kategori')
            ->where('status', 'terbit')
            ->where('id', '!=', $beritaPengumuman->id)
            ->latest('diterbitkan_pada')
            ->take(3)
            ->get();

        return view('berita.show', [
            'beritaPengumuman' => $beritaPengumuman,
            'beritaTerkait' => $beritaTerkait,
        ]);
    }
}