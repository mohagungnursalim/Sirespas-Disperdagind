<?php

use App\Models\Komoditas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('Halaman komoditas pada dashboard bisa ditampilkan', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard/komoditas');

    $response->assertStatus(200);
});

test('Pencarian data komoditas', function() {
    
      // Buat user yang autentikasi
    $user = User::factory()->create();

    // Simulasikan pencarian dengan parameter 'filter'
    $response = $this->actingAs($user)->get('/dashboard/komoditas?search=BERAS');

    // Pastikan respons berhasil
    $response->assertStatus(200);

});

test('Komoditas dapat dimasukan ke database', function() {

      $user = User::factory()->create();
    
      // Membuat entri komoditas data pengujian
      $komoditas = Komoditas::factory()->create();
  
    
      // Data yang akan dikirim 
      $data = [
        'nama' => $komoditas->nama,
        'slug' => $komoditas->slug,
      ];
    
      // Mengirimkan permintaan untuk menyimpan data
      $response = $this->actingAs($user)->post('/dashboard/komoditas', $data);
    
      // Memastikan respons redirect ke halaman yang benar 
      $response->assertStatus(302);
    
});

test('Komoditas dapat diubah lalu tersimpan ke database', function () {
  // Membuat user yang autentikasi
  $user = User::factory()->create();

  // Membuat entri komoditas, barang, pasar, dan satuan untuk data pengujian
  $komoditas = Komoditas::factory()->create();

  // Data baru untuk pembaruan
  $updatedData = [
      'nama' => $komoditas->nama,
      'slug' => $komoditas->slug
  ];

  // Mengirimkan permintaan untuk memperbarui data pangan
  $response = $this->actingAs($user)->put("/dashboard/komoditas/{$komoditas->id}", $updatedData);

  // Memastikan respons redirect ke halaman yang benar
  $response->assertStatus(302);

});

test('Komoditas dapat dihapus dari database', function() {
  
  $user = User::factory()->create();

  $komoditas = Komoditas::factory()->create();

  $response = $this->actingAs($user)->delete("/dashboard/komoditas/{$komoditas->id}");

  $response->assertStatus(302);

});