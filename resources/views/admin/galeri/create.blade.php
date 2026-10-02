@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Tambah Album Galeri Baru</h2>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul Album</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('judul') border-red-500 @enderror" placeholder="Contoh: Kegiatan Upacara Bendera HUT RI" required>
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="tanggal_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kegiatan</label>
                        <input type="date" name="tanggal_kegiatan" id="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', date('Y-m-d')) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('tanggal_kegiatan') border-red-500 @enderror" required>
                        @error('tanggal_kegiatan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="aktif" class="block text-sm font-medium text-gray-700 mb-2">Status Tampilan</label>
                        <select name="aktif" id="aktif" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="1" {{ old('aktif', '1') == '1' ? 'selected' : '' }}>Aktif (Tampil di Publik)</option>
                            <option value="0" {{ old('aktif') == '0' ? 'selected' : '' }}>Sembunyikan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat Album (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">Unggah Foto (Bisa Pilih Banyak Foto Sekaligus)</label>
                    <input type="file" name="foto[]" id="foto" multiple accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB per foto.</p>
                    @error('foto')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @error('foto.*')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.galeri.index') }}" class="text-gray-600 hover:underline text-sm font-medium">Batal</a>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow">
                        Simpan Album
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection