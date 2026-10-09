<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KategoriBeritaRequest;
use App\Models\KategoriBerita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

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
        $validated = $request->validated();

        try {
            KategoriBerita::create([
                'nama' => $validated['nama'],
                'slug' => $this->buatSlugUnik($validated['nama']),
            ]);
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with(
                    'gagal',
                    'Kategori berita gagal ditambahkan. Silakan coba kembali.'
                );
        }

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
        $validated = $request->validated();

        try {
            $kategori_berita->update([
                'nama' => $validated['nama'],
                'slug' => $this->buatSlugUnik(
                    $validated['nama'],
                    $kategori_berita->id
                ),
            ]);
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with(
                    'gagal',
                    'Kategori berita gagal diperbarui. Silakan coba kembali.'
                );
        }

        return redirect()
            ->route('admin.kategori-berita.index')
            ->with('sukses', 'Kategori berita berhasil diperbarui.');
    }

    public function destroy(KategoriBerita $kategori_berita)
    {
        try {
            DB::transaction(function () use ($kategori_berita) {
                /*
                 * Detach menjaga relasi pivot tetap bersih.
                 * Database juga sudah memiliki cascadeOnDelete.
                 */
                $kategori_berita->berita()->detach();
                $kategori_berita->delete();
            });
        } catch (Throwable $e) {
            report($e);

            return back()->with(
                'gagal',
                'Kategori berita gagal dihapus. Silakan coba kembali.'
            );
        }

        return redirect()
            ->route('admin.kategori-berita.index')
            ->with('sukses', 'Kategori berita berhasil dihapus.');
    }

    private function buatSlugUnik(
        string $nama,
        ?int $id = null
    ): string {
        $slugDasar = Str::slug($nama);

        $slug = $slugDasar;
        $nomor = 1;

        while (
            KategoriBerita::where('slug', $slug)
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