<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoGaleri extends Model
{
    protected $table = 'foto_galeri';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;

    protected $fillable = ['id_galeri', 'lokasi_gambar', 'keterangan', 'urutan'];

    public function galeri()
    {
        return $this->belongsTo(Galeri::class, 'id_galeri');
    }
}
