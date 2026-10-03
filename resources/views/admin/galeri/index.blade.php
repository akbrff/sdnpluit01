@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Kelola Galeri & Album Foto</h2>
            <a href="{{ route('admin.galeri.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow">
                + Tambah Album
            </a>
        </div>

        @if (session('sukses'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('sukses') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3 text-sm font-semibold text-gray-600">No</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Cover Album</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Judul Album</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Jumlah Foto</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Tanggal Kegiatan</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Status</th>
                            <th class="p-3 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($galeri as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-700">{{ $loop->iteration + ($galeri->currentPage() - 1) * $galeri->perPage() }}</td>
                                <td class="p-3 text-sm">
                                    @if ($item->foto->first())
                                        <img src="{{ asset('storage/' . $item->foto->first()->lokasi_gambar) }}" alt="{{ $item->judul }}" class="w-16 h-12 object-cover rounded shadow">
                                    @else
                                        <span class="text-xs text-gray-400">Tanpa Foto</span>
                                    @endif
                                </td>
                                <td class="p-3 text-sm font-medium text-gray-900">{{ $item->judul }}</td>
                                <td class="p-3 text-sm text-gray-700">{{ $item->foto->count() }} Foto</td>
                                <td class="p-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->translatedFormat('d M Y') }}</td>
                                <td class="p-3 text-sm">
                                    @if ($item->aktif)
                                        <span class="px-2.5 py-1 text-xs bg-green-100 text-green-800 font-semibold rounded-full">Aktif</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs bg-gray-100 text-gray-600 font-semibold rounded-full">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="p-3 text-sm text-center">
                                    <a href="{{ route('admin.galeri.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold">Edit / Kelola Foto</a>
                                    <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus album ini beserta seluruh fotonya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-500">Belum ada album galeri.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $galeri->links() }}
            </div>
        </div>
    </div>
</div>
@endsection