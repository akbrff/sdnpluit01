<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Tambah Struktur Organisasi</h2>
    </x-slot>

    <form action="{{ route('admin.struktur-organisasi.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.struktur-organisasi._form')
    </form>
</x-app-layout>
