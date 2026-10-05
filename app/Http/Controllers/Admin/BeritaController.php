<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeritaRequest;
use App\Models\BeritaPengumuman;
use App\Models\KategoriBerita;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = BeritaPengumuman::with('kategori')
            ->latest('dibuat_pada')
            ->paginate(10);

        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        $kategori = KategoriBerita::orderBy('nama')->get();

        return view('admin.berita.create', compact('kategori'));
    }

    public function store(BeritaRequest $request)
    {
        $gambar_sampul = $request
            ->file('gambar_sampul')
            ->store('berita', 'public');

        $berita = BeritaPengumuman::create([
            'judul' => $request->judul,
            'slug' => $this->buatSlugUnik($request->judul),
            'isi' => $request->isi,
            'gambar_sampul' => $gambar_sampul,
            'status' => $request->status,
            'diterbitkan_pada' => $request->status === 'terbit'
                ? now()
                : null,
        ]);

        $berita->kategori()->attach($request->kategori);

        return redirect()
            ->route('admin.berita.index')
            ->with('sukses', 'Berita berhasil ditambahkan.');
    }

    public function edit(BeritaPengumuman $berita)
    {
        $berita->load('kategori');

        $kategori = KategoriBerita::orderBy('nama')->get();

        return view('admin.berita.edit', compact(
            'berita',
            'kategori'
        ));
    }

    public function update(
        BeritaRequest $request,
        BeritaPengumuman $berita
    ) {
        $data = [
            'judul' => $request->judul,

            'slug' => $this->buatSlugUnik(
                $request->judul,
                $berita->id
            ),

            'isi' => $request->isi,
            'status' => $request->status,
        ];

        if ($request->status === 'terbit') {
            $data['diterbitkan_pada'] =
                $berita->diterbitkan_pada ?? now();
        } else {
            $data['diterbitkan_pada'] = null;
        }

        if ($request->hasFile('gambar_sampul')) {

            if (
                $berita->gambar_sampul &&
                Storage::disk('public')->exists(
                    $berita->gambar_sampul
                )
            ) {
                Storage::disk('public')->delete(
                    $berita->gambar_sampul
                );
            }

            $data['gambar_sampul'] = $request
                ->file('gambar_sampul')
                ->store('berita', 'public');
        }

        $berita->update($data);

        $berita->kategori()->sync(
            $request->kategori
        );

        return redirect()
            ->route('admin.berita.index')
            ->with('sukses', 'Berita berhasil diperbarui.');
    }

    public function destroy(BeritaPengumuman $berita)
    {
        if (
            $berita->gambar_sampul &&
            Storage::disk('public')->exists(
                $berita->gambar_sampul
            )
        ) {
            Storage::disk('public')->delete(
                $berita->gambar_sampul
            );
        }

        $berita->kategori()->detach();

        $berita->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('sukses', 'Berita berhasil dihapus.');
    }

    private function buatSlugUnik(
        string $judul,
        ?int $id = null
    ): string {
        $slugDasar = Str::slug($judul);

        $slug = $slugDasar;
        $nomor = 1;

        while (
            BeritaPengumuman::where('slug', $slug)
                ->when(
                    $id !== null,
                    function ($query) use ($id) {
                        $query->where('id', '!=', $id);
                    }
                )
                ->exists()
        ) {
            $slug = $slugDasar . '-' . $nomor;
            $nomor++;
        }

        return $slug;
    }
}