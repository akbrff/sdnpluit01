<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Kelola Berita & Pengumuman') }}
            </h2>

            <a href="{{ route('admin.berita.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700">
                + Buat Berita Baru
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
                                        Sampul
                                    </th>

                                    <th class="min-w-[220px] p-3 text-sm font-semibold text-gray-600">
                                        Judul Berita
                                    </th>

                                    <th class="min-w-[180px] p-3 text-sm font-semibold text-gray-600">
                                        Kategori
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
                                @forelse ($berita as $item)
                                    <tr class="border-b hover:bg-gray-50">

                                        <td class="p-3 text-sm text-gray-700">
                                            {{ $loop->iteration + ($berita->currentPage() - 1) * $berita->perPage() }}
                                        </td>

                                        <td class="p-3">
                                            @if ($item->gambar_sampul)
                                                <img
                                                    src="{{ asset('storage/' . $item->gambar_sampul) }}"
                                                    alt="{{ $item->judul }}"
                                                    class="h-14 w-20 rounded-lg border object-cover"
                                                >
                                            @else
                                                <div class="flex h-14 w-20 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400">
                                                    Tidak ada
                                                </div>
                                            @endif
                                        </td>

                                        <td class="p-3">
                                            <div class="font-medium text-gray-900">
                                                {{ $item->judul }}
                                            </div>

                                            @if ($item->diterbitkan_pada)
                                                <div class="mt-1 text-xs text-gray-500">
                                                    {{ $item->diterbitkan_pada->format('d M Y H:i') }}
                                                </div>
                                            @endif
                                        </td>

                                        <td class="p-3">
                                            @forelse ($item->kategori as $kat)
                                                <span class="mb-1 mr-1 inline-block rounded bg-blue-50 px-2 py-1 text-xs text-blue-700">
                                                    {{ $kat->nama }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-gray-400">
                                                    Tanpa kategori
                                                </span>
                                            @endforelse
                                        </td>

                                        <td class="p-3">
                                            @if ($item->status === 'terbit')
                                                <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-800">
                                                    Terbit
                                                </span>
                                            @else
                                                <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-semibold text-yellow-800">
                                                    Draft
                                                </span>
                                            @endif
                                        </td>

                                        <td class="p-3 text-center">
                                            <div class="flex items-center justify-center gap-3">
                                                <a
                                                    href="{{ route('admin.berita.edit', $item) }}"
                                                    class="font-semibold text-indigo-600 hover:text-indigo-900"
                                                >
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('admin.berita.destroy', $item) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus berita ini?')"
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
                                        <td colspan="6" class="p-8 text-center text-gray-500">
                                            Belum ada berita atau pengumuman.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $berita->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>