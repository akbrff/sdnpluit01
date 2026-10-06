<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Profil & Statistik Sekolah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Sukses -->
            @if(session('sukses'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('sukses') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Form Gabungan -->
                    <form action="{{ route('admin.profil-statistik.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- BAGIAN 1: IDENTITAS SEKOLAH -->
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Identitas Sekolah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="nama_sekolah" class="block text-sm font-medium text-gray-700">Nama Sekolah</label>
                                <input type="text" name="nama_sekolah" id="nama_sekolah" value="{{ old('nama_sekolah', $profil->nama_sekolah) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('nama_sekolah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Sekolah</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $profil->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $profil->telepon) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('telepon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <textarea name="alamat" id="alamat" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('alamat', $profil->alamat) }}</textarea>
                                @error('alamat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="logo" class="block text-sm font-medium text-gray-700">Logo Sekolah</label>
                                @if($profil->logo)
                                    <div class="mt-2 mb-2">
                                        <img src="{{ Storage::url($profil->logo) }}" alt="Logo" class="h-16 w-auto">
                                    </div>
                                @endif
                                <input type="file" name="logo" id="logo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @error('logo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="foto_gedung" class="block text-sm font-medium text-gray-700">Foto Gedung Sekolah</label>
                                @if($profil->foto_gedung)
                                    <div class="mt-2 mb-2">
                                        <img src="{{ Storage::url($profil->foto_gedung) }}" alt="Foto Gedung" class="h-16 w-auto">
                                    </div>
                                @endif
                                <input type="file" name="foto_gedung" id="foto_gedung" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @error('foto_gedung') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- BAGIAN 2: KONTEN PROFIL -->
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Konten Profil</h3>
                        <div class="grid grid-cols-1 gap-6 mb-6">
                            <div>
                                <label for="ringkasan_profil" class="block text-sm font-medium text-gray-700">Ringkasan Profil</label>
                                <textarea name="ringkasan_profil" id="ringkasan_profil" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('ringkasan_profil', $profil->ringkasan_profil) }}</textarea>
                                @error('ringkasan_profil') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="visi" class="block text-sm font-medium text-gray-700">Visi</label>
                                <textarea name="visi" id="visi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('visi', $profil->visi) }}</textarea>
                                @error('visi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="misi" class="block text-sm font-medium text-gray-700">Misi</label>
                                <textarea name="misi" id="misi" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('misi', $profil->misi) }}</textarea>
                                @error('misi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="sejarah" class="block text-sm font-medium text-gray-700">Sejarah</label>
                                <textarea name="sejarah" id="sejarah" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('sejarah', $profil->sejarah) }}</textarea>
                                @error('sejarah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- BAGIAN 3: STATISTIK SEKOLAH -->
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Statistik Sekolah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label for="jumlah_guru" class="block text-sm font-medium text-gray-700">Jumlah Guru</label>
                                <input type="number" name="jumlah_guru" id="jumlah_guru" min="0" value="{{ old('jumlah_guru', $statistik->jumlah_guru) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('jumlah_guru') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="jumlah_siswa" class="block text-sm font-medium text-gray-700">Total Siswa</label>
                                <input type="number" name="jumlah_siswa" id="jumlah_siswa" min="0" value="{{ old('jumlah_siswa', $statistik->jumlah_siswa) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('jumlah_siswa') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="jumlah_kelas" class="block text-sm font-medium text-gray-700">Jumlah Rombongan Belajar (Kelas)</label>
                                <input type="number" name="jumlah_kelas" id="jumlah_kelas" min="0" value="{{ old('jumlah_kelas', $statistik->jumlah_kelas) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('jumlah_kelas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="siswa_laki_laki" class="block text-sm font-medium text-gray-700">Siswa Laki-laki</label>
                                <input type="number" name="siswa_laki_laki" id="siswa_laki_laki" min="0" value="{{ old('siswa_laki_laki', $statistik->siswa_laki_laki) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('siswa_laki_laki') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="siswa_perempuan" class="block text-sm font-medium text-gray-700">Siswa Perempuan</label>
                                <input type="number" name="siswa_perempuan" id="siswa_perempuan" min="0" value="{{ old('siswa_perempuan', $statistik->siswa_perempuan) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('siswa_perempuan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- TOMBOL SIMPAN -->
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>