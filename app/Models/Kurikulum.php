<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'kurikulum';

    /**
     * Penyesuaian nama kolom timestamp khusus untuk proyek ini.
     */
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'url_dokumen',
        'aktif',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data bawaan.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'aktif' => 'boolean',
    ];
}