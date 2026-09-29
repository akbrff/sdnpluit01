<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = ['judul', 'slug', 'deskripsi', 'tanggal_kegiatan', 'aktif'];

    protected $casts = ['aktif' => 'boolean', 'tanggal_kegiatan' => 'date'];

    public function foto()
    {
        return $this->hasMany(FotoGaleri::class, 'id_galeri')->orderBy('urutan');
    }
}
