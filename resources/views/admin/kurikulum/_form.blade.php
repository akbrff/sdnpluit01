@csrf

<div class="space-y-5">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kurikulum</label>
        <input type="text" name="judul" value="{{ old('judul', $item->judul ?? '') }}" required
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="4"
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
        @error('deskripsi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">URL Dokumen</label>
        <input type="url" name="url_dokumen" value="{{ old('url_dokumen', $item->url_dokumen ?? '') }}" placeholder="https://..."
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada tautan PDF/Drive terkait.</p>
        @error('url_dokumen') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center pt-2">
        <!-- Input hidden memastikan jika checkbox tidak dicentang, nilai 0 tetap terkirim -->
        <input type="hidden" name="aktif" value="0">
        <input type="checkbox" name="aktif" value="1"
            {{ old('aktif', $item->aktif ?? true) ? 'checked' : '' }}
            id="aktif" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
        <label for="aktif" class="ml-2 text-sm text-gray-700">Aktif (Tampilkan di halaman publik)</label>
    </div>
</div>

<div class="flex gap-3 mt-8">
    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
        Simpan
    </button>
    <a href="{{ route('admin.kurikulum.index') }}"
        class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-200">
        Batal
    </a>
</div>