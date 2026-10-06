<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EkstrakurikulerRequest;
use App\Models\Ekstrakurikuler;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $data = Ekstrakurikuler::orderBy('urutan')->get();
        return view('admin.ekstrakurikuler.index', compact('data'));
    }

    public function create()
    {
        return view('admin.ekstrakurikuler.create');
    }

    public function store(EkstrakurikulerRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('ekstrakurikuler', 'public');
        }

        $validated['aktif'] = $request->boolean('aktif');

        Ekstrakurikuler::create($validated);

        return redirect()
            ->route('admin.ekstrakurikuler.index')
            ->with('sukses', 'Data ekstrakurikuler berhasil ditambahkan.');
    }

    public function edit(Ekstrakurikuler $ekstrakurikuler)
    {
        return view('admin.ekstrakurikuler.edit', [
            'item' => $ekstrakurikuler,
        ]);
    }

    public function update(EkstrakurikulerRequest $request, Ekstrakurikuler $ekstrakurikuler)
    {
        $validated = $request->validated();

        if ($request->hasFile('gambar')) {
            if ($ekstrakurikuler->gambar) {
                Storage::disk('public')->delete($ekstrakurikuler->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('ekstrakurikuler', 'public');
        }

        $validated['aktif'] = $request->boolean('aktif');

        $ekstrakurikuler->update($validated);

        return redirect()
            ->route('admin.ekstrakurikuler.index')
            ->with('sukses', 'Data ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy(Ekstrakurikuler $ekstrakurikuler)
    {
        if ($ekstrakurikuler->gambar) {
            Storage::disk('public')->delete($ekstrakurikuler->gambar);
        }

        $ekstrakurikuler->delete();

        return redirect()
            ->route('admin.ekstrakurikuler.index')
            ->with('sukses', 'Data ekstrakurikuler berhasil dihapus.');
    }
}