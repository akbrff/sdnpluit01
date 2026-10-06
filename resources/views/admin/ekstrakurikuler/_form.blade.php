@csrf

<div class="space-y-5">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ekstrakurikuler</label>
        <input type="text" name="nama" value="{{ old('nama', $item->nama ?? '') }}" required
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('nama') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Pembina</label>
        <input type="text" name="pembina" value="{{ old('pembina', $item->pembina ?? '') }}"
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('pembina') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal Kegiatan</label>
        <input type="text" name="jadwal" value="{{ old('jadwal', $item->jadwal ?? '') }}" placeholder="Contoh: Setiap Jumat, 15.00 WIB"
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('jadwal') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="3"
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
        @error('deskripsi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar / Foto Kegiatan</label>
        @isset($item)
            @if($item->gambar)
                <img src="{{ asset('storage/'.$item->gambar) }}" class="w-20 h-20 object-cover rounded-lg mb-2">
                <p class="text-xs text-gray-500 mb-2">Biarkan kosong jika tidak ingin mengganti gambar.</p>
            @endif
        @endisset
        <input type="file" name="gambar" accept="image/*"
            class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        @error('gambar') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Urutan Tampil</label>
            <input type="number" name="urutan" value="{{ old('urutan', $item->urutan ?? 0) }}" min="0"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('urutan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center pt-7">
            <input type="hidden" name="aktif" value="0">
            <input type="checkbox" name="aktif" value="1"
                {{ old('aktif', $item->aktif ?? true) ? 'checked' : '' }}
                id="aktif" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="aktif" class="ml-2 text-sm text-gray-700">Tampilkan di halaman publik</label>
        </div>
    </div>
</div>

<div class="flex gap-3 mt-8">
    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
        Simpan
    </button>
    <a href="{{ route('admin.ekstrakurikuler.index') }}"
        class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-200">
        Batal
    </a>
</div>