<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';

    const CREATED_AT = null;
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = ['nama', 'deskripsi', 'jadwal', 'pembina', 'gambar', 'urutan', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
