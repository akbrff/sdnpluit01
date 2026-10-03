<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Kelola Struktur Organisasi</h2>
            <a href="{{ route('admin.struktur-organisasi.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
                + Tambah Data
            </a>
        </div>
    </x-slot>

    @if (session('sukses'))
        <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg text-sm">
            {{ session('sukses') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Foto</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Jabatan</th>
                    <th class="px-4 py-3">Urutan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($data as $item)
                    <tr>
                        <td class="px-4 py-3">
                            @if($item->foto)
                                <img src="{{ asset('storage/'.$item->foto) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200"></div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $item->nama }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $item->jabatan }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $item->urutan }}</td>
                        <td class="px-4 py-3">
                            @if($item->aktif)
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.struktur-organisasi.edit', $item) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.struktur-organisasi.destroy', $item) }}" method="POST"
                                class="inline" onsubmit="return confirm('Yakin hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            Belum ada data struktur organisasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
