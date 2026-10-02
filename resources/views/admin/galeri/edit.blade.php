@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Album & Kelola Foto</h2>
        </div>

        @if (session('sukses'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('sukses') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul Album</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $galeri->judul) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="tanggal_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kegiatan</label>
                        <input type="date" name="tanggal_kegiatan" id="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', $galeri->tanggal_kegiatan) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label for="aktif" class="block text-sm font-medium text-gray-700 mb-2">Status Tampilan</label>
                        <select name="aktif" id="aktif" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="1" {{ old('aktif', $galeri->aktif) == 1 ? 'selected' : '' }}>Aktif (Tampil di Publik)</option>
                            <option value="0" {{ old('aktif', $galeri->aktif) == 0 ? 'selected' : '' }}>Sembunyikan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat Album</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">Tambah Foto Baru ke Album Ini</label>
                    <input type="file" name="foto[]" id="foto" multiple accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.galeri.index') }}" class="text-gray-600 hover:underline text-sm font-medium">Batal</a>
                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow">
                        Perbarui Album & Tambah Foto
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Foto dalam Album -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Foto dalam Album Ini ({{ $galeri->foto->count() }})</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse ($galeri->foto as $foto)
                    <div class="relative group border rounded-lg overflow-hidden bg-gray-50 shadow-sm">
                        <img src="{{ asset('storage/' . $foto->lokasi_gambar) }}" alt="Foto Galeri" class="w-full h-32 object-cover">
                        <div class="p-2 flex justify-between items-center bg-white">
                            <span class="text-xs text-gray-500">Urutan: #{{ $foto->urutan }}</span>
                            <form action="{{ route('admin.galeri.foto.destroy', $foto->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari album?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Hapus Foto</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm col-span-4">Belum ada foto di album ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection