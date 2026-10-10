@extends('layouts.public')

@section('title', 'Berita & Pengumuman')

@section('content')
<div class="bg-gray-50 py-10 sm:py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-8 text-center sm:mb-10">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                Berita & Pengumuman Sekolah
            </h1>

            <p class="mt-2 text-sm text-gray-600 sm:text-base">
                Informasi terbaru seputar kegiatan dan pengumuman resmi SDN Pluit 01
            </p>
        </div>

        {{-- Filter Kategori --}}
        <div class="mb-8 flex flex-wrap justify-center gap-2">

            <a
                href="{{ route('berita.public') }}"
                class="rounded-full border px-4 py-2 text-sm font-medium
                {{ !request('kategori')
                    ? 'bg-blue-600 text-white'
                    : 'bg-white text-gray-700 hover:bg-gray-100' }}"
            >
                Semua Kategori
            </a>

            @foreach ($kategori as $kat)
                <a
                    href="{{ route('berita.public', ['kategori' => $kat->slug]) }}"
                    class="rounded-full border px-4 py-2 text-sm font-medium
                    {{ request('kategori') === $kat->slug
                        ? 'bg-blue-600 text-white'
                        : 'bg-white text-gray-700 hover:bg-gray-100' }}"
                >
                    {{ $kat->nama }}
                </a>
            @endforeach

        </div>

        {{-- Daftar Berita --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

            @forelse ($berita as $item)

                <article
                    class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm transition hover:shadow-md"
                >

                    @if ($item->gambar_sampul)
                        <a href="{{ route('berita.detail.public', $item->slug) }}">
                            <img
                                src="{{ asset('storage/' . $item->gambar_sampul) }}"
                                alt="{{ $item->judul }}"
                                class="h-48 w-full object-cover"
                            >
                        </a>
                    @else
                        <div class="flex h-48 items-center justify-center bg-gray-100 text-sm text-gray-400">
                            Tidak ada gambar
                        </div>
                    @endif

                    <div class="p-5 sm:p-6">

                        <div class="mb-3 flex flex-wrap gap-1">

                            @foreach ($item->kategori as $kat)
                                <span
                                    class="rounded bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700"
                                >
                                    {{ $kat->nama }}
                                </span>
                            @endforeach

                        </div>

                        <h2 class="mb-2 line-clamp-2 text-lg font-bold text-gray-900 hover:text-blue-600">

                            <a href="{{ route('berita.detail.public', $item->slug) }}">
                                {{ $item->judul }}
                            </a>

                        </h2>

                        <p class="mb-4 line-clamp-3 text-sm leading-relaxed text-gray-600">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->isi), 120) }}
                        </p>

                        @if ($item->diterbitkan_pada)
                            <div class="text-xs text-gray-400">
                                {{ $item->diterbitkan_pada->translatedFormat('d F Y') }}
                            </div>
                        @endif

                    </div>
                </article>

            @empty

                <div class="col-span-full py-12 text-center">
                    <p class="text-gray-500">
                        Belum ada berita atau pengumuman yang diterbitkan.
                    </p>
                </div>

            @endforelse

        </div>

        @if ($berita->hasPages())
            <div class="mt-8">
                {{ $berita->links() }}
            </div>
        @endif

    </div>
</div>
@endsection