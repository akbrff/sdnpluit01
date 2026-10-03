<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KategoriBeritaRequest;
use App\Models\KategoriBerita;
use Illuminate\Support\Str;

class KategoriBeritaController extends Controller
{
    public function index()
    {
        $kategori = KategoriBerita::latest('id')->paginate(10);
        return view('admin.kategori-berita.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori-berita.create');
    }

    public function store(KategoriBeritaRequest $request)
    {
        KategoriBerita::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
        ]);

        return redirect()->route('admin.kategori-berita.index')->with('sukses', 'Kategori berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        return view('admin.kategori-berita.edit', compact('kategori'));
    }

    public function update(KategoriBeritaRequest $request, $id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        $kategori->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
        ]);

        return redirect()->route('admin.kategori-berita.index')->with('sukses', 'Kategori berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        $kategori->berita()->detach();
        $kategori->delete();

        return redirect()->route('admin.kategori-berita.index')->with('sukses', 'Kategori berita berhasil dihapus.');
    }
}