<?php

use App\Models\ProfilSekolah;

it('returns a successful response', function () {
    ProfilSekolah::create([
        'nama_sekolah' => 'SDN Pluit 01',
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
});