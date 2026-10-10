<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Album Galeri') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">

                    @if ($errors->any())
                        <div class="mb-6 rounded-lg border border-red-300 bg-red-50 p-4">
                            <p class="mb-2 font-semibold text-red-700">
                                Data belum bisa disimpan.
                            </p>

                            <ul class="list-inside list-disc text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ route('admin.galeri.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        {{-- Judul --}}
                        <div class="mb-5">
                            <label
                                for="judul"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Judul Album
                            </label>

                            <input
                                type="text"
                                name="judul"
                                id="judul"
                                value="{{ old('judul') }}"
                                placeholder="Contoh: Kegiatan Upacara Bendera"
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

                            {{-- Tanggal --}}
                            <div>
                                <label
                                    for="tanggal_kegiatan"
                                    class="mb-2 block text-sm font-medium text-gray-700"
                                >
                                    Tanggal Kegiatan
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_kegiatan"
                                    id="tanggal_kegiatan"
                                    value="{{ old('tanggal_kegiatan', date('Y-m-d')) }}"
                                    class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-blue-500
                                    @error('tanggal_kegiatan') border-red-500 @enderror"
                                >

                                @error('tanggal_kegiatan')
                                    <p class="mt-1 text-xs text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div>
                                <label
                                    for="aktif"
                                    class="mb-2 block text-sm font-medium text-gray-700"
                                >
                                    Status Tampilan
                                </label>

                                <select
                                    name="aktif"
                                    id="aktif"
                                    class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-blue-500
                                    @error('aktif') border-red-500 @enderror"
                                >
                                    <option
                                        value="1"
                                        {{ old('aktif', '1') == '1' ? 'selected' : '' }}
                                    >
                                        Aktif - Tampil di Publik
                                    </option>

                                    <option
                                        value="0"
                                        {{ old('aktif') == '0' ? 'selected' : '' }}
                                    >
                                        Nonaktif - Sembunyikan
                                    </option>
                                </select>

                                @error('aktif')
                                    <p class="mt-1 text-xs text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-5">
                            <label
                                for="deskripsi"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Deskripsi Album
                            </label>

                            <textarea
                                name="deskripsi"
                                id="deskripsi"
                                rows="4"
                                placeholder="Tuliskan deskripsi singkat kegiatan..."
                                class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-blue-500
                                @error('deskripsi') border-red-500 @enderror"
                            >{{ old('deskripsi') }}</textarea>

                            <p class="mt-1 text-xs text-gray-500">
                                Deskripsi bersifat opsional.
                            </p>

                            @error('deskripsi')
                                <p class="mt-1 text-xs text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Foto --}}
                        <div class="mb-6">
                            <label
                                for="foto"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Foto Album
                            </label>

                            <input
                                type="file"
                                name="foto[]"
                                id="foto"
                                multiple
                                accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full rounded-lg border text-sm text-gray-500
                                file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2
                                file:text-sm file:font-semibold file:text-blue-700
                                hover:file:bg-blue-100"
                            >

                            <p class="mt-2 text-xs text-gray-500">
                                Bisa memilih beberapa foto sekaligus.
                                Format JPG, JPEG, PNG atau WEBP.
                                Maksimal 2MB per foto.
                            </p>

                            @error('foto')
                                <p class="mt-1 text-xs text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                            @error('foto.*')
                                <p class="mt-1 text-xs text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">

                            <a
                                href="{{ route('admin.galeri.index') }}"
                                class="text-center text-sm font-medium text-gray-600 hover:underline"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="rounded-lg bg-blue-600 px-5 py-2.5 font-semibold text-white shadow hover:bg-blue-700"
                            >
                                Simpan Album
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>