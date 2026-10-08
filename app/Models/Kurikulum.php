<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = 'diperbarui_pada';

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

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}