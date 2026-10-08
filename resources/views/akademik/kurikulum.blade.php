@extends('layouts.public')

@section('content')
<div class="mx-auto max-w-4xl px-4 py-10 sm:px-6">
    <h1 class="mb-6 text-2xl font-bold text-gray-900">Kurikulum</h1>

    @forelse ($kurikulum as $item)
        <div class="mb-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">{{ $item->judul }}</h2>

            @if ($item->deskripsi)
                <p class="mt-2 text-gray-600">{{ $item->deskripsi }}</p>
            @endif

            @if ($item->url_dokumen)
                <a href="{{ $item->url_dokumen }}" target="_blank" rel="noopener"
                   class="mt-3 inline-block text-sm font-medium text-blue-600 hover:underline">
                    Lihat dokumen
                </a>
            @endif
        </div>
    @empty
        <p class="text-gray-500">Belum ada informasi kurikulum.</p>
    @endforelse
</div>
@endsection