<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SDN Pluit 01') - {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md p-4 sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center flex-wrap gap-4">
            <a href="{{ route('beranda') }}" class="font-bold text-xl text-blue-700">
                {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}
            </a>
            <div class="flex items-center gap-6 text-sm font-medium text-gray-600">
                <!-- Link ini "#" sampai masing-masing halaman dibuat anggota tim terkait -->
                <a href="#" class="hover:text-blue-700">Profil</a>
                <a href="#" class="hover:text-blue-700">Akademik</a>
                <a href="#" class="hover:text-blue-700">Fasilitas</a>
                <a href="#" class="hover:text-blue-700">Berita</a>
                <a href="#" class="hover:text-blue-700">Galeri</a>
                <a href="#" class="hover:text-blue-700">Kontak/PPDB</a>
            </div>
            <a href="/login" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">Login Admin</a>
        </div>
    </nav>

    <!-- KONTEN HALAMAN -->
    @yield('content')

    <!-- FOOTER -->
    <footer class="bg-gray-800 text-gray-300 py-10 px-4">
        <div class="container mx-auto text-center md:text-left grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-xl font-bold text-white mb-2">{{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}</h3>
                <p>{{ $profilLayout->alamat ?? 'Jl. Pluit Selatan I No.1, RT.1/RW.6, Kel. Pluit, Kec. Penjaringan, Jakarta Utara 14450' }}</p>
            </div>
            <div class="md:text-right">
                <p>Email: {{ $profilLayout->email ?? 'info@sdnpluit01bersatu.my.id' }}</p>
                <p>Telepon: {{ $profilLayout->telepon ?? '-' }}</p>
            </div>
        </div>
        <div class="text-center mt-8 pt-4 border-t border-gray-700 text-sm">
            &copy; {{ date('Y') }} {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}. Dikembangkan oleh Tim PKM Teknik Informatika Universitas Pamulang.
        </div>
    </footer>

</body>
</html>
