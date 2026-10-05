<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'SDN Pluit 01') -
        {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* =========================
           MOBILE / TABLET
        ========================== */

        .navbar-main {
            display: flex;
            height: 64px;
            align-items: center;
            justify-content: space-between;
        }

        .desktop-menu,
        .desktop-login {
            display: none;
        }

        .mobile-navbar-button {
            display: flex;
            align-items: center;
        }


        /* =========================
           DESKTOP
        ========================== */

        @media (min-width: 1024px) {

            .navbar-main {
                display: grid;

                /* kiri - tengah - kanan */
                grid-template-columns: 1fr auto 1fr;

                height: 64px;

                align-items: center;
            }

            .navbar-brand {
                justify-self: start;
            }

            .desktop-menu {
                display: flex;
                align-items: center;

                /* Jarak antar menu */
                column-gap: 28px;

                justify-self: center;
                white-space: nowrap;
            }

            .desktop-login {
                display: flex;
                align-items: center;
                justify-self: end;
            }

            .mobile-navbar-button {
                display: none;
            }

            .mobile-navbar-menu {
                display: none !important;
            }
        }
    </style>
</head>


<body class="bg-gray-50 font-sans text-gray-800 antialiased">


    {{-- ==========================================
        NAVBAR
    =========================================== --}}
    <nav
        x-data="{ open: false }"
        class="sticky top-0 z-50 border-b border-gray-200 bg-white shadow-sm"
    >

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="navbar-main">


                {{-- =========================
                    NAMA SEKOLAH
                ========================== --}}
                <div class="navbar-brand">

                    <a
                        href="{{ route('beranda') }}"
                        class="text-lg font-bold text-blue-700 transition hover:text-blue-800 sm:text-xl"
                    >
                        {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}
                    </a>

                </div>


                {{-- =========================
                    MENU DESKTOP
                ========================== --}}
                <div class="desktop-menu">

                    <a
                        href="{{ route('beranda') }}"
                        class="text-sm font-medium transition
                        {{ request()->routeIs('beranda')
                            ? 'font-semibold text-blue-700'
                            : 'text-gray-600 hover:text-blue-700' }}"
                    >
                        Beranda
                    </a>


                    <a
                        href="#"
                        class="text-sm font-medium text-gray-600 transition hover:text-blue-700"
                    >
                        Profil
                    </a>


                    <a
                        href="#"
                        class="text-sm font-medium text-gray-600 transition hover:text-blue-700"
                    >
                        Akademik
                    </a>


                    <a
                        href="#"
                        class="text-sm font-medium text-gray-600 transition hover:text-blue-700"
                    >
                        Fasilitas
                    </a>


                    <a
                        href="{{ route('berita.public') }}"
                        class="text-sm font-medium transition
                        {{ request()->routeIs('berita.*')
                            ? 'font-semibold text-blue-700'
                            : 'text-gray-600 hover:text-blue-700' }}"
                    >
                        Berita
                    </a>


                    <a
                        href="{{ route('galeri.public') }}"
                        class="text-sm font-medium transition
                        {{ request()->routeIs('galeri.*')
                            ? 'font-semibold text-blue-700'
                            : 'text-gray-600 hover:text-blue-700' }}"
                    >
                        Galeri
                    </a>


                    <a
                        href="#"
                        class="text-sm font-medium text-gray-600 transition hover:text-blue-700"
                    >
                        Kontak/PPDB
                    </a>

                </div>


                {{-- =========================
                    LOGIN ADMIN DESKTOP
                ========================== --}}
                <div class="desktop-login">

                    <a
                        href="/login"
                        class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                    >
                        Login Admin
                    </a>

                </div>


                {{-- =========================
                    HAMBURGER MOBILE
                ========================== --}}
                <div class="mobile-navbar-button">

                    <button
                        type="button"
                        @click="open = !open"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-600 transition hover:bg-gray-100"
                        aria-label="Buka menu navigasi"
                    >

                        {{-- Icon Garis Tiga --}}
                        <svg
                            x-show="!open"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
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


                        {{-- Icon X --}}
                        <svg
                            x-show="open"
                            x-cloak
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
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


            {{-- ==========================================
                MENU MOBILE
            =========================================== --}}
            <div
                x-show="open"
                x-cloak
                x-transition
                class="mobile-navbar-menu border-t border-gray-200 pb-4 pt-3"
            >

                <div class="flex flex-col gap-1">

                    <a
                        href="{{ route('beranda') }}"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium
                        {{ request()->routeIs('beranda')
                            ? 'bg-blue-50 font-semibold text-blue-700'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-blue-700' }}"
                    >
                        Beranda
                    </a>


                    <a
                        href="#"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-blue-700"
                    >
                        Profil
                    </a>


                    <a
                        href="#"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-blue-700"
                    >
                        Akademik
                    </a>


                    <a
                        href="#"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-blue-700"
                    >
                        Fasilitas
                    </a>


                    <a
                        href="{{ route('berita.public') }}"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium
                        {{ request()->routeIs('berita.*')
                            ? 'bg-blue-50 font-semibold text-blue-700'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-blue-700' }}"
                    >
                        Berita
                    </a>


                    <a
                        href="{{ route('galeri.public') }}"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium
                        {{ request()->routeIs('galeri.*')
                            ? 'bg-blue-50 font-semibold text-blue-700'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-blue-700' }}"
                    >
                        Galeri
                    </a>


                    <a
                        href="#"
                        class="rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-blue-700"
                    >
                        Kontak/PPDB
                    </a>


                    <div class="my-2 border-t border-gray-200"></div>


                    <a
                        href="/login"
                        class="rounded-lg bg-blue-600 px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-blue-700"
                    >
                        Login Admin
                    </a>

                </div>

            </div>

        </div>

    </nav>


    {{-- ==========================================
        CONTENT
    =========================================== --}}
    <main>
        @yield('content')
    </main>


    {{-- ==========================================
        FOOTER
    =========================================== --}}
    <footer class="bg-gray-800 px-4 py-10 text-gray-300">

        <div
            class="mx-auto grid max-w-7xl grid-cols-1 gap-8 text-center md:grid-cols-2 md:text-left"
        >

            <div>

                <h3 class="mb-2 text-xl font-bold text-white">
                    {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}
                </h3>

                <p class="text-sm leading-relaxed">
                    {{ $profilLayout->alamat
                        ?? 'Jl. Pluit Selatan I No.1, RT.1/RW.6, Kel. Pluit, Kec. Penjaringan, Jakarta Utara 14450' }}
                </p>

            </div>


            <div class="text-sm md:text-right">

                <p>
                    Email:
                    {{ $profilLayout->email ?? '-' }}
                </p>

                <p class="mt-1">
                    Telepon:
                    {{ $profilLayout->telepon ?? '-' }}
                </p>

            </div>

        </div>


        <div
            class="mx-auto mt-8 max-w-7xl border-t border-gray-700 pt-5 text-center text-sm"
        >

            &copy; {{ date('Y') }}

            {{ $profilLayout->nama_sekolah ?? 'SDN Pluit 01' }}.

            Dikembangkan oleh Tim PKM Teknik Informatika
            Universitas Pamulang.

        </div>

    </footer>


</body>

</html>