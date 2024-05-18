<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Hash; 


test('Halaman Login bisa ditampilkan', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('Pengguna dapat mengautentikasi dengan validasi dan reCAPTCHA benar', function () {
    // memalsukan respon dari reCAPTCHA api
    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true]),
    ]);

    // Membuat Akun user
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password', // Berikan kata sandi sebenarnya, Laravel akan melakukan hash secara otomatis untuk perbandingan
        'g-recaptcha-response' => 'valid-recaptcha-response', //  valid reCAPTCHA respon
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

test('Pengguna tidak dapat login dengan respon reCAPTCHA yang tidak benar & kata sandi salah', function () {
    // memalsukan respon dari reCAPTCHA api
    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => false]),
    ]);

    // Membuat Akun user
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password', // memasukan password yang salah
        'g-recaptcha-response' => 'invalid-recaptcha-response', //memberikan invalid respon
    ]);

    $this->assertGuest();
    
});
