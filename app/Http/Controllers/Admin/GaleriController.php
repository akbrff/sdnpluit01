<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\FotoGaleri;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::with('foto')->latest('dibuat_pada')->paginate(10);
        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_kegiatan' => 'required|date',
            'aktif' => 'required|boolean',
            'foto' => 'required|array',
            'foto.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $galeri = Galeri::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'aktif' => $request->aktif,
        ]);

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $index => $file) {
                $path = $file->store('galeri', 'public');
                FotoGaleri::create([
                    'id_galeri' => $galeri->id,
                    'lokasi_gambar' => $path,
                    'keterangan' => $request->judul . ' ' . ($index + 1),
                    'urutan' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.galeri.index')
            ->with('sukses', 'Album galeri berhasil dibuat beserta fotonya.');
    }

    public function edit($id)
    {
        $galeri = Galeri::with('foto')->findOrFail($id);
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_kegiatan' => 'required|date',
            'aktif' => 'required|boolean',
            'foto.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $galeri->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'aktif' => $request->aktif,
        ]);

        if ($request->hasFile('foto')) {
            $lastUrutan = $galeri->foto()->max('urutan') ?? 0;
            foreach ($request->file('foto') as $index => $file) {
                $path = $file->store('galeri', 'public');
                FotoGaleri::create([
                    'id_galeri' => $galeri->id,
                    'lokasi_gambar' => $path,
                    'keterangan' => $request->judul,
                    'urutan' => $lastUrutan + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.galeri.index')
            ->with('sukses', 'Album galeri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $galeri = Galeri::with('foto')->findOrFail($id);

        foreach ($galeri->foto as $foto) {
            if (Storage::disk('public')->exists($foto->lokasi_gambar)) {
                Storage::disk('public')->delete($foto->lokasi_gambar);
            }
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')
            ->with('sukses', 'Album galeri dan seluruh foto berhasil dihapus.');
    }

    public function destroyFoto($id)
    {
        $foto = FotoGaleri::findOrFail($id);

        if (Storage::disk('public')->exists($foto->lokasi_gambar)) {
            Storage::disk('public')->delete($foto->lokasi_gambar);
        }

        $foto->delete();

        return back()->with('sukses', 'Foto berhasil dihapus dari album.');
    }
}