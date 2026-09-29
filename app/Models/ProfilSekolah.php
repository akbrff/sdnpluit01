<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    protected $table = 'profil_sekolah';

    const CREATED_AT = null;
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'nama_sekolah', 'logo', 'foto_gedung', 'alamat', 'telepon',
        'email', 'ringkasan_profil', 'visi', 'misi', 'sejarah',
    ];

    // Helper: tabel ini single-row, ambil (atau buat) baris satu-satunya.
    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
