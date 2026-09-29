<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistikSekolah extends Model
{
    protected $table = 'statistik_sekolah';

    const CREATED_AT = null;
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'jumlah_guru', 'jumlah_siswa', 'jumlah_kelas',
        'siswa_laki_laki', 'siswa_perempuan',
    ];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
