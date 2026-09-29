<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_galeri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_galeri')
                ->constrained('galeri')
                ->cascadeOnDelete();
            $table->string('lokasi_gambar');
            $table->string('keterangan')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamp('dibuat_pada')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_galeri');
    }
};
