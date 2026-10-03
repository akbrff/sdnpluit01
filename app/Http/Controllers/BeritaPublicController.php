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

        if ($request->has('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        $berita = $query->paginate(9);
        $kategori = KategoriBerita::all();

        return view('berita.index', compact('berita', 'kategori'));
    }

    public function show(BeritaPengumuman $beritaPengumuman)
    {
        if ($beritaPengumuman->status !== 'terbit') {
            abort(404);
        }

        $beritaPengumuman->load('kategori');
        $beritaTerkait = BeritaPengumuman::where('status', 'terbit')
            ->where('id', '!=', $beritaPengumuman->id)
            ->latest('diterbitkan_pada')
            ->take(3)
            ->get();

        return view('berita.show', compact('beritaPengumuman', 'beritaTerkait'));
    }
}