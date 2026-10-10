<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Berita Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form
                    action="{{ route('admin.berita.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="mb-4">
                        <label
                            for="judul"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Judul Berita
                        </label>

                        <input
                            type="text"
                            name="judul"
                            id="judul"
                            value="{{ old('judul') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('judul') border-red-500 @enderror"
                            placeholder="Judul berita atau pengumuman..."
                            required
                        >

                        @error('judul')
                            <p class="text-red-500 text-xs mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori Berita (Bisa Pilih &gt; 1)
                            </label>

                            <div class="border rounded-lg p-3 max-h-40 overflow-y-auto space-y-2">
                                @foreach ($kategori as $kat)
                                    <label class="flex items-center space-x-2 text-sm text-gray-700">
                                        <input
                                            type="checkbox"
                                            name="kategori[]"
                                            value="{{ $kat->id }}"
                                            {{ is_array(old('kategori')) && in_array($kat->id, old('kategori')) ? 'checked' : '' }}
                                            class="rounded text-blue-600 focus:ring-blue-500"
                                        >

                                        <span>{{ $kat->nama }}</span>
                                    </label>
                                @endforeach
                            </div>

                            @error('kategori')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                            @error('kategori.*')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="status"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Status Publikasi
                            </label>

                            <select
                                name="status"
                                id="status"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror"
                                required
                            >
                                <option
                                    value="terbit"
                                    {{ old('status', 'terbit') === 'terbit' ? 'selected' : '' }}
                                >
                                    Terbit (Tampil di Web)
                                </option>

                                <option
                                    value="draft"
                                    {{ old('status') === 'draft' ? 'selected' : '' }}
                                >
                                    Draft (Sembunyikan)
                                </option>
                            </select>

                            @error('status')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label
                            for="gambar_sampul"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Gambar Sampul
                        </label>

                        <input
                            type="file"
                            name="gambar_sampul"
                            id="gambar_sampul"
                            accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            required
                        >

                        <p class="text-xs text-gray-500 mt-1">
                            Format: JPG, PNG, WEBP. Maksimal 2MB.
                        </p>

                        @error('gambar_sampul')
                            <p class="text-red-500 text-xs mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label
                            for="isi"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Isi Berita
                        </label>

                        <textarea
                            name="isi"
                            id="isi"
                            rows="8"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('isi') border-red-500 @enderror"
                            placeholder="Tuliskan isi berita di sini..."
                            required
                        >{{ old('isi') }}</textarea>

                        @error('isi')
                            <p class="text-red-500 text-xs mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center">
                        <a
                            href="{{ route('admin.berita.index') }}"
                            class="text-gray-600 hover:underline text-sm font-medium"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow"
                        >
                            Simpan Berita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>