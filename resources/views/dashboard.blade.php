<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="space-y-6">
        <!-- Kartu Ucapan Selamat Datang -->
        <div class="p-5 bg-blue-50 border-l-4 border-blue-600 rounded-r-xl">
            <h3 class="text-lg font-bold text-blue-900">Selamat datang di Panel Admin SDN Pluit 01!</h3>
            <p class="text-sm text-blue-700 mt-1">Kelola informasi sekolah, kurikulum, dan konten website melalui menu navigasi di sebelah kiri.</p>
        </div>

        <!-- Ringkasan Modul -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-5 bg-gray-50 border border-gray-200 rounded-xl">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Profil & Statistik</p>
                <p class="text-lg font-bold text-gray-800 mt-1">Siap Dikelola</p>
            </div>
            <div class="p-5 bg-gray-50 border border-gray-200 rounded-xl">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Modul Kurikulum</p>
                <p class="text-lg font-bold text-green-600 mt-1">Aktif</p>
            </div>
            <div class="p-5 bg-gray-50 border border-gray-200 rounded-xl">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Struktur Organisasi</p>
                <p class="text-lg font-bold text-gray-800 mt-1">Siap Dikelola</p>
            </div>
        </div>
    </div>
</x-app-layout>