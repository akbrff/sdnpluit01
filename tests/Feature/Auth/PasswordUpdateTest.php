<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

test('password can be updated', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->from('/profile')
        ->put('/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertTrue(
        Hash::check(
            'new-password',
            $admin->refresh()->kata_sandi
        )
    );
});

test('correct password must be provided to update password', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->from('/profile')
        ->put('/password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasErrorsIn(
            'updatePassword',
            'current_password'
        )
        ->assertRedirect('/profile');
});