<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Dinamis mengambil nama sekolah dari database -->
    <title>@yield('title', 'Beranda') - {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts (Tailwind & AlpineJS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false }">
    
    <!-- ================= NAVBAR ================= -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo & Nama Sekolah -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-3">
                        @if(isset($profilLayout->logo) && $profilLayout->logo)
                            <img src="{{ Storage::url($profilLayout->logo) }}" alt="Logo" class="h-12 w-auto object-contain">
                        @endif
                        <div class="flex flex-col">
                            <span class="font-bold text-xl text-blue-800 uppercase tracking-wide leading-tight">
                                {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}
                            </span>
                            <span class="text-xs text-gray-500 font-medium">Unggul dan Berkarakter</span>
                        </div>
                    </a>
                </div>
                
                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/" class="text-gray-600 hover:text-blue-700 font-medium transition-colors duration-200">Beranda</a>
                    <a href="#" class="text-gray-600 hover:text-blue-700 font-medium transition-colors duration-200">Profil</a>
                    <a href="#" class="text-gray-600 hover:text-blue-700 font-medium transition-colors duration-200">Akademik</a>
                    <a href="#" class="text-gray-600 hover:text-blue-700 font-medium transition-colors duration-200">Fasilitas</a>
                    <a href="#" class="text-gray-600 hover:text-blue-700 font-medium transition-colors duration-200">Berita</a>
                    <a href="#" class="text-gray-600 hover:text-blue-700 font-medium transition-colors duration-200">Galeri</a>
                </div>

                <!-- Tombol Hamburger Mobile -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-gray-500 hover:text-blue-700 focus:outline-none p-2">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Mobile (Dropdown) -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-t border-gray-100 shadow-inner" style="display: none;">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="/" class="block px-3 py-2.5 rounded-md text-base font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50">Beranda</a>
                <a href="#" class="block px-3 py-2.5 rounded-md text-base font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50">Profil</a>
                <a href="#" class="block px-3 py-2.5 rounded-md text-base font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50">Akademik</a>
                <a href="#" class="block px-3 py-2.5 rounded-md text-base font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50">Fasilitas</a>
                <a href="#" class="block px-3 py-2.5 rounded-md text-base font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50">Berita</a>
                <a href="#" class="block px-3 py-2.5 rounded-md text-base font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50">Galeri</a>
            </div>
        </div>
    </nav>

    <!-- ================= AREA KONTEN UTAMA ================= -->
    <!-- JANGAN UBAH BAGIAN YIELD INI -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-blue-900 text-white pt-16 pb-8 border-t-4 border-yellow-400 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-8">
                
                <!-- Kolom 1: Identitas Singkat -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        @if(isset($profilLayout->logo) && $profilLayout->logo)
                            <img src="{{ Storage::url($profilLayout->logo) }}" alt="Logo" class="h-14 w-auto bg-white rounded-lg p-1">
                        @endif
                        <h3 class="text-2xl font-bold tracking-wide">{{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}</h3>
                    </div>
                    <p class="text-blue-200 text-sm leading-relaxed mb-4">
                        {{ $profilLayout->ringkasan_profil ?? 'Mewujudkan generasi cerdas, berkarakter, dan peduli lingkungan.' }}
                    </p>
                </div>
                
                <!-- Kolom 2: Tautan Cepat -->
                <div>
                    <h4 class="text-lg font-bold mb-6 uppercase tracking-wider">Tautan Cepat</h4>
                    <ul class="space-y-3 text-sm text-blue-200">
                        <li><a href="/" class="hover:text-yellow-400 transition-colors flex items-center gap-2"><span class="text-yellow-400">&bull;</span> Beranda</a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors flex items-center gap-2"><span class="text-yellow-400">&bull;</span> Profil Sekolah</a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors flex items-center gap-2"><span class="text-yellow-400">&bull;</span> Berita & Pengumuman</a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors flex items-center gap-2"><span class="text-yellow-400">&bull;</span> Galeri Kegiatan</a></li>
                        <!-- Sesuai instruksi PPDB diarahkan ke eksternal -->
                        <li><a href="https://ppdb.jakarta.go.id" target="_blank" class="hover:text-yellow-400 transition-colors flex items-center gap-2"><span class="text-yellow-400">&bull;</span> Info PPDB Jakarta</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Kontak & Alamat -->
                <div>
                    <h4 class="text-lg font-bold mb-6 uppercase tracking-wider">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm text-blue-200">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="leading-relaxed">{{ $profilLayout->alamat ?? 'Jl. Pluit Selatan I No.1, RT.1/RW.6, Kel. Pluit, Kec. Penjaringan, Jakarta Utara' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>{{ $profilLayout->telepon ?? '-' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>{{ $profilLayout->email ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-12 pt-6 border-t border-blue-800 flex flex-col md:flex-row justify-between items-center text-sm text-blue-300">
                <p>&copy; {{ date('Y') }} {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}. Hak Cipta Dilindungi.</p>
                <p class="mt-2 md:mt-0">Dikelola oleh Tim PKM Universitas Pamulang</p>
            </div>
        </div>
    </footer>
</body>
</html>