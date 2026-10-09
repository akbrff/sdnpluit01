<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

test('confirm password screen can be rendered', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/confirm-password');

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->post('/confirm-password', [
            'password' => 'password',
        ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

    $response->assertSessionHasErrors();
});