@extends('layouts.public')

@section('title', $beritaPengumuman->judul)

@section('content')
<div class="bg-gray-50 py-10 sm:py-12">

    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        <article
            class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6 md:p-8"
        >

            {{-- Header --}}
            <div class="mb-6">

                <div class="mb-3 flex flex-wrap gap-2">
                    @foreach ($beritaPengumuman->kategori as $kat)
                        <span
                            class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800"
                        >
                            {{ $kat->nama }}
                        </span>
                    @endforeach
                </div>

                <h1
                    class="mb-3 text-2xl font-bold leading-tight text-gray-900 md:text-3xl"
                >
                    {{ $beritaPengumuman->judul }}
                </h1>

                @if ($beritaPengumuman->diterbitkan_pada)
                    <div class="text-sm text-gray-500">
                        Diterbitkan pada
                        {{ $beritaPengumuman->diterbitkan_pada->translatedFormat('d F Y') }}
                    </div>
                @endif

            </div>

            {{-- Gambar Sampul --}}
            @if ($beritaPengumuman->gambar_sampul)
                <div class="mb-8 overflow-hidden rounded-lg">

                    <img
                        src="{{ asset('storage/' . $beritaPengumuman->gambar_sampul) }}"
                        alt="{{ $beritaPengumuman->judul }}"
                        class="max-h-[450px] w-full object-cover"
                    >

                </div>
            @endif

            {{-- Isi --}}
            <div class="mb-8 whitespace-pre-line text-base leading-relaxed text-gray-800">
                {{ $beritaPengumuman->isi }}
            </div>

            <div class="border-t pt-6">

                <a
                    href="{{ route('berita.public') }}"
                    class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800"
                >
                    ← Kembali ke Daftar Berita
                </a>

            </div>

        </article>

        {{-- Berita Lainnya --}}
        @if ($beritaTerkait->count() > 0)

            <div class="mt-10 sm:mt-12">

                <h2 class="mb-6 text-xl font-bold text-gray-900">
                    Berita Terbaru Lainnya
                </h2>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3">

                    @foreach ($beritaTerkait as $terkait)

                        <article
                            class="overflow-hidden rounded-lg border bg-white shadow-sm transition hover:shadow"
                        >

                            @if ($terkait->gambar_sampul)
                                <a href="{{ route('berita.detail.public', $terkait->slug) }}">

                                    <img
                                        src="{{ asset('storage/' . $terkait->gambar_sampul) }}"
                                        alt="{{ $terkait->judul }}"
                                        class="h-32 w-full object-cover"
                                    >

                                </a>
                            @endif

                            <div class="p-4">

                                <h3
                                    class="mb-2 line-clamp-2 text-sm font-bold text-gray-900 hover:text-blue-600"
                                >
                                    <a href="{{ route('berita.detail.public', $terkait->slug) }}">
                                        {{ $terkait->judul }}
                                    </a>
                                </h3>

                                @if ($terkait->diterbitkan_pada)
                                    <span class="text-xs text-gray-400">
                                        {{ $terkait->diterbitkan_pada->translatedFormat('d M Y') }}
                                    </span>
                                @endif

                            </div>

                        </article>

                    @endforeach

                </div>
            </div>

        @endif

    </div>
</div>
@endsection