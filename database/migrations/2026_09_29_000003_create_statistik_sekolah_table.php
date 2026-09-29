<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel single-row: data agregat, BUKAN data siswa per-orang (lihat catatan privasi di ERD).
        Schema::create('statistik_sekolah', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('jumlah_guru')->default(0);
            $table->unsignedInteger('jumlah_siswa')->default(0);
            $table->unsignedInteger('jumlah_kelas')->default(0);
            $table->unsignedInteger('siswa_laki_laki')->default(0);
            $table->unsignedInteger('siswa_perempuan')->default(0);
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistik_sekolah');
    }
};
