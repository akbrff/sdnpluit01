<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Kelola Galeri & Album Foto') }}
            </h2>

            <a
                href="{{ route('admin.galeri.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700"
            >
                + Tambah Album
            </a>
        </div>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('sukses'))
                <div class="mb-4 rounded-lg border border-green-400 bg-green-100 p-4 text-green-700">
                    {{ session('sukses') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">

                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse text-left">
                            <thead>
                                <tr class="border-b bg-gray-50">
                                    <th class="whitespace-nowrap p-3 text-sm font-semibold text-gray-600">
                                        No
                                    </th>

                                    <th class="whitespace-nowrap p-3 text-sm font-semibold text-gray-600">
                                        Cover Album
                                    </th>

                                    <th class="min-w-[220px] p-3 text-sm font-semibold text-gray-600">
                                        Judul Album
                                    </th>

                                    <th class="whitespace-nowrap p-3 text-sm font-semibold text-gray-600">
                                        Jumlah Foto
                                    </th>

                                    <th class="whitespace-nowrap p-3 text-sm font-semibold text-gray-600">
                                        Tanggal Kegiatan
                                    </th>

                                    <th class="whitespace-nowrap p-3 text-sm font-semibold text-gray-600">
                                        Status
                                    </th>

                                    <th class="whitespace-nowrap p-3 text-center text-sm font-semibold text-gray-600">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($galeri as $item)
                                    <tr class="border-b hover:bg-gray-50">

                                        <td class="p-3 text-sm text-gray-700">
                                            {{ $loop->iteration + ($galeri->currentPage() - 1) * $galeri->perPage() }}
                                        </td>

                                        <td class="p-3">
                                            @if ($item->foto->first())
                                                <img
                                                    src="{{ asset('storage/' . $item->foto->first()->lokasi_gambar) }}"
                                                    alt="{{ $item->judul }}"
                                                    class="h-14 w-20 rounded-lg border object-cover"
                                                >
                                            @else
                                                <div class="flex h-14 w-20 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                                    Tanpa Foto
                                                </div>
                                            @endif
                                        </td>

                                        <td class="p-3">
                                            <div class="font-medium text-gray-900">
                                                {{ $item->judul }}
                                            </div>

                                            @if ($item->deskripsi)
                                                <div class="mt-1 max-w-xs text-xs text-gray-500">
                                                    {{ \Illuminate\Support\Str::limit($item->deskripsi, 70) }}
                                                </div>
                                            @endif
                                        </td>

                                        <td class="p-3 text-sm text-gray-700">
                                            {{ $item->foto->count() }} Foto
                                        </td>

                                        <td class="p-3 text-sm text-gray-600">
                                            {{ $item->tanggal_kegiatan->translatedFormat('d M Y') }}
                                        </td>

                                        <td class="p-3">
                                            @if ($item->aktif)
                                                <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-800">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        <td class="p-3 text-center">
                                            <div class="flex items-center justify-center gap-3">

                                                <a
                                                    href="{{ route('admin.galeri.edit', $item) }}"
                                                    class="font-semibold text-indigo-600 hover:text-indigo-900"
                                                >
                                                    Edit / Foto
                                                </a>

                                                <form
                                                    action="{{ route('admin.galeri.destroy', $item) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus album ini beserta seluruh fotonya?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="font-semibold text-red-600 hover:text-red-900"
                                                    >
                                                        Hapus
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-8 text-center text-gray-500">
                                            Belum ada album galeri.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($galeri->hasPages())
                        <div class="mt-6">
                            {{ $galeri->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>