<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeritaRequest;
use App\Models\BeritaPengumuman;
use App\Models\KategoriBerita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = BeritaPengumuman::with('kategori')->latest('dibuat_pada')->paginate(10);
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        $kategori = KategoriBerita::all();
        return view('admin.berita.create', compact('kategori'));
    }

    public function store(BeritaRequest $request)
    {
        $path = $request->file('gambar_sampul')->store('berita', 'public');

        $berita = BeritaPengumuman::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'isi' => $request->isi,
            'gambar_sampul' => $path,
            'status' => $request->status,
            'diterbitkan_pada' => $request->status === 'terbit' ? now() : null,
        ]);

        $berita->kategori()->attach($request->kategori);

        return redirect()->route('admin.berita.index')->with('sukses', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $berita = BeritaPengumuman::with('kategori')->findOrFail($id);
        $kategori = KategoriBerita::all();
        return view('admin.berita.edit', compact('berita', 'kategori'));
    }

    public function update(BeritaRequest $request, $id)
    {
        $berita = BeritaPengumuman::findOrFail($id);

        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'isi' => $request->isi,
            'status' => $request->status,
        ];

        if ($request->status === 'terbit' && !$berita->diterbitkan_pada) {
            $data['diterbitkan_pada'] = now();
        }

        if ($request->hasFile('gambar_sampul')) {
            if ($berita->gambar_sampul && Storage::disk('public')->exists($berita->gambar_sampul)) {
                Storage::disk('public')->delete($berita->gambar_sampul);
            }
            $data['gambar_sampul'] = $request->file('gambar_sampul')->store('berita', 'public');
        }

        $berita->update($data);
        $berita->kategori()->sync($request->kategori);

        return redirect()->route('admin.berita.index')->with('sukses', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $berita = BeritaPengumuman::findOrFail($id);

        if ($berita->gambar_sampul && Storage::disk('public')->exists($berita->gambar_sampul)) {
            Storage::disk('public')->delete($berita->gambar_sampul);
        }

        $berita->kategori()->detach();
        $berita->delete();

        return redirect()->route('admin.berita.index')->with('sukses', 'Berita berhasil dihapus.');
    }
}