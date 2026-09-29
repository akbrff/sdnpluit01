<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaPengumuman extends Model
{
    protected $table = 'berita_pengumuman';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = ['judul', 'slug', 'isi', 'gambar_sampul', 'status', 'diterbitkan_pada'];

    protected $casts = ['diterbitkan_pada' => 'datetime'];

    public function kategori()
    {
        return $this->belongsToMany(
            KategoriBerita::class,
            'berita_kategori',
            'id_berita',
            'id_kategori'
        );
    }

    public function scopeTerbit($query)
    {
        return $query->where('status', 'terbit')->orderByDesc('diterbitkan_pada');
    }
}
