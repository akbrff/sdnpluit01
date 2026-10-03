@extends('layouts.public')

@section('title', 'Struktur Organisasi')

@section('content')
    <section class="container mx-auto py-16 px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800">Struktur Organisasi</h2>
            <div class="w-16 h-1 bg-blue-500 mx-auto mt-2 rounded"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            @forelse ($data as $item)
                <div class="text-center">
                    @if($item->foto)
                        <img src="{{ asset('storage/'.$item->foto) }}"
                            class="w-28 h-28 rounded-full object-cover mx-auto mb-3 shadow">
                    @else
                        <div class="w-28 h-28 rounded-full bg-gray-200 mx-auto mb-3"></div>
                    @endif
                    <h3 class="font-bold text-gray-800">{{ $item->nama }}</h3>
                    <p class="text-sm text-blue-600">{{ $item->jabatan }}</p>
                    @if($item->deskripsi)
                        <p class="text-sm text-gray-500 mt-1">{{ $item->deskripsi }}</p>
                    @endif
                </div>
            @empty
                <div class="col-span-4 text-center text-gray-500 py-8">
                    Data struktur organisasi belum tersedia.
                </div>
            @endforelse
        </div>
    </section>
@endsection
