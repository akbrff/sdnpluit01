<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Berita') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">

                    @if ($errors->any())
                        <div class="mb-6 rounded-lg border border-red-300 bg-red-50 p-4">
                            <p class="mb-2 font-semibold text-red-700">
                                Data belum bisa diperbarui.
                            </p>

                            <ul class="list-inside list-disc text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ route('admin.berita.update', $berita) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @method('PUT')

                        {{-- Judul --}}
                        <div class="mb-5">
                            <label
                                for="judul"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Judul Berita
                            </label>

                            <input
                                type="text"
                                name="judul"
                                id="judul"
                                value="{{ old('judul', $berita->judul) }}"
                                class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-blue-500
                                @error('judul') border-red-500 @enderror"
                            >

                            @error('judul')
                                <p class="mt-1 text-xs text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-5 grid grid-cols-1 gap-5 md:grid-cols-2">

                            {{-- Kategori --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Kategori Berita
                                </label>

                                @php
                                    $selectedKategori = old(
                                        'kategori',
                                        $berita->kategori->pluck('id')->toArray()
                                    );
                                @endphp

                                <div class="max-h-48 space-y-2 overflow-y-auto rounded-lg border p-3">

                                    @forelse ($kategori as $kat)
                                        <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700">
                                            <input
                                                type="checkbox"
                                                name="kategori[]"
                                                value="{{ $kat->id }}"
                                                {{ in_array($kat->id, $selectedKategori) ? 'checked' : '' }}
                                                class="rounded text-blue-600 focus:ring-blue-500"
                                            >

                                            <span>{{ $kat->nama }}</span>
                                        </label>
                                    @empty
                                        <p class="text-sm text-red-500">
                                            Belum ada kategori berita.
                                        </p>
                                    @endforelse

                                </div>

                                <p class="mt-1 text-xs text-gray-500">
                                    Bisa memilih lebih dari satu kategori.
                                </p>

                                @error('kategori')
                                    <p class="mt-1 text-xs text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                                @error('kategori.*')
                                    <p class="mt-1 text-xs text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div>
                                <label
                                    for="status"
                                    class="mb-2 block text-sm font-medium text-gray-700"
                                >
                                    Status Publikasi
                                </label>

                                <select
                                    name="status"
                                    id="status"
                                    class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-blue-500
                                    @error('status') border-red-500 @enderror"
                                >
                                    <option
                                        value="draft"
                                        {{ old('status', $berita->status) === 'draft' ? 'selected' : '' }}
                                    >
                                        Draft
                                    </option>

                                    <option
                                        value="terbit"
                                        {{ old('status', $berita->status) === 'terbit' ? 'selected' : '' }}
                                    >
                                        Terbit
                                    </option>
                                </select>

                                @error('status')
                                    <p class="mt-1 text-xs text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>

                        {{-- Gambar --}}
                        <div class="mb-5">
                            <label
                                for="gambar_sampul"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Gambar Sampul
                            </label>

                            @if ($berita->gambar_sampul)
                                <div class="mb-3">
                                    <img
                                        src="{{ asset('storage/' . $berita->gambar_sampul) }}"
                                        alt="{{ $berita->judul }}"
                                        class="h-32 w-48 rounded-lg border object-cover"
                                    >
                                </div>
                            @endif

                            <input
                                type="file"
                                name="gambar_sampul"
                                id="gambar_sampul"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full rounded-lg border text-sm text-gray-500
                                file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2
                                file:text-sm file:font-semibold file:text-blue-700
                                hover:file:bg-blue-100"
                            >

                            <p class="mt-1 text-xs text-gray-500">
                                Kosongkan jika tidak ingin mengganti gambar.
                                Maksimal 2MB.
                            </p>

                            @error('gambar_sampul')
                                <p class="mt-1 text-xs text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Isi --}}
                        <div class="mb-6">
                            <label
                                for="isi"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Isi Berita
                            </label>

                            <textarea
                                name="isi"
                                id="isi"
                                rows="10"
                                class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-blue-500
                                @error('isi') border-red-500 @enderror"
                            >{{ old('isi', $berita->isi) }}</textarea>

                            @error('isi')
                                <p class="mt-1 text-xs text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">

                            <a
                                href="{{ route('admin.berita.index') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                            >
                                Perbarui Berita
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>