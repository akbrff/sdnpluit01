<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Beranda') -
        {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}
    </title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap"
        rel="stylesheet"
    />

    {{-- Tailwind & AlpineJS --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body
    class="flex min-h-screen flex-col bg-gray-50 font-sans text-gray-800 antialiased"
    x-data="{ mobileMenuOpen: false }"
>


    {{-- ==========================================
        NAVBAR
    =========================================== --}}
    <nav class="sticky top-0 z-50 bg-white shadow-md">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="flex h-20 justify-between">


                {{-- Logo & Nama Sekolah --}}
                <div class="flex items-center">

                    <a
                        href="{{ route('beranda') }}"
                        class="flex items-center gap-3"
                    >

                        @if(isset($profilLayout->logo) && $profilLayout->logo)

                            <img
                                src="{{ Storage::url($profilLayout->logo) }}"
                                alt="Logo {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}"
                                class="h-12 w-auto object-contain"
                            >

                        @endif


                        <div class="flex flex-col">

                            <span class="text-xl font-bold uppercase leading-tight tracking-wide text-blue-800">
                                {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}
                            </span>

                            <span class="text-xs font-medium text-gray-500">
                                Unggul dan Berkarakter
                            </span>

                        </div>

                    </a>

                </div>


                {{-- ==========================================
                    MENU DESKTOP
                =========================================== --}}
                <div class="hidden items-center space-x-6 md:flex">

                    <a
                        href="{{ route('beranda') }}"
                        class="font-medium transition-colors duration-200
                        {{ request()->routeIs('beranda')
                            ? 'text-blue-700'
                            : 'text-gray-600 hover:text-blue-700' }}"
                    >
                        Beranda
                    </a>


                    <a
                        href="{{ route('struktur-organisasi.public') }}"
                        class="font-medium transition-colors duration-200
                        {{ request()->routeIs('struktur-organisasi.public')
                            ? 'text-blue-700'
                            : 'text-gray-600 hover:text-blue-700' }}"
                    >
                        Profil
                    </a>


                    <a
                        href="{{ route('kurikulum.public') }}"
                        class="font-medium transition-colors duration-200
                        {{ request()->routeIs('kurikulum.public')
                            ? 'text-blue-700'
                            : 'text-gray-600 hover:text-blue-700' }}"
                    >
                        Akademik
                    </a>


                    <span
                        class="font-medium text-gray-400 cursor-not-allowed"
                        title="Halaman Fasilitas belum tersedia"
                    >
                        Fasilitas
                    </span>


                    <a
                        href="{{ route('berita.public') }}"
                        class="font-medium transition-colors duration-200
                        {{ request()->routeIs('berita.public', 'berita.detail.public')
                            ? 'text-blue-700'
                            : 'text-gray-600 hover:text-blue-700' }}"
                    >
                        Berita
                    </a>


                    <a
                        href="{{ route('galeri.public') }}"
                        class="font-medium transition-colors duration-200
                        {{ request()->routeIs('galeri.public', 'galeri.detail.public')
                            ? 'text-blue-700'
                            : 'text-gray-600 hover:text-blue-700' }}"
                    >
                        Galeri
                    </a>

                </div>


                {{-- ==========================================
                    HAMBURGER MOBILE
                =========================================== --}}
                <div class="flex items-center md:hidden">

                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        type="button"
                        class="p-2 text-gray-500 hover:text-blue-700 focus:outline-none"
                        aria-label="Buka menu navigasi"
                    >

                        {{-- Hamburger --}}
                        <svg
                            x-show="!mobileMenuOpen"
                            class="h-7 w-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>


                        {{-- Close --}}
                        <svg
                            x-show="mobileMenuOpen"
                            x-cloak
                            class="h-7 w-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>

                    </button>

                </div>

            </div>

        </div>


        {{-- ==========================================
            MENU MOBILE
        =========================================== --}}
        <div
            x-show="mobileMenuOpen"
            x-cloak
            x-transition
            class="border-t border-gray-100 bg-white shadow-inner md:hidden"
        >

            <div class="space-y-1 px-4 pb-4 pt-2">

                <a
                    href="{{ route('beranda') }}"
                    class="block rounded-md px-3 py-2.5 text-base font-medium
                    {{ request()->routeIs('beranda')
                        ? 'bg-blue-50 text-blue-700'
                        : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}"
                >
                    Beranda
                </a>


                <a
                    href="{{ route('struktur-organisasi.public') }}"
                    class="block rounded-md px-3 py-2.5 text-base font-medium
                    {{ request()->routeIs('struktur-organisasi.public')
                        ? 'bg-blue-50 text-blue-700'
                        : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}"
                >
                    Profil
                </a>


                <a
                    href="{{ route('kurikulum.public') }}"
                    class="block rounded-md px-3 py-2.5 text-base font-medium
                    {{ request()->routeIs('kurikulum.public')
                        ? 'bg-blue-50 text-blue-700'
                        : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}"
                >
                    Akademik
                </a>


                <span
                    class="block rounded-md px-3 py-2.5 text-base font-medium text-gray-400 cursor-not-allowed"
                    title="Halaman Fasilitas belum tersedia"
                >
                    Fasilitas
                </span>


                <a
                    href="{{ route('berita.public') }}"
                    class="block rounded-md px-3 py-2.5 text-base font-medium
                    {{ request()->routeIs('berita.public', 'berita.detail.public')
                        ? 'bg-blue-50 text-blue-700'
                        : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}"
                >
                    Berita
                </a>


                <a
                    href="{{ route('galeri.public') }}"
                    class="block rounded-md px-3 py-2.5 text-base font-medium
                    {{ request()->routeIs('galeri.public', 'galeri.detail.public')
                        ? 'bg-blue-50 text-blue-700'
                        : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}"
                >
                    Galeri
                </a>

            </div>

        </div>

    </nav>


    {{-- ==========================================
        AREA KONTEN UTAMA
    =========================================== --}}
    <main class="flex-grow">
        @yield('content')
    </main>


    {{-- ==========================================
        FOOTER
    =========================================== --}}
    <footer class="mt-auto border-t-4 border-yellow-400 bg-blue-900 pb-8 pt-16 text-white">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-12 md:grid-cols-3 md:gap-8">


                {{-- Identitas Sekolah --}}
                <div>

                    <div class="mb-6 flex items-center gap-3">

                        @if(isset($profilLayout->logo) && $profilLayout->logo)

                            <img
                                src="{{ Storage::url($profilLayout->logo) }}"
                                alt="Logo {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}"
                                class="h-14 w-auto rounded-lg bg-white p-1"
                            >

                        @endif


                        <h3 class="text-2xl font-bold tracking-wide">
                            {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}
                        </h3>

                    </div>


                    <p class="mb-4 text-sm leading-relaxed text-blue-200">
                        {{ $profilLayout->ringkasan_profil
                            ?? 'Mewujudkan generasi cerdas, berkarakter, dan peduli lingkungan.' }}
                    </p>

                </div>


                {{-- Tautan Cepat --}}
                <div>

                    <h4 class="mb-6 text-lg font-bold uppercase tracking-wider">
                        Tautan Cepat
                    </h4>


                    <ul class="space-y-3 text-sm text-blue-200">

                        <li>
                            <a
                                href="{{ route('beranda') }}"
                                class="flex items-center gap-2 transition-colors hover:text-yellow-400"
                            >
                                <span class="text-yellow-400">&bull;</span>
                                Beranda
                            </a>
                        </li>


                        <li>
                            <a
                                href="{{ route('struktur-organisasi.public') }}"
                                class="flex items-center gap-2 transition-colors hover:text-yellow-400"
                            >
                                <span class="text-yellow-400">&bull;</span>
                                Profil Sekolah
                            </a>
                        </li>


                        <li>
                            <a
                                href="{{ route('berita.public') }}"
                                class="flex items-center gap-2 transition-colors hover:text-yellow-400"
                            >
                                <span class="text-yellow-400">&bull;</span>
                                Berita & Pengumuman
                            </a>
                        </li>


                        <li>
                            <a
                                href="{{ route('galeri.public') }}"
                                class="flex items-center gap-2 transition-colors hover:text-yellow-400"
                            >
                                <span class="text-yellow-400">&bull;</span>
                                Galeri Kegiatan
                            </a>
                        </li>


                        <li>
                            <a
                                href="https://ppdb.jakarta.go.id"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center gap-2 transition-colors hover:text-yellow-400"
                            >
                                <span class="text-yellow-400">&bull;</span>
                                Info PPDB Jakarta
                            </a>
                        </li>

                    </ul>

                </div>


                {{-- Kontak --}}
                <div>

                    <h4 class="mb-6 text-lg font-bold uppercase tracking-wider">
                        Hubungi Kami
                    </h4>


                    <ul class="space-y-4 text-sm text-blue-200">

                        <li class="flex items-start gap-3">

                            <svg
                                class="mt-0.5 h-5 w-5 flex-shrink-0 text-yellow-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                />
                            </svg>


                            <span class="leading-relaxed">
                                {{ $profilLayout->alamat
                                    ?? 'Jl. Pluit Selatan I No.1, RT.1/RW.6, Kel. Pluit, Kec. Penjaringan, Jakarta Utara' }}
                            </span>

                        </li>


                        <li class="flex items-center gap-3">

                            <svg
                                class="h-5 w-5 flex-shrink-0 text-yellow-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                />
                            </svg>


                            <span>
                                {{ $profilLayout->telepon ?? '-' }}
                            </span>

                        </li>


                        <li class="flex items-center gap-3">

                            <svg
                                class="h-5 w-5 flex-shrink-0 text-yellow-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />
                            </svg>


                            <span>
                                {{ $profilLayout->email ?? '-' }}
                            </span>

                        </li>

                    </ul>

                </div>

            </div>


            <div class="mt-12 flex flex-col items-center justify-between border-t border-blue-800 pt-6 text-sm text-blue-300 md:flex-row">

                <p>
                    &copy; {{ date('Y') }}
                    {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}.
                    Hak Cipta Dilindungi.
                </p>


                <p class="mt-2 md:mt-0">
                    Dikelola oleh Tim PKM Universitas Pamulang
                </p>

            </div>

        </div>

    </footer>

</body>

</html>