<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    public function index()
    {
        // Menampilkan daftar kurikulum urut dari yang terbaru
        $kurikulum = Kurikulum::orderBy('dibuat_pada', 'desc')->get();
        return view('admin.kurikulum.index', compact('kurikulum'));
    }

    public function create()
    {
        return view('admin.kurikulum.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'url_dokumen' => 'nullable|url',
        ], [
            'judul.required' => 'Judul kurikulum wajib diisi.',
            'url_dokumen.url' => 'Format URL dokumen tidak valid.',
        ]);

        // Tangkap nilai checkbox (jika dicentang bernilai true, jika tidak false)
        $validated['aktif'] = $request->has('aktif');

        Kurikulum::create($validated);

        return redirect()->route('admin.kurikulum.index')
            ->with('success', 'Data kurikulum berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        return view('admin.kurikulum.edit', compact('kurikulum'));
    }

    public function update(Request $request, string $id)
    {
        $kurikulum = Kurikulum::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'url_dokumen' => 'nullable|url',
        ], [
            'judul.required' => 'Judul kurikulum wajib diisi.',
            'url_dokumen.url' => 'Format URL dokumen tidak valid.',
        ]);

        $validated['aktif'] = $request->has('aktif');

        $kurikulum->update($validated);

        return redirect()->route('admin.kurikulum.index')
            ->with('success', 'Data kurikulum berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $kurikulum->delete();

        return redirect()->route('admin.kurikulum.index')
            ->with('success', 'Data kurikulum berhasil dihapus.');
    }
}