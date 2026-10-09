<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

test('profile page is displayed', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->patch('/profile', [
            'nama' => 'Admin Baru',
            'email' => 'baru@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $admin->refresh();

    $this->assertSame(
        'Admin Baru',
        $admin->nama
    );

    $this->assertSame(
        'baru@example.com',
        $admin->email
    );
});

test('admin can keep the same email when updating profile', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->patch('/profile', [
            'nama' => 'Admin Updated',
            'email' => $admin->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertSame(
        'admin@test.com',
        $admin->refresh()->email
    );
});

test('admin can delete their account', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($admin->fresh());
});

test('correct password must be provided to delete account', function () {
    $admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn(
            'userDeletion',
            'password'
        )
        ->assertRedirect('/profile');

    $this->assertNotNull($admin->fresh());
});