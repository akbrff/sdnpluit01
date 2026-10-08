<?php

namespace App\Http\Controllers;

use App\Models\StrukturOrganisasi;

class StrukturOrganisasiPublicController extends Controller
{
    public function index()
    {
        $data = StrukturOrganisasi::aktif()->get(); // scope aktif() sudah ada di model, urut by 'urutan'

        return view('profil.struktur-organisasi', compact('data'));
    }
}
