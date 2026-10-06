<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Ekstrakurikuler') }}
            </h2>
            <a href="{{ route('admin.ekstrakurikuler.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
                + Tambah Ekstrakurikuler
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('sukses'))
                <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
                    {{ session('sukses') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50 text-xs font-semibold text-gray-600 uppercase">
                                <th class="p-3">Urutan</th>
                                <th class="p-3">Gambar</th>
                                <th class="p-3">Nama</th>
                                <th class="p-3">Pembina</th>
                                <th class="p-3">Jadwal</th>
                                <th class="p-3">Status</th>
                                <th class="p-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm">
                            @forelse($data as $row)
                                <tr>
                                    <td class="p-3">{{ $row->urutan }}</td>
                                    <td class="p-3">
                                        @if($row->gambar)
                                            <img src="{{ asset('storage/'.$row->gambar) }}" class="w-12 h-12 object-cover rounded-lg">
                                        @else
                                            <span class="text-xs text-gray-400">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="p-3 font-semibold">{{ $row->nama }}</td>
                                    <td class="p-3">{{ $row->pembina ?? '-' }}</td>
                                    <td class="p-3">{{ $row->jadwal ?? '-' }}</td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $row->aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $row->aktif ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-right space-x-2">
                                        <a href="{{ route('admin.ekstrakurikuler.edit', $row->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('admin.ekstrakurikuler.destroy', $row->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-gray-500">Belum ada data ekstrakurikuler.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>