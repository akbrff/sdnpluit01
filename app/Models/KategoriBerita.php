<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBerita extends Model
{
    protected $table = 'kategori_berita';

    public $timestamps = false;

    protected $fillable = ['nama', 'slug'];

    public function berita()
    {
        return $this->belongsToMany(
            BeritaPengumuman::class,
            'berita_kategori',
            'id_kategori',
            'id_berita'
        );
    }
}
