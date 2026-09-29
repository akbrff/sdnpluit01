<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel pivot many-to-many antara berita_pengumuman dan kategori_berita.
        Schema::create('berita_kategori', function (Blueprint $table) {
            $table->foreignId('id_berita')
                ->constrained('berita_pengumuman')
                ->cascadeOnDelete();
            $table->foreignId('id_kategori')
                ->constrained('kategori_berita')
                ->cascadeOnDelete();
            $table->primary(['id_berita', 'id_kategori']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_kategori');
    }
};
