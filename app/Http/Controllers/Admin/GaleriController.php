<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GaleriRequest;
use App\Models\FotoGaleri;
use App\Models\Galeri;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

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
        $validated = $request->validated();
        $fotoBaru = [];

        try {
            /*
             * Simpan semua file terlebih dahulu.
             * Jika salah satu gagal, file yang sudah tersimpan
             * akan dibersihkan pada catch.
             */
            foreach ($request->file('foto') as $file) {
                $path = $file->store('galeri', 'public');

                if (! $path) {
                    throw new RuntimeException(
                        'Gagal menyimpan file galeri.'
                    );
                }

                $fotoBaru[] = $path;
            }

            DB::transaction(function () use ($validated, $fotoBaru) {
                $galeri = Galeri::create([
                    'judul' => $validated['judul'],
                    'slug' => $this->buatSlugUnik(
                        $validated['judul']
                    ),
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'tanggal_kegiatan' =>
                        $validated['tanggal_kegiatan'],
                    'aktif' => $validated['aktif'],
                ]);

                foreach ($fotoBaru as $index => $path) {
                    FotoGaleri::create([
                        'id_galeri' => $galeri->id,
                        'lokasi_gambar' => $path,
                        'keterangan' =>
                            $validated['judul'] . ' ' . ($index + 1),
                        'urutan' => $index + 1,
                    ]);
                }
            });
        } catch (Throwable $e) {
            foreach ($fotoBaru as $path) {
                Storage::disk('public')->delete($path);
            }

            report($e);

            return back()
                ->withInput()
                ->with(
                    'gagal',
                    'Album galeri gagal dibuat. Silakan coba kembali.'
                );
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
        $validated = $request->validated();
        $fotoBaru = [];

        try {
            /*
             * Upload foto tambahan terlebih dahulu.
             * Foto lama tidak disentuh.
             */
            if ($request->hasFile('foto')) {
                foreach ($request->file('foto') as $file) {
                    $path = $file->store('galeri', 'public');

                    if (! $path) {
                        throw new RuntimeException(
                            'Gagal menyimpan file galeri.'
                        );
                    }

                    $fotoBaru[] = $path;
                }
            }

            DB::transaction(function () use (
                $validated,
                $galeri,
                $fotoBaru
            ) {
                $galeri->update([
                    'judul' => $validated['judul'],
                    'slug' => $this->buatSlugUnik(
                        $validated['judul'],
                        $galeri->id
                    ),
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'tanggal_kegiatan' =>
                        $validated['tanggal_kegiatan'],
                    'aktif' => $validated['aktif'],
                ]);

                if ($fotoBaru) {
                    $lastUrutan =
                        $galeri->foto()->max('urutan') ?? 0;

                    foreach ($fotoBaru as $index => $path) {
                        FotoGaleri::create([
                            'id_galeri' => $galeri->id,
                            'lokasi_gambar' => $path,
                            'keterangan' =>
                                $validated['judul'] . ' ' .
                                ($lastUrutan + $index + 1),
                            'urutan' =>
                                $lastUrutan + $index + 1,
                        ]);
                    }
                }
            });
        } catch (Throwable $e) {
            /*
             * Jika upload berhasil tetapi database gagal,
             * hapus semua file baru.
             * Foto lama tetap aman.
             */
            foreach ($fotoBaru as $path) {
                Storage::disk('public')->delete($path);
            }

            report($e);

            return back()
                ->withInput()
                ->with(
                    'gagal',
                    'Album galeri gagal diperbarui. Silakan coba kembali.'
                );
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

        $daftarFoto = $galeri->foto
            ->pluck('lokasi_gambar')
            ->filter()
            ->values()
            ->all();

        try {
            /*
             * Hapus database terlebih dahulu.
             * FK cascade akan menghapus record foto_galeri.
             */
            DB::transaction(function () use ($galeri) {
                $galeri->delete();
            });
        } catch (Throwable $e) {
            report($e);

            return back()->with(
                'gagal',
                'Album galeri gagal dihapus. Silakan coba kembali.'
            );
        }

        /*
         * File fisik baru dibersihkan setelah database sukses.
         */
        $fileGagalDihapus = false;

        foreach ($daftarFoto as $path) {
            if (
                Storage::disk('public')->exists($path) &&
                ! Storage::disk('public')->delete($path)
            ) {
                $fileGagalDihapus = true;
            }
        }

        if ($fileGagalDihapus) {
            return redirect()
                ->route('admin.galeri.index')
                ->with(
                    'sukses',
                    'Album berhasil dihapus, tetapi ada file foto yang gagal dibersihkan.'
                );
        }

        return redirect()
            ->route('admin.galeri.index')
            ->with(
                'sukses',
                'Album galeri dan seluruh foto berhasil dihapus.'
            );
    }

    public function destroyFoto(FotoGaleri $foto)
    {
        $path = $foto->lokasi_gambar;

        try {
            /*
             * Hapus record database terlebih dahulu.
             */
            DB::transaction(function () use ($foto) {
                $foto->delete();
            });
        } catch (Throwable $e) {
            report($e);

            return back()->with(
                'gagal',
                'Foto gagal dihapus dari album. Silakan coba kembali.'
            );
        }

        /*
         * Setelah database sukses, baru bersihkan file.
         */
        if (
            $path &&
            Storage::disk('public')->exists($path) &&
            ! Storage::disk('public')->delete($path)
        ) {
            return back()->with(
                'sukses',
                'Foto berhasil dihapus dari album, tetapi file fisik gagal dibersihkan.'
            );
        }

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
