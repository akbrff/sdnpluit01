<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeritaRequest;
use App\Models\BeritaPengumuman;
use App\Models\KategoriBerita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

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
        $validated = $request->validated();
        $gambarBaru = null;

        try {
            $gambarBaru = $request
                ->file('gambar_sampul')
                ->store('berita', 'public');

            DB::transaction(function () use ($validated, $gambarBaru) {
                $berita = BeritaPengumuman::create([
                    'judul' => $validated['judul'],
                    'slug' => $this->buatSlugUnik($validated['judul']),
                    'isi' => $validated['isi'],
                    'gambar_sampul' => $gambarBaru,
                    'status' => $validated['status'],
                    'diterbitkan_pada' => $validated['status'] === 'terbit'
                        ? now()
                        : null,
                ]);

                $berita->kategori()->attach($validated['kategori']);
            });
        } catch (Throwable $e) {
            if ($gambarBaru) {
                Storage::disk('public')->delete($gambarBaru);
            }

            report($e);

            return back()
                ->withInput()
                ->with('gagal', 'Berita gagal ditambahkan. Silakan coba kembali.');
        }

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
        $validated = $request->validated();

        $gambarLama = $berita->gambar_sampul;
        $gambarBaru = null;

        try {
            /*
             * Simpan gambar baru terlebih dahulu.
             * Gambar lama belum dihapus agar tetap aman jika update gagal.
             */
            if ($request->hasFile('gambar_sampul')) {
                $gambarBaru = $request
                    ->file('gambar_sampul')
                    ->store('berita', 'public');
            }

            DB::transaction(function () use (
                $berita,
                $validated,
                $gambarBaru
            ) {
                $data = [
                    'judul' => $validated['judul'],
                    'slug' => $this->buatSlugUnik(
                        $validated['judul'],
                        $berita->id
                    ),
                    'isi' => $validated['isi'],
                    'status' => $validated['status'],
                ];

                if ($validated['status'] === 'terbit') {
                    $data['diterbitkan_pada'] =
                        $berita->diterbitkan_pada ?? now();
                } else {
                    $data['diterbitkan_pada'] = null;
                }

                if ($gambarBaru) {
                    $data['gambar_sampul'] = $gambarBaru;
                }

                $berita->update($data);

                $berita->kategori()->sync(
                    $validated['kategori']
                );
            });
        } catch (Throwable $e) {
            /*
             * Jika upload baru berhasil tetapi database gagal,
             * hapus file baru agar tidak menjadi file yatim.
             */
            if ($gambarBaru) {
                Storage::disk('public')->delete($gambarBaru);
            }

            report($e);

            return back()
                ->withInput()
                ->with('gagal', 'Berita gagal diperbarui. Silakan coba kembali.');
        }

        /*
         * Gambar lama baru dibersihkan setelah database
         * berhasil diperbarui.
         */
        if (
            $gambarBaru &&
            $gambarLama &&
            Storage::disk('public')->exists($gambarLama)
        ) {
            $berhasilDihapus =
                Storage::disk('public')->delete($gambarLama);

            if (! $berhasilDihapus) {
                return redirect()
                    ->route('admin.berita.index')
                    ->with(
                        'sukses',
                        'Berita berhasil diperbarui, tetapi file sampul lama gagal dibersihkan.'
                    );
            }
        }

        return redirect()
            ->route('admin.berita.index')
            ->with('sukses', 'Berita berhasil diperbarui.');
    }

    public function destroy(BeritaPengumuman $berita)
    {
        $gambarLama = $berita->gambar_sampul;

        try {
            DB::transaction(function () use ($berita) {
                $berita->kategori()->detach();
                $berita->delete();
            });
        } catch (Throwable $e) {
            report($e);

            return back()->with(
                'gagal',
                'Berita gagal dihapus. Silakan coba kembali.'
            );
        }

        /*
         * File dihapus setelah transaksi database sukses.
         * Dengan begitu record tidak akan tersisa menunjuk
         * ke file yang sudah hilang jika database gagal.
         */
        if (
            $gambarLama &&
            Storage::disk('public')->exists($gambarLama)
        ) {
            $berhasilDihapus =
                Storage::disk('public')->delete($gambarLama);

            if (! $berhasilDihapus) {
                return redirect()
                    ->route('admin.berita.index')
                    ->with(
                        'sukses',
                        'Berita berhasil dihapus, tetapi file sampul gagal dibersihkan.'
                    );
            }
        }

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