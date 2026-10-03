@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Album -->
        <div class="mb-8">
            <a href="{{ route('galeri.public') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold text-sm mb-4">
                ← Kembali ke Daftar Galeri
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $galeri->judul }}</h1>
            <p class="text-sm text-gray-500 mb-4">
                Pelaksanaan Kegiatan: {{ \Carbon\Carbon::parse($galeri->tanggal_kegiatan)->translatedFormat('d F Y') }} • Total {{ $galeri->foto->count() }} Foto
            </p>
            @if ($galeri->deskripsi)
                <p class="text-gray-700 text-base leading-relaxed max-w-3xl">{{ $galeri->deskripsi }}</p>
            @endif
        </div>

        <!-- Grid Foto Galeri -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($galeri->foto as $foto)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition">
                    <div class="relative overflow-hidden aspect-4/3">
                        <img src="{{ asset('storage/' . $foto->lokasi_gambar) }}" alt="{{ $foto->keterangan ?? $galeri->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    @if ($foto->keterangan)
                        <div class="p-3 text-xs text-gray-600 border-t bg-gray-50">
                            {{ $foto->keterangan }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    Belum ada foto yang diunggah di dalam album ini.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection