<?php

use Illuminate\Support\Facades\Route;

test('public registration is disabled', function () {
    $response = $this->get('/register');

    $response->assertNotFound();

    expect(Route::has('register'))->toBeFalse();
});

test('registration request is not available', function () {
    $response = $this->post('/register', [
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertNotFound();
    $this->assertGuest();
});