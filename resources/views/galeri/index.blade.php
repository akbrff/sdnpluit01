@extends('layouts.public')

@section('title', 'Galeri')

@section('content')
<div class="bg-gray-50 py-10 sm:py-12">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 text-center sm:mb-10">

            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                Galeri Kegiatan
            </h1>

            <p class="mt-2 text-sm text-gray-600 sm:text-base">
                Dokumentasi kegiatan dan aktivitas SDN Pluit 01
            </p>

        </div>


        {{-- Daftar Album --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @forelse ($galeri as $item)

                <article
                    class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm transition hover:shadow-md"
                >

                    {{-- Cover Album --}}
                    <a href="{{ route('galeri.detail.public', $item->slug) }}">

                        @if ($item->foto->first())

                            <img
                                src="{{ asset('storage/' . $item->foto->first()->lokasi_gambar) }}"
                                alt="{{ $item->judul }}"
                                class="h-52 w-full object-cover sm:h-56"
                            >

                        @else

                            <div
                                class="flex h-52 w-full items-center justify-center bg-gray-100 text-sm text-gray-400 sm:h-56"
                            >
                                Belum ada foto
                            </div>

                        @endif

                    </a>


                    <div class="p-5 sm:p-6">

                        {{-- Tanggal --}}
                        <div class="mb-2 text-xs font-medium text-blue-600">

                            {{ $item->tanggal_kegiatan->translatedFormat('d F Y') }}

                        </div>


                        {{-- Judul --}}
                        <h2
                            class="mb-2 line-clamp-2 text-lg font-bold text-gray-900 hover:text-blue-600"
                        >

                            <a href="{{ route('galeri.detail.public', $item->slug) }}">
                                {{ $item->judul }}
                            </a>

                        </h2>


                        {{-- Deskripsi --}}
                        @if ($item->deskripsi)

                            <p class="mb-4 line-clamp-3 text-sm leading-relaxed text-gray-600">

                                {{ \Illuminate\Support\Str::limit(
                                    $item->deskripsi,
                                    120
                                ) }}

                            </p>

                        @endif


                        {{-- Jumlah Foto --}}
                        <div
                            class="flex items-center justify-between border-t pt-4"
                        >

                            <span class="text-xs text-gray-500">

                                {{ $item->foto->count() }} foto

                            </span>


                            <a
                                href="{{ route('galeri.detail.public', $item->slug) }}"
                                class="text-sm font-semibold text-blue-600 hover:text-blue-800"
                            >
                                Lihat Album →
                            </a>

                        </div>

                    </div>

                </article>

            @empty

                <div
                    class="col-span-full rounded-xl border border-dashed bg-white py-14 text-center"
                >

                    <p class="text-gray-500">
                        Belum ada album galeri yang ditampilkan.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        @if ($galeri->hasPages())

            <div class="mt-8">
                {{ $galeri->links() }}
            </div>

        @endif

    </div>

</div>
@endsection