@extends('layouts.public')

@section('title', 'Ekstrakurikuler - SDN Pluit 01')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-8 border-b pb-4">
        <h2 class="text-3xl font-extrabold text-gray-900">Ekstrakurikuler Sekolah</h2>
        <p class="text-gray-600 mt-2">Kegiatan pengembangan bakat dan minat siswa SDN Pluit 01.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($data as $item)
            <div class="bg-white rounded-lg shadow border border-gray-100 overflow-hidden flex flex-col justify-between">
                <div>
                    @if($item->gambar)
                        <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->nama }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                            Tidak ada foto
                        </div>
                    @endif
                    <div class="p-5">
                        <h3 class="text-xl font-bold text-blue-900 mb-2">{{ $item->nama }}</h3>
                        <p class="text-sm text-gray-600 mb-1"><strong>Pembina:</strong> {{ $item->pembina ?? '-' }}</p>
                        <p class="text-sm text-gray-600 mb-3"><strong>Jadwal:</strong> {{ $item->jadwal ?? '-' }}</p>
                        <p class="text-gray-700 text-sm whitespace-pre-line">{{ $item->deskripsi }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-md text-center">
                Belum ada kegiatan ekstrakurikuler yang ditampilkan.
            </div>
        @endforelse
    </div>
</div>
@endsection