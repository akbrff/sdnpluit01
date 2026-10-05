<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GaleriRequest;
use App\Models\FotoGaleri;
use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::with('foto')
            ->latest('dibuat_pada')
            ->paginate(10);

        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(GaleriRequest $request)
    {
        $galeri = Galeri::create([
            'judul' => $request->judul,
            'slug' => $this->buatSlugUnik($request->judul),
            'deskripsi' => $request->deskripsi,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'aktif' => $request->aktif,
        ]);

        foreach ($request->file('foto') as $index => $file) {
            $path = $file->store('galeri', 'public');

            FotoGaleri::create([
                'id_galeri' => $galeri->id,
                'lokasi_gambar' => $path,
                'keterangan' => $request->judul . ' ' . ($index + 1),
                'urutan' => $index + 1,
            ]);
        }

        return redirect()
            ->route('admin.galeri.index')
            ->with(
                'sukses',
                'Album galeri berhasil dibuat beserta fotonya.'
            );
    }

    public function edit(Galeri $galeri)
    {
        $galeri->load('foto');

        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(
        GaleriRequest $request,
        Galeri $galeri
    ) {
        $galeri->update([
            'judul' => $request->judul,

            'slug' => $this->buatSlugUnik(
                $request->judul,
                $galeri->id
            ),

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
                    'keterangan' => $request->judul . ' ' .
                        ($lastUrutan + $index + 1),
                    'urutan' => $lastUrutan + $index + 1,
                ]);
            }
        }

        return redirect()
            ->route('admin.galeri.index')
            ->with(
                'sukses',
                'Album galeri berhasil diperbarui.'
            );
    }

    public function destroy(Galeri $galeri)
    {
        $galeri->load('foto');

        foreach ($galeri->foto as $foto) {
            if (
                Storage::disk('public')
                    ->exists($foto->lokasi_gambar)
            ) {
                Storage::disk('public')
                    ->delete($foto->lokasi_gambar);
            }
        }

        $galeri->delete();

        return redirect()
            ->route('admin.galeri.index')
            ->with(
                'sukses',
                'Album galeri dan seluruh foto berhasil dihapus.'
            );
    }

    public function destroyFoto(FotoGaleri $foto)
    {
        if (
            Storage::disk('public')
                ->exists($foto->lokasi_gambar)
        ) {
            Storage::disk('public')
                ->delete($foto->lokasi_gambar);
        }

        $foto->delete();

        return back()
            ->with(
                'sukses',
                'Foto berhasil dihapus dari album.'
            );
    }

    private function buatSlugUnik(
        string $judul,
        ?int $id = null
    ): string {
        $slugDasar = Str::slug($judul);
        $slug = $slugDasar;
        $nomor = 1;

        while (
            Galeri::where('slug', $slug)
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