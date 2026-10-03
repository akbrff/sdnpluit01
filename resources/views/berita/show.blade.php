@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
            <!-- Header Berita -->
            <div class="mb-6">
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach ($beritaPengumuman->kategori as $kat)
                        <span class="text-xs bg-blue-100 text-blue-800 font-semibold px-3 py-1 rounded-full">{{ $kat->nama }}</span>
                    @endforeach
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 leading-tight">{{ $beritaPengumuman->judul }}</h1>
                <div class="text-sm text-gray-500">
                    Diterbitkan pada {{ \Carbon\Carbon::parse($beritaPengumuman->diterbitkan_pada)->translatedFormat('d F Y') }}
                </div>
            </div>

            <!-- Gambar Sampul -->
            <div class="mb-8 rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $beritaPengumuman->gambar_sampul) }}" alt="{{ $beritaPengumuman->judul }}" class="w-full max-h-[450px] object-cover">
            </div>

            <!-- Isi Berita -->
            <div class="prose max-w-none text-gray-800 leading-relaxed text-base mb-8">
                {!! nl2br(e($beritaPengumuman->isi)) !!}
            </div>

            <div class="border-t pt-6">
                <a href="{{ route('berita.public') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold text-sm">
                    ← Kembali ke Daftar Berita
                </a>
            </div>
        </div>

        <!-- Berita Terkait -->
        @if ($beritaTerkait->count() > 0)
            <div class="mt-12">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Berita Terbaru Lainnya</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($beritaTerkait as $terkait)
                        <div class="bg-white rounded-lg shadow-sm border p-4 hover:shadow transition">
                            <img src="{{ asset('storage/' . $terkait->gambar_sampul) }}" alt="{{ $terkait->judul }}" class="w-full h-32 object-cover rounded mb-3">
                            <h4 class="font-bold text-sm text-gray-900 line-clamp-2 hover:text-blue-600 mb-1">
                                <a href="{{ route('berita.detail.public', $terkait->slug) }}">{{ $terkait->judul }}</a>
                            </h4>
                            <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($terkait->diterbitkan_pada)->translatedFormat('d M Y') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection