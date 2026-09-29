<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - {{ $profil->nama_sekolah ?? 'SDN Pluit 01' }}</title>
    <!-- Script untuk memanggil Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

    <!-- NAVBAR SEDERHANA -->
    <nav class="bg-white shadow-md p-4 sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="font-bold text-xl text-blue-700">
                {{ $profil->nama_sekolah ?? 'SDN Pluit 01' }}
            </h1>
            <a href="/login" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">Login Admin</a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="bg-blue-600 text-white text-center py-20 px-4">
        <h2 class="text-4xl md:text-5xl font-extrabold mb-4">Selamat Datang di Website Resmi</h2>
        <h3 class="text-2xl md:text-3xl font-semibold mb-6">{{ $profil->nama_sekolah ?? 'SDN Pluit 01' }}</h3>
        <p class="max-w-2xl mx-auto text-lg text-blue-100">
            {{ $profil->ringkasan_profil ?? 'Situs web resmi SDN Pluit 01. Terus bersatu untuk pendidikan yang lebih maju.' }}
        </p>
    </header>

    <!-- SECTION BERITA TERBARU -->
    <section class="container mx-auto py-16 px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800">Berita & Pengumuman Terbaru</h2>
            <div class="w-16 h-1 bg-blue-500 mx-auto mt-2 rounded"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse ($berita_terbaru as $berita)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <!-- Jika ada gambar, tampilkan. Jika tidak, pakai warna abu-abu -->
                    <div class="h-48 bg-gray-200">
                        @if($berita->gambar_sampul)
                            <img src="{{ asset('storage/'.$berita->gambar_sampul) }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-blue-500 font-semibold mb-1">{{ date('d M Y', strtotime($berita->diterbitkan_pada)) }}</p>
                        <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $berita->judul }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($berita->isi), 100) }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500 py-8">
                    Belum ada berita terbaru saat ini.
                </div>
            @endforelse
        </div>
    </section>

    <!-- SECTION GALERI KEGIATAN -->
    <section class="bg-white py-16 px-4 border-t border-gray-200">
        <div class="container mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800">Galeri Kegiatan</h2>
                <div class="w-16 h-1 bg-blue-500 mx-auto mt-2 rounded"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                @forelse ($galeri_pilihan as $album)
                    <div class="relative group overflow-hidden rounded-lg shadow-md bg-gray-100 h-48">
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <h4 class="text-white text-center font-semibold px-2">{{ $album->judul }}</h4>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-gray-500 py-8">
                        Galeri masih kosong.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-800 text-gray-300 py-10 px-4">
        <div class="container mx-auto text-center md:text-left grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-xl font-bold text-white mb-2">{{ $profil->nama_sekolah ?? 'SDN Pluit 01' }}</h3>
                <p>{{ $profil->alamat ?? 'Jl. Pluit Selatan I No.1, RT.1/RW.6, Kel. Pluit, Kec. Penjaringan, Jakarta Utara 14450' }}</p>
            </div>
            <div class="md:text-right">
                <p>Email: {{ $profil->email ?? 'info@sdnpluit01bersatu.my.id' }}</p>
                <p>Telepon: {{ $profil->telepon ?? '-' }}</p>
            </div>
        </div>
        <div class="text-center mt-8 pt-4 border-t border-gray-700 text-sm">
            &copy; {{ date('Y') }} {{ $profil->nama_sekolah ?? 'SDN Pluit 01' }}. Dikembangkan oleh Tim PKM Teknik Informatika Universitas Pamulang.
        </div>
    </footer>

</body>
</html>