@extends('layouts.public')

@section('title', $galeri->judul)

@section('content')
<div class="bg-gray-50 py-10 sm:py-12">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Kembali --}}
        <div class="mb-5">

            <a
                href="{{ route('galeri.public') }}"
                class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800"
            >
                ← Kembali ke Daftar Galeri
            </a>

        </div>


        {{-- Informasi Album --}}
        <div class="mb-8 rounded-xl bg-white p-5 shadow-sm sm:p-6">

            <h1
                class="mb-3 text-2xl font-bold leading-tight text-gray-900 sm:text-3xl"
            >
                {{ $galeri->judul }}
            </h1>


            <div
                class="mb-4 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500"
            >

                <span>
                    Tanggal Kegiatan:
                    {{ $galeri->tanggal_kegiatan->translatedFormat('d F Y') }}
                </span>

                <span>
                    •
                </span>

                <span>
                    {{ $galeri->foto->count() }} Foto
                </span>

            </div>


            @if ($galeri->deskripsi)

                <p
                    class="max-w-4xl whitespace-pre-line text-sm leading-relaxed text-gray-700 sm:text-base"
                >
                    {{ $galeri->deskripsi }}
                </p>

            @endif

        </div>


        {{-- Grid Foto --}}
        <div
            class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >

            @forelse ($galeri->foto as $foto)

                <div
                    class="group overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm transition hover:shadow-md"
                >

                    <div class="overflow-hidden">

                        <img
                            src="{{ asset('storage/' . $foto->lokasi_gambar) }}"
                            alt="{{ $foto->keterangan ?? $galeri->judul }}"
                            class="h-56 w-full object-cover transition duration-300 group-hover:scale-105"
                        >

                    </div>


                    @if ($foto->keterangan)

                        <div class="border-t bg-white p-3">

                            <p class="text-xs leading-relaxed text-gray-600">
                                {{ $foto->keterangan }}
                            </p>

                        </div>

                    @endif

                </div>

            @empty

                <div
                    class="col-span-full rounded-xl border border-dashed bg-white py-14 text-center"
                >

                    <p class="text-gray-500">
                        Belum ada foto di dalam album ini.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- Tombol Kembali Bawah --}}
        <div class="mt-10 border-t pt-6">

            <a
                href="{{ route('galeri.public') }}"
                class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800"
            >
                ← Kembali ke Daftar Galeri
            </a>

        </div>

    </div>

</div>
@endsection