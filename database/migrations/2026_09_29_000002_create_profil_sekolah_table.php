<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel single-row: hanya akan diisi 1 baris data profil sekolah.
        Schema::create('profil_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah');
            $table->string('logo')->nullable();
            $table->string('foto_gedung')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->text('ringkasan_profil')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->longText('sejarah')->nullable();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_sekolah');
    }
};
