@extends('layouts.public')

@section('title', 'Beranda Utama')

@section('content')
    <!-- ================= HERO SECTION ================= -->
    <div class="relative bg-blue-900 h-[80vh] min-h-[500px] flex items-center justify-center text-center overflow-hidden">
        <!-- Background Image dengan Overlay -->
        @if(isset($profil->foto_gedung) && $profil->foto_gedung)
            <img src="{{ Storage::url($profil->foto_gedung) }}" alt="Gedung Sekolah" class="absolute inset-0 w-full h-full object-cover opacity-40">
        @else
            <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-blue-900 to-blue-700 opacity-80"></div>
        @endif
        
        <div class="relative z-10 px-4 max-w-5xl mx-auto">
            <span class="inline-block py-1 px-3 rounded-full bg-yellow-400 text-blue-900 text-sm font-bold uppercase tracking-wider mb-4 shadow-sm">
                Selamat Datang di
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight drop-shadow-lg">
                {{ $profil->nama_sekolah ?? 'SDN Pluit 01' }}
            </h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-3xl mx-auto mb-8 drop-shadow-md">
                {{ $profil->visi ?? 'Mewujudkan generasi cerdas, berkarakter, dan peduli lingkungan.' }}
            </p>
            <a href="#profil-singkat" class="inline-block bg-yellow-500 hover:bg-yellow-400 text-blue-900 font-bold py-3 px-8 rounded-lg shadow-lg transition-transform transform hover:-translate-y-1">
                Kenali Kami Lebih Dekat
            </a>
        </div>
    </div>

    <!-- ================= SECTION PROFIL SINGKAT ================= -->
    <div id="profil-singkat" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-12 items-center">
                <!-- Kolom Teks -->
                <div class="md:w-1/2">
                    <h2 class="text-sm font-bold text-blue-600 uppercase tracking-widest mb-2">Tentang Sekolah</h2>
                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Membangun Karakter Sejak Dini</h3>
                    <div class="prose max-w-none text-gray-600 leading-relaxed mb-6">
                        <p>{{ $profil->ringkasan_profil ?? 'Ringkasan profil sekolah belum tersedia. Silakan lengkapi data pada panel admin.' }}</p>
                    </div>
                    <a href="#" class="text-blue-700 font-semibold hover:text-blue-900 flex items-center gap-2">
                        Baca Sejarah Lengkap
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
                
                <!-- Kolom Visi Misi -->
                <div class="md:w-1/2 bg-gray-50 rounded-2xl p-8 border border-gray-100 shadow-sm">
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="bg-blue-100 p-2 rounded-lg text-blue-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">Visi</h4>
                        </div>
                        <p class="text-gray-600 pl-11">{{ $profil->visi ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="bg-yellow-100 p-2 rounded-lg text-yellow-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">Misi Utama</h4>
                        </div>
                        <p class="text-gray-600 pl-11 line-clamp-3">{{ $profil->misi ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <!-- ================= SECTION BERITA TERBARU ================= -->
    <div class="py-16 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Berita & Pengumuman</h2>
                <p class="text-gray-600 mt-4">Informasi terbaru seputar kegiatan dan prestasi SDN Pluit 01.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @if(isset($berita_terbaru) && count($berita_terbaru) > 0)
                    @foreach($berita_terbaru as $berita)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-shadow">
                            @if($berita->gambar_sampul)
                                <img src="{{ Storage::url($berita->gambar_sampul) }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-blue-100 flex items-center justify-center text-blue-300">No Image</div>
                            @endif
                            <div class="p-6">
                                <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $berita->judul }}</h3>
                                <p class="text-gray-500 text-sm line-clamp-3">{{ Str::limit(strip_tags($berita->isi), 100) }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-3 text-center py-8 text-gray-500">
                        Belum ada berita yang diterbitkan.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ================= SECTION GALERI KEGIATAN (Dikembalikan) ================= -->
    <div class="py-16 bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Galeri Kegiatan</h2>
                <p class="text-gray-600 mt-4">Momen-momen berharga dan aktivitas siswa di SDN Pluit 01.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @if(isset($galeri_pilihan) && count($galeri_pilihan) > 0)
                    @foreach($galeri_pilihan as $galeri)
                        <div class="relative group rounded-xl overflow-hidden shadow-sm bg-gray-100 h-64 border border-gray-200">
                            <!-- Catatan: Sesuaikan relasi 'foto_galeri' di bawah ini dengan nama method relasi di Model Galeri Anda -->
                            @if($galeri->foto_galeri && $galeri->foto_galeri->count() > 0)
                                <img src="{{ Storage::url($galeri->foto_galeri->first()->lokasi_gambar) }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">Tanpa Foto</div>
                            @endif
                            
                            <!-- Overlay Judul -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-90 transition-opacity">
                                <div class="absolute bottom-0 left-0 right-0 p-5">
                                    <h3 class="text-white font-bold text-lg mb-1">{{ $galeri->judul }}</h3>
                                    <p class="text-gray-300 text-sm truncate">{{ $galeri->deskripsi ?? 'Kegiatan Sekolah' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-3 text-center py-8 text-gray-500">
                        Belum ada galeri kegiatan yang ditambahkan.
                    </div>
                @endif
            </div>
            
            <div class="text-center mt-10">
                <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-sm transition-colors">
                    Lihat Semua Galeri
                </a>
            </div>
        </div>
    </div>
@endsection
=======
@endsection
>>>>>>> d877299 (fix: model dan controller kurikulum, view index, dan View Composer profilLayout)
