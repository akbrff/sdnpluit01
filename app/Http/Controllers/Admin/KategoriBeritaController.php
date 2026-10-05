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
            'slug' => $this->buatSlugUnik($request->nama),
        ]);

        return redirect()
            ->route('admin.kategori-berita.index')
            ->with('sukses', 'Kategori berita berhasil ditambahkan.');
    }

    public function edit(KategoriBerita $kategori_berita)
    {
        return view('admin.kategori-berita.edit', [
            'kategori' => $kategori_berita,
        ]);
    }

    public function update(
        KategoriBeritaRequest $request,
        KategoriBerita $kategori_berita
    ) {
        $kategori_berita->update([
            'nama' => $request->nama,
            'slug' => $this->buatSlugUnik(
                $request->nama,
                $kategori_berita->id
            ),
        ]);

        return redirect()
            ->route('admin.kategori-berita.index')
            ->with('sukses', 'Kategori berita berhasil diperbarui.');
    }

    public function destroy(KategoriBerita $kategori_berita)
    {
        $kategori_berita->berita()->detach();
        $kategori_berita->delete();

        return redirect()
            ->route('admin.kategori-berita.index')
            ->with('sukses', 'Kategori berita berhasil dihapus.');
    }

    private function buatSlugUnik(string $nama, ?int $id = null): string
    {
        $slugDasar = Str::slug($nama);
        $slug = $slugDasar;
        $nomor = 1;

        while (
            KategoriBerita::where('slug', $slug)
                ->when($id, function ($query) use ($id) {
                    $query->where('id', '!=', $id);
                })
                ->exists()
        ) {
            $slug = $slugDasar . '-' . $nomor;
            $nomor++;
        }

        return $slug;
    }
}