@extends('layouts.public')

@section('title', 'Beranda Utama')

@section('content')

    {{-- ==========================================
        HERO
    =========================================== --}}
    <section class="relative flex h-[80vh] min-h-[500px] items-center justify-center overflow-hidden bg-blue-900 text-center">

        @if(isset($profil->foto_gedung) && $profil->foto_gedung)

            <img
                src="{{ Storage::url($profil->foto_gedung) }}"
                alt="Gedung {{ $profil->nama_sekolah ?? 'SDN Pluit 01' }}"
                class="absolute inset-0 h-full w-full object-cover opacity-40"
            >

        @else

            <div class="absolute inset-0 h-full w-full bg-gradient-to-br from-blue-900 to-blue-700 opacity-80"></div>

        @endif


        <div class="relative z-10 mx-auto max-w-5xl px-4">

            <span class="mb-4 inline-block rounded-full bg-yellow-400 px-3 py-1 text-sm font-bold uppercase tracking-wider text-blue-900 shadow-sm">
                Selamat Datang di
            </span>


            <h1 class="mb-6 text-4xl font-extrabold leading-tight text-white drop-shadow-lg md:text-6xl">
                {{ $profil->nama_sekolah ?? 'SDN Pluit 01' }}
            </h1>


            <p class="mx-auto mb-8 max-w-3xl text-lg text-blue-100 drop-shadow-md md:text-xl">
                {{ $profil->visi ?? 'Mewujudkan generasi cerdas, berkarakter, dan peduli lingkungan.' }}
            </p>


            <a
                href="#profil-singkat"
                class="inline-block transform rounded-lg bg-yellow-500 px-8 py-3 font-bold text-blue-900 shadow-lg transition hover:-translate-y-1 hover:bg-yellow-400"
            >
                Kenali Kami Lebih Dekat
            </a>

        </div>

    </section>


    {{-- ==========================================
        PROFIL SINGKAT
    =========================================== --}}
    <section id="profil-singkat" class="bg-white py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col items-center gap-12 md:flex-row">

                {{-- Tentang Sekolah --}}
                <div class="md:w-1/2">

                    <h2 class="mb-2 text-sm font-bold uppercase tracking-widest text-blue-600">
                        Tentang Sekolah
                    </h2>


                    <h3 class="mb-6 text-3xl font-bold text-gray-900">
                        Membangun Karakter Sejak Dini
                    </h3>


                    <div class="prose mb-6 max-w-none leading-relaxed text-gray-600">

                        <p>
                            {{ $profil->ringkasan_profil
                                ?? 'Ringkasan profil sekolah belum tersedia. Silakan lengkapi data pada panel admin.' }}
                        </p>

                    </div>


                    {{-- Route sejarah lengkap belum tersedia --}}
                    <a
                        href="#"
                        class="flex items-center gap-2 font-semibold text-blue-700 hover:text-blue-900"
                    >
                        Baca Sejarah Lengkap

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"
                            />
                        </svg>
                    </a>

                </div>


                {{-- Visi & Misi --}}
                <div class="rounded-2xl border border-gray-100 bg-gray-50 p-8 shadow-sm md:w-1/2">

                    <div class="mb-8">

                        <div class="mb-3 flex items-center gap-3">

                            <div class="rounded-lg bg-blue-100 p-2 text-blue-700">

                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>

                            </div>


                            <h4 class="text-xl font-bold text-gray-900">
                                Visi
                            </h4>

                        </div>


                        <p class="pl-11 text-gray-600">
                            {{ $profil->visi ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <div class="mb-3 flex items-center gap-3">

                            <div class="rounded-lg bg-yellow-100 p-2 text-yellow-700">

                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                    />
                                </svg>

                            </div>


                            <h4 class="text-xl font-bold text-gray-900">
                                Misi Utama
                            </h4>

                        </div>


                        <p class="line-clamp-3 pl-11 text-gray-600">
                            {{ $profil->misi ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- ==========================================
        BERITA TERBARU
    =========================================== --}}
    <section class="border-t border-gray-200 bg-gray-50 py-16">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-12 text-center">

                <h2 class="text-3xl font-bold text-gray-900">
                    Berita & Pengumuman
                </h2>


                <p class="mt-4 text-gray-600">
                    Informasi terbaru seputar kegiatan dan prestasi SDN Pluit 01.
                </p>

            </div>


            @php
                $jumlahBerita = $berita_terbaru->count();
            @endphp


            @if ($jumlahBerita === 1)

                {{-- Jika hanya 1 berita, tampilkan di tengah --}}
                <div class="mx-auto max-w-xl">

                    @foreach ($berita_terbaru as $berita)

                        <article class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm transition hover:shadow-md">

                            <a href="{{ route('berita.detail.public', $berita->slug) }}">

                                @if ($berita->gambar_sampul)

                                    <img
                                        src="{{ asset('storage/' . $berita->gambar_sampul) }}"
                                        alt="{{ $berita->judul }}"
                                        class="h-64 w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-64 items-center justify-center bg-blue-100 text-blue-300">
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
                                    {{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 130) }}
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

                <div class="mx-auto grid max-w-5xl grid-cols-1 gap-8 md:grid-cols-2">

                    @foreach ($berita_terbaru as $berita)

                        <article class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm transition hover:shadow-md">

                            <a href="{{ route('berita.detail.public', $berita->slug) }}">

                                @if ($berita->gambar_sampul)

                                    <img
                                        src="{{ asset('storage/' . $berita->gambar_sampul) }}"
                                        alt="{{ $berita->judul }}"
                                        class="h-52 w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-52 items-center justify-center bg-blue-100 text-blue-300">
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


                                <h3 class="mb-3 text-lg font-bold text-gray-900">

                                    <a
                                        href="{{ route('berita.detail.public', $berita->slug) }}"
                                        class="transition hover:text-blue-600"
                                    >
                                        {{ $berita->judul }}
                                    </a>

                                </h3>


                                <p class="mb-5 line-clamp-3 text-sm leading-relaxed text-gray-600">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 110) }}
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

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">

                    @foreach ($berita_terbaru as $berita)

                        <article class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm transition hover:shadow-md">

                            <a href="{{ route('berita.detail.public', $berita->slug) }}">

                                @if ($berita->gambar_sampul)

                                    <img
                                        src="{{ asset('storage/' . $berita->gambar_sampul) }}"
                                        alt="{{ $berita->judul }}"
                                        class="h-48 w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-48 items-center justify-center bg-blue-100 text-blue-300">
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


                                <h3 class="mb-3 line-clamp-2 text-lg font-bold text-gray-900">

                                    <a
                                        href="{{ route('berita.detail.public', $berita->slug) }}"
                                        class="transition hover:text-blue-600"
                                    >
                                        {{ $berita->judul }}
                                    </a>

                                </h3>


                                <p class="mb-5 line-clamp-3 text-sm leading-relaxed text-gray-600">
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
                    Belum ada berita yang diterbitkan.
                </div>

            @endif


            @if ($jumlahBerita > 0)

                <div class="mt-10 text-center">

                    <a
                        href="{{ route('berita.public') }}"
                        class="inline-block rounded-lg bg-blue-600 px-8 py-3 font-bold text-white shadow-sm transition-colors hover:bg-blue-700"
                    >
                        Lihat Semua Berita
                    </a>

                </div>

            @endif

        </div>

    </section>


    {{-- ==========================================
        GALERI KEGIATAN
    =========================================== --}}
    <section class="border-t border-gray-200 bg-white py-16">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-12 text-center">

                <h2 class="text-3xl font-bold text-gray-900">
                    Galeri Kegiatan
                </h2>


                <p class="mt-4 text-gray-600">
                    Momen-momen berharga dan aktivitas siswa di SDN Pluit 01.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @forelse ($galeri_pilihan as $album)

                    @php
                        $cover = $album->foto
                            ->sortBy('urutan')
                            ->first();
                    @endphp


                    <a
                        href="{{ route('galeri.detail.public', $album->slug) }}"
                        class="group relative h-64 overflow-hidden rounded-xl border border-gray-200 bg-gray-100 shadow-sm"
                    >

                        @if ($cover)

                            <img
                                src="{{ asset('storage/' . $cover->lokasi_gambar) }}"
                                alt="{{ $album->judul }}"
                                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                            >

                        @else

                            <div class="flex h-full w-full items-center justify-center text-gray-400">
                                Tanpa Foto
                            </div>

                        @endif


                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent">

                            <div class="absolute bottom-0 left-0 right-0 p-5">

                                <h3 class="mb-1 text-lg font-bold text-white">
                                    {{ $album->judul }}
                                </h3>


                                <p class="truncate text-sm text-gray-300">
                                    {{ $album->deskripsi ?? 'Kegiatan Sekolah' }}
                                </p>


                                <p class="mt-1 text-xs text-gray-300">
                                    {{ $album->foto->count() }} foto
                                </p>

                            </div>

                        </div>

                    </a>


                @empty

                    <div class="col-span-full rounded-xl border border-dashed py-12 text-center text-gray-500">
                        Belum ada galeri kegiatan yang ditambahkan.
                    </div>

                @endforelse

            </div>


            @if ($galeri_pilihan->count() > 0)

                <div class="mt-10 text-center">

                    <a
                        href="{{ route('galeri.public') }}"
                        class="inline-block rounded-lg bg-blue-600 px-8 py-3 font-bold text-white shadow-sm transition-colors hover:bg-blue-700"
                    >
                        Lihat Semua Galeri
                    </a>

                </div>

            @endif

        </div>

    </section>

@endsection