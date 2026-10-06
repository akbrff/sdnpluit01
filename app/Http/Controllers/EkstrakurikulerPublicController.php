<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;

class EkstrakurikulerPublicController extends Controller
{
    public function index()
    {
        $data = Ekstrakurikuler::where('aktif', true)->orderBy('urutan')->get();
        return view('akademik.ekstrakurikuler', compact('data'));
    }
}