<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StrukturOrganisasiRequest;
use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $data = StrukturOrganisasi::orderBy('urutan')->get();

        return view('admin.struktur-organisasi.index', compact('data'));
    }

    public function create()
    {
        return view('admin.struktur-organisasi.create');
    }

    public function store(StrukturOrganisasiRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('struktur-organisasi', 'public');
        }

        $validated['aktif'] = $request->boolean('aktif');

        StrukturOrganisasi::create($validated);

        return redirect()
            ->route('admin.struktur-organisasi.index')
            ->with('sukses', 'Data struktur organisasi berhasil ditambahkan.');
    }

    public function edit(StrukturOrganisasi $strukturOrganisasi)
    {
        return view('admin.struktur-organisasi.edit', [
            'item' => $strukturOrganisasi,
        ]);
    }

    public function update(StrukturOrganisasiRequest $request, StrukturOrganisasi $strukturOrganisasi)
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            // Hapus foto lama supaya tidak menumpuk file tak terpakai di server.
            if ($strukturOrganisasi->foto) {
                Storage::disk('public')->delete($strukturOrganisasi->foto);
            }
            $validated['foto'] = $request->file('foto')->store('struktur-organisasi', 'public');
        }

        $validated['aktif'] = $request->boolean('aktif');

        $strukturOrganisasi->update($validated);

        return redirect()
            ->route('admin.struktur-organisasi.index')
            ->with('sukses', 'Data struktur organisasi berhasil diperbarui.');
    }

    public function destroy(StrukturOrganisasi $strukturOrganisasi)
    {
        if ($strukturOrganisasi->foto) {
            Storage::disk('public')->delete($strukturOrganisasi->foto);
        }

        $strukturOrganisasi->delete();

        return redirect()
            ->route('admin.struktur-organisasi.index')
            ->with('sukses', 'Data struktur organisasi berhasil dihapus.');
    }
}
