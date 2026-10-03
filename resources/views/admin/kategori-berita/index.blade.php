<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Kategori Berita</h2>
            <a href="{{ route('admin.kategori-berita.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-sm">+ Tambah Kategori</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('sukses'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">{{ session('sukses') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3 text-sm font-semibold text-gray-600">No</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Nama Kategori</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Slug</th>
                            <th class="p-3 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategori as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                <td class="p-3 text-sm font-medium text-gray-900">{{ $item->nama }}</td>
                                <td class="p-3 text-sm text-gray-500">{{ $item->slug }}</td>
                                <td class="p-3 text-sm text-center">
                                    <a href="{{ route('admin.kategori-berita.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold">Edit</a>
                                    <form action="{{ route('admin.kategori-berita.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-4 text-center text-gray-500">Belum ada kategori berita.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $kategori->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>