<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriBeritaController extends Controller
{
    public function index()
    {
        $kategori = KategoriBerita::latest('id')->paginate(10);
        return view('admin.kategori_berita.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori_berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_berita,nama',
        ]);

        KategoriBerita::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
        ]);

        return redirect()->route('admin.kategori-berita.index')
            ->with('sukses', 'Kategori berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        return view('admin.kategori_berita.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriBerita::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_berita,nama,' . $id,
        ]);

        $kategori->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
        ]);

        return redirect()->route('admin.kategori-berita.index')
            ->with('sukses', 'Kategori berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        
        // Lepas relasi pivot berita_kategori sebelum dihapus
        $kategori->berita()->detach();
        $kategori->delete();

        return redirect()->route('admin.kategori-berita.index')
            ->with('sukses', 'Kategori berita berhasil dihapus.');
    }
}