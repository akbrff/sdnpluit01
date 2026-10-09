<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('admin can authenticate using the login screen', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $response = $this->post('/login', [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('admin can not authenticate with invalid password', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $this->post('/login', [
        'email' => $admin->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('admin can logout', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});