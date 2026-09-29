<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('jumlah')->nullable();
            $table->string('gambar')->nullable(); // satu gambar per fasilitas (bukan galeri banyak foto)
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
