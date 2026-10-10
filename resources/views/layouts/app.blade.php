<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SDN Pluit 01') }} - Panel Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet"
    />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased bg-gray-100"
    x-data="{ sidebarOpen: false }"
>

    <div class="flex h-screen overflow-hidden">

        <!-- Overlay Mobile -->
        <div
            x-show="sidebarOpen"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-20 transition-opacity bg-black bg-opacity-50 lg:hidden"
        ></div>


        <!-- Sidebar -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 flex flex-col w-64 px-4 py-8 overflow-y-auto transition-transform duration-300 ease-in-out bg-gray-900 lg:static lg:translate-x-0 lg:inset-0 shadow-xl"
        >

            <!-- Logo / Judul -->
            <div class="flex items-center justify-center mb-8">
                <div class="text-center">

                    <h2 class="text-2xl font-bold text-white">
                        Panel Admin
                    </h2>

                    <p class="text-sm text-gray-400 mt-1">
                        SDN Pluit 01 Bersatu
                    </p>

                </div>
            </div>


            <!-- Navigasi -->
            <nav class="flex flex-col flex-1 space-y-1">

                <!-- Dashboard -->
                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 text-gray-100 bg-gray-800 rounded-lg hover:bg-gray-700 transition-colors"
                >
                    <svg
                        class="w-5 h-5 mr-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                        ></path>
                    </svg>

                    <span>Dashboard</span>
                </a>


                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                        Manajemen Website
                    </p>
                </div>


                <!-- Profil & Statistik -->
                <a
                    href="{{ route('admin.profil-statistik.edit') }}"
                    class="flex items-center px-4 py-2.5 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors"
                >
                    <span>Profil & Statistik</span>
                </a>


                <!-- Struktur Organisasi -->
                <a
                    href="{{ route('admin.struktur-organisasi.index') }}"
                    class="flex items-center px-4 py-2.5 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors"
                >
                    <span>Struktur Organisasi</span>
                </a>


                <!-- Kurikulum -->
                <a
                    href="{{ route('admin.kurikulum.index') }}"
                    class="flex items-center px-4 py-2.5 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors"
                >
                    <span>Kurikulum</span>
                </a>


                <!-- Ekstrakurikuler -->
                <div
                    class="flex items-center px-4 py-2.5 text-gray-500 rounded-lg cursor-not-allowed"
                    title="Modul Ekstrakurikuler belum tersedia"
                >
                    <span>Ekstrakurikuler</span>
                </div>


                <!-- Fasilitas -->
                <div
                    class="flex items-center px-4 py-2.5 text-gray-500 rounded-lg cursor-not-allowed"
                    title="Modul Fasilitas belum tersedia"
                >
                    <span>Fasilitas</span>
                </div>


                <!-- Berita & Kategori -->
                <a
                    href="{{ route('admin.berita.index') }}"
                    class="flex items-center px-4 py-2.5 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors"
                >
                    <span>Berita & Kategori</span>
                </a>


                <!-- Galeri & Foto -->
                <a
                    href="{{ route('admin.galeri.index') }}"
                    class="flex items-center px-4 py-2.5 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors"
                >
                    <span>Galeri & Foto</span>
                </a>

            </nav>


            <!-- Logout -->
            <div class="mt-auto pt-8">

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors"
                    >
                        <svg
                            class="w-5 h-5 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 013-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            ></path>
                        </svg>

                        Logout
                    </button>
                </form>

            </div>

        </aside>


        <!-- Konten Utama -->
        <div class="flex flex-col flex-1 w-full overflow-hidden">

            <!-- Header -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b shadow-sm">

                <!-- Hamburger Mobile -->
                <button
                    @click="sidebarOpen = true"
                    class="text-gray-500 focus:outline-none lg:hidden hover:text-gray-700"
                >
                    <svg
                        class="w-6 h-6"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M4 6H20M4 12H20M4 18H11"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </button>


                <!-- Nama Administrator -->
                <div class="flex items-center ml-auto">

                    <span class="text-sm font-medium text-gray-700 bg-gray-100 px-4 py-2 rounded-full border border-gray-200">
                        Halo, {{ Auth::user()->nama ?? 'Admin' }}
                    </span>

                </div>

            </header>


            <!-- Isi Halaman -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">

                @if (isset($header))

                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $header }}
                        </h2>
                    </div>

                @endif


                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    {{ $slot }}
                </div>

            </main>

        </div>

    </div>

</body>

</html>