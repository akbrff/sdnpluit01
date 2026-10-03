@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900">Berita & Pengumuman Sekolah</h1>
            <p class="text-gray-600 mt-2">Informasi terbaru seputar kegiatan dan pengumuman resmi SDN Pluit 01</p>
        </div>

        <!-- Filter Kategori -->
        <div class="flex flex-wrap justify-center gap-2 mb-8">
            <a href="{{ route('berita.public') }}" class="px-4 py-2 rounded-full text-sm font-medium {{ !request('kategori') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} border">
                Semua Kategori
            </a>
            @foreach ($kategori as $kat)
                <a href="{{ route('berita.public', ['kategori' => $kat->slug]) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('kategori') == $kat->slug ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} border">
                    {{ $kat->nama }}
                </a>
            @endforeach
        </div>

        <!-- Grid Berita -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse ($berita as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <img src="{{ asset('storage/' . $item->gambar_sampul) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach ($item->kategori as $kat)
                                <span class="text-xs bg-blue-50 text-blue-700 font-medium px-2.5 py-0.5 rounded">{{ $kat->nama }}</span>
                            @endforeach
                        </div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2 hover:text-blue-600 line-clamp-2">
                            <a href="{{ route('berita.detail.public', $item->slug) }}">{{ $item->judul }}</a>
                        </h2>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit(strip_tags($item->isi), 120) }}</p>
                        <div class="text-xs text-gray-400">
                            {{ \Carbon\Carbon::parse($item->diterbitkan_pada)->translatedFormat('d F Y') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-500">Belum ada berita atau pengumuman yang diterbitkan.</div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $berita->links() }}
        </div>
    </div>
</div>
@endsection