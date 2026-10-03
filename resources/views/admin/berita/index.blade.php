<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Berita & Pengumuman') }}
            </h2>
            <a href="{{ route('admin.berita.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-sm shadow">
                + Buat Berita Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('sukses'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm">
                    {{ session('sukses') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-3 text-sm font-semibold text-gray-600">No</th>
                                <th class="p-3 text-sm font-semibold text-gray-600">Sampul</th>
                                <th class="p-3 text-sm font-semibold text-gray-600">Judul Berita</th>
                                <th class="p-3 text-sm font-semibold text-gray-600">Kategori</th>
                                <th class="p-3 text-sm font-semibold text-gray-600">Status</th>
                                <th class="p-3 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($berita as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 text-sm text-gray-700">{{ $loop->iteration + ($berita->currentPage() - 1) * $berita->perPage() }}</td>
                                    <td class="p-3 text-sm">
                                        <img src="{{ asset('storage/' . $item->gambar_sampul) }}" alt="{{ $item->judul }}" class="w-16 h-12 object-cover rounded shadow">
                                    </td>
                                    <td class="p-3 text-sm font-medium text-gray-900">{{ $item->judul }}</td>
                                    <td class="p-3 text-sm text-gray-600">
                                        @foreach ($item->kategori as $kat)
                                            <span class="inline-block bg-blue-50 text-blue-700 text-xs px-2 py-0.5 rounded mr-1 mb-1">{{ $kat->nama }}</span>
                                        @endforeach
                                    </td>
                                    <td class="p-3 text-sm">
                                        @if ($item->status === 'terbit')
                                            <span class="px-2.5 py-1 text-xs bg-green-100 text-green-800 font-semibold rounded-full">Terbit</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs bg-yellow-100 text-yellow-800 font-semibold rounded-full">Draft</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-sm text-center">
                                        <a href="{{ route('admin.berita.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold">Edit</a>
                                        <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">Belum ada berita atau pengumuman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $berita->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>