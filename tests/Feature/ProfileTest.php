<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(RefreshDatabase::class);

test('Halaman profil pengguna bisa ditampilkan', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard/profile');

    $response->assertStatus(200);
});

test('Pengguna bisa memperbarui informasi profil', function () {
    // Membuat pengguna baru dengan password yang di-hash dan alamat email palsu
    $user = User::factory()->create();

    // Mengirim permintaan pembaharuan profil
    $response = $this->actingAs($user)->patch('/dashboard/profile', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    // Memastikan tidak ada kesalahan sesi dan pengalihan ke halaman profil
    $response->assertSessionHasNoErrors()->assertRedirect('/dashboard/profile');

    // Memperbarui data pengguna dari database
    $user->refresh();

    // Memeriksa apakah data profil diperbarui dengan benar
    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe('test@example.com');
    expect($user->email_verified_at)->toBeNull();

    // Memeriksa apakah password berhasil di-hash
    $this->assertTrue(Hash::check('password', $user->password));
});

