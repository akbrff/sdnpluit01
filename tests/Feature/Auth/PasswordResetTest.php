<?php

use Illuminate\Support\Facades\Route;

test('forgot password screen is disabled', function () {
    $response = $this->get('/forgot-password');

    $response->assertNotFound();
});

test('forgot password request is disabled', function () {
    $response = $this->post('/forgot-password', [
        'email' => 'admin@test.com',
    ]);

    $response->assertNotFound();
});

test('reset password screen is disabled', function () {
    $response = $this->get('/reset-password/test-token');

    $response->assertNotFound();
});

test('password reset routes are not registered', function () {
    expect(Route::has('password.request'))->toBeFalse()
        ->and(Route::has('password.email'))->toBeFalse()
        ->and(Route::has('password.reset'))->toBeFalse()
        ->and(Route::has('password.store'))->toBeFalse();
});