<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit Struktur Organisasi</h2>
    </x-slot>

    <form action="{{ route('admin.struktur-organisasi.update', $item) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.struktur-organisasi._form')
    </form>
</x-app-layout>
