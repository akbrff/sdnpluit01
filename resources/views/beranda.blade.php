@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

    {{-- =========================
        HERO
    ========================== --}}
    <section class="bg-blue-600 text-white">
        <div class="mx-auto max-w-7xl px-4 py-16 text-center sm:px-6 sm:py-20 lg:px-8 lg:py-24">

            <h1 class="mx-auto max-w-4xl text-3xl font-extrabold leading-tight sm:text-4xl lg:text-5xl">
                Selamat Datang di Website Resmi
            </h1>

            <h2 class="mt-5 text-2xl font-semibold sm:text-3xl">
                {{ $profil->nama_sekolah ?? 'SDN Pluit 01' }}
            </h2>

            <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-blue-100 sm:text-lg">
                {{ $profil->ringkasan_profil ?? 'Situs resmi SDN Pluit 01.' }}
            </p>

        </div>
    </section>


    {{-- =========================
        BERITA TERBARU
    ========================== --}}
    <section class="bg-gray-50 py-12 sm:py-16">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-8 text-center sm:mb-10">

                <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                    Berita & Pengumuman Terbaru
                </h2>

                <div class="mx-auto mt-3 h-1 w-16 rounded bg-blue-500"></div>

                <p class="mx-auto mt-4 max-w-2xl text-sm text-gray-500 sm:text-base">
                    Informasi terbaru mengenai kegiatan dan pengumuman SDN Pluit 01.
                </p>

            </div>


            @php
                $jumlahBerita = $berita_terbaru->count();
            @endphp


            @if ($jumlahBerita === 1)

                {{-- Jika hanya 1 berita, posisikan di tengah --}}
                <div class="mx-auto max-w-xl">

                    @foreach ($berita_terbaru as $berita)

                        <article class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">

                            <a href="{{ route('berita.detail.public', $berita->slug) }}">

                                @if ($berita->gambar_sampul)

                                    <img
                                        src="{{ asset('storage/' . $berita->gambar_sampul) }}"
                                        alt="{{ $berita->judul }}"
                                        class="h-64 w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-64 items-center justify-center bg-gray-200 text-sm text-gray-400">
                                        Tidak ada gambar
                                    </div>

                                @endif

                            </a>


                            <div class="p-6">

                                @if ($berita->diterbitkan_pada)

                                    <p class="mb-2 text-sm font-semibold text-blue-600">
                                        {{ $berita->diterbitkan_pada->translatedFormat('d F Y') }}
                                    </p>

                                @endif


                                <h3 class="mb-3 text-xl font-bold text-gray-900">

                                    <a
                                        href="{{ route('berita.detail.public', $berita->slug) }}"
                                        class="transition hover:text-blue-600"
                                    >
                                        {{ $berita->judul }}
                                    </a>

                                </h3>


                                <p class="mb-5 line-clamp-3 text-sm leading-relaxed text-gray-600">
                                    {{ \Illuminate\Support\Str::limit(
                                        strip_tags($berita->isi),
                                        130
                                    ) }}
                                </p>


                                <a
                                    href="{{ route('berita.detail.public', $berita->slug) }}"
                                    class="text-sm font-semibold text-blue-600 hover:text-blue-800"
                                >
                                    Baca Selengkapnya →
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>


            @elseif ($jumlahBerita === 2)

                {{-- Jika 2 berita --}}
                <div class="mx-auto grid max-w-5xl grid-cols-1 gap-6 md:grid-cols-2">

                    @foreach ($berita_terbaru as $berita)

                        <article class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">

                            <a href="{{ route('berita.detail.public', $berita->slug) }}">

                                @if ($berita->gambar_sampul)

                                    <img
                                        src="{{ asset('storage/' . $berita->gambar_sampul) }}"
                                        alt="{{ $berita->judul }}"
                                        class="h-56 w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-56 items-center justify-center bg-gray-200 text-sm text-gray-400">
                                        Tidak ada gambar
                                    </div>

                                @endif

                            </a>


                            <div class="p-6">

                                @if ($berita->diterbitkan_pada)
                                    <p class="mb-2 text-sm font-semibold text-blue-600">
                                        {{ $berita->diterbitkan_pada->translatedFormat('d F Y') }}
                                    </p>
                                @endif

                                <h3 class="mb-3 text-xl font-bold text-gray-900">

                                    <a
                                        href="{{ route('berita.detail.public', $berita->slug) }}"
                                        class="hover:text-blue-600"
                                    >
                                        {{ $berita->judul }}
                                    </a>

                                </h3>

                                <p class="mb-5 line-clamp-3 text-sm leading-relaxed text-gray-600">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 120) }}
                                </p>

                                <a
                                    href="{{ route('berita.detail.public', $berita->slug) }}"
                                    class="text-sm font-semibold text-blue-600 hover:text-blue-800"
                                >
                                    Baca Selengkapnya →
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>


            @elseif ($jumlahBerita >= 3)

                {{-- Jika 3 berita --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

                    @foreach ($berita_terbaru as $berita)

                        <article class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">

                            <a href="{{ route('berita.detail.public', $berita->slug) }}">

                                @if ($berita->gambar_sampul)

                                    <img
                                        src="{{ asset('storage/' . $berita->gambar_sampul) }}"
                                        alt="{{ $berita->judul }}"
                                        class="h-52 w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-52 items-center justify-center bg-gray-200 text-sm text-gray-400">
                                        Tidak ada gambar
                                    </div>

                                @endif

                            </a>


                            <div class="p-5">

                                @if ($berita->diterbitkan_pada)

                                    <p class="mb-2 text-sm font-semibold text-blue-600">
                                        {{ $berita->diterbitkan_pada->translatedFormat('d F Y') }}
                                    </p>

                                @endif


                                <h3 class="mb-3 line-clamp-2 text-lg font-bold text-gray-900">

                                    <a
                                        href="{{ route('berita.detail.public', $berita->slug) }}"
                                        class="hover:text-blue-600"
                                    >
                                        {{ $berita->judul }}
                                    </a>

                                </h3>


                                <p class="mb-4 line-clamp-3 text-sm leading-relaxed text-gray-600">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 100) }}
                                </p>


                                <a
                                    href="{{ route('berita.detail.public', $berita->slug) }}"
                                    class="text-sm font-semibold text-blue-600 hover:text-blue-800"
                                >
                                    Baca Selengkapnya →
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>


            @else

                <div class="rounded-xl border border-dashed bg-white py-12 text-center text-gray-500">
                    Belum ada berita terbaru saat ini.
                </div>

            @endif


            @if ($jumlahBerita > 0)

                <div class="mt-10 text-center">

                    <a
                        href="{{ route('berita.public') }}"
                        class="inline-flex rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow transition hover:bg-blue-700"
                    >
                        Lihat Semua Berita
                    </a>

                </div>

            @endif

        </div>

    </section>


    {{-- =========================
        GALERI
    ========================== --}}
    <section class="border-t border-gray-200 bg-white py-12 sm:py-16">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-8 text-center sm:mb-10">

                <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                    Galeri Kegiatan
                </h2>

                <div class="mx-auto mt-3 h-1 w-16 rounded bg-blue-500"></div>

                <p class="mx-auto mt-4 max-w-2xl text-sm text-gray-500 sm:text-base">
                    Dokumentasi kegiatan dan aktivitas SDN Pluit 01.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

                @forelse ($galeri_pilihan as $album)

                    @php
                        $cover = $album->foto
                            ->sortBy('urutan')
                            ->first();
                    @endphp


                    <a
                        href="{{ route('galeri.detail.public', $album->slug) }}"
                        class="group relative overflow-hidden rounded-xl bg-gray-100 shadow-sm"
                    >

                        @if ($cover)

                            <img
                                src="{{ asset('storage/' . $cover->lokasi_gambar) }}"
                                alt="{{ $album->judul }}"
                                class="h-56 w-full object-cover transition duration-300 group-hover:scale-105"
                            >

                        @else

                            <div class="flex h-56 items-center justify-center text-sm text-gray-400">
                                Belum ada foto
                            </div>

                        @endif


                        <div class="absolute inset-0 flex items-end bg-gradient-to-t from-black/70 via-black/20 to-transparent">

                            <div class="w-full p-4">

                                <h3 class="font-semibold text-white">
                                    {{ $album->judul }}
                                </h3>

                                <p class="mt-1 text-xs text-gray-200">
                                    {{ $album->foto->count() }} foto
                                </p>

                            </div>

                        </div>

                    </a>

                @empty

                    <div class="col-span-full rounded-xl border border-dashed py-12 text-center text-gray-500">
                        Galeri masih kosong.
                    </div>

                @endforelse

            </div>


            @if ($galeri_pilihan->count() > 0)

                <div class="mt-10 text-center">

                    <a
                        href="{{ route('galeri.public') }}"
                        class="inline-flex rounded-lg border border-blue-600 px-5 py-2.5 text-sm font-semibold text-blue-600 transition hover:bg-blue-600 hover:text-white"
                    >
                        Lihat Semua Galeri
                    </a>

                </div>

            @endif

        </div>

    </section>

@endsection