<?php

use Illuminate\Support\Facades\Route;

test('email verification screen is disabled', function () {
    $response = $this->get('/verify-email');

    $response->assertNotFound();
});

test('email verification routes are not registered', function () {
    expect(Route::has('verification.notice'))->toBeFalse()
        ->and(Route::has('verification.verify'))->toBeFalse()
        ->and(Route::has('verification.send'))->toBeFalse();
});