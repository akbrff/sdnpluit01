<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Kelola Kurikulum</h2>
            <a href="{{ route('admin.kurikulum.create') }}"
               class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                Tambah
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        @if (session('sukses'))
            <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">
                {{ session('sukses') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Judul</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Tautan</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($items as $item)
                        <tr>
                            <td class="px-4 py-3 text-gray-900">{{ $item->judul }}</td>
                            <td class="px-4 py-3">
                                @if ($item->url_dokumen)
                                    <a href="{{ $item->url_dokumen }}" target="_blank" class="text-blue-600 hover:underline">Buka</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($item->aktif)
                                    <span class="rounded bg-green-100 px-2 py-1 text-xs text-green-800">Aktif</span>
                                @else
                                    <span class="rounded bg-gray-100 px-2 py-1 text-xs text-gray-600">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('admin.kurikulum.edit', $item) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.kurikulum.destroy', $item) }}" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-3 text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada data kurikulum.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>