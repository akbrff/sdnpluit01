<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    protected $table = 'kurikulum';

    protected $fillable = [
        'judul',
        'deskripsi',
        'url_dokumen',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    // Tabel kurikulum hanya punya kolom diperbarui_pada, yang diisi otomatis oleh database.
    public $timestamps = false;

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}