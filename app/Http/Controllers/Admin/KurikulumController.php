<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KurikulumRequest;
use App\Models\Kurikulum;

class KurikulumController extends Controller
{
    public function index()
    {
        $items = Kurikulum::orderByDesc('id')->get();

        return view('admin.kurikulum.index', compact('items'));
    }

    public function create()
    {
        return view('admin.kurikulum.create');
    }

    public function store(KurikulumRequest $request)
    {
        $data = $request->validated();
        $data['aktif'] = $request->boolean('aktif');

        Kurikulum::create($data);

        return redirect()
            ->route('admin.kurikulum.index')
            ->with('sukses', 'Kurikulum berhasil ditambahkan.');
    }

    public function edit(Kurikulum $kurikulum)
    {
        return view('admin.kurikulum.edit', [
            'item' => $kurikulum,
        ]);
    }

    public function update(KurikulumRequest $request, Kurikulum $kurikulum)
    {
        $data = $request->validated();
        $data['aktif'] = $request->boolean('aktif');

        $kurikulum->update($data);

        return redirect()
            ->route('admin.kurikulum.index')
            ->with('sukses', 'Kurikulum berhasil diperbarui.');
    }

    public function destroy(Kurikulum $kurikulum)
    {
        $kurikulum->delete();

        return redirect()
            ->route('admin.kurikulum.index')
            ->with('sukses', 'Kurikulum berhasil dihapus.');
    }
}