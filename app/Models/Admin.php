<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';

    public $timestamps = true;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = ['nama', 'email', 'kata_sandi', 'peran'];

    protected $hidden = ['kata_sandi'];

    // Laravel auth secara default mencari kolom "password" -> arahkan ke "kata_sandi".
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }
}
