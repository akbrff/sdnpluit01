<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;

class KurikulumPublicController extends Controller
{
    public function index()
    {
        $kurikulum = Kurikulum::aktif()->orderByDesc('id')->get();

        return view('akademik.kurikulum', compact('kurikulum'));
    }
}