<?php

use App\Models\barang;
use App\Models\Komoditas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('Halaman barang pada dashboard bisa ditampilkan', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard/barang');

    $response->assertStatus(200);
});

test('Pencarian data barang', function() {
    
      // Buat user yang autentikasi
    $user = User::factory()->create();

    // Simulasikan pencarian dengan parameter 'filter'
    $response = $this->actingAs($user)->get('/dashboard/barang?search=Sayur Kangkung');

    // Pastikan respons berhasil
    $response->assertStatus(200);

});

test('Barang dapat dimasukan ke database', function() {

    $user = User::factory()->create();
    
      // Membuat entri barang data pengujian
      $barang = Barang::factory()->create();
      $komoditas = Komoditas::factory()->create();
    
      // Data yang akan dikirim 
      $data = [
        'nama' => $barang->nama,
        'komoditas_id' => $komoditas->id,
        'image' => $barang->image
      ];
    
      // Mengirimkan permintaan untuk menyimpan data
      $response = $this->actingAs($user)->post('/dashboard/barang', $data);
    
      // Memastikan respons redirect ke halaman yang benar 
      $response->assertStatus(302);
    
});

test('Barang dapat diubah lalu tersimpan ke database', function () {
  // Membuat user yang autentikasi
  $user = User::factory()->create();

  // Membuat entri barang, barang, pasar, dan satuan untuk data pengujian
  $barang = Barang::factory()->create();
  $komoditas = Komoditas::factory()->create();
  // Data baru untuk pembaruan
  $updatedData = [
      'nama' => $barang->nama,
      'komoditas_id' => $komoditas->id,
      'image' => $barang->image
  ];

  // Mengirimkan permintaan untuk memperbarui data pangan
  $response = $this->actingAs($user)->put("/dashboard/barang/{$barang->id}", $updatedData);

  // Memastikan respons redirect ke halaman yang benar
  $response->assertStatus(302);

});

test('Barang dapat dihapus dari database', function() {
  
  $user = User::factory()->create();

  $barang = Barang::factory()->create();

  $response = $this->actingAs($user)->delete("/dashboard/barang/{$barang->id}");

  $response->assertStatus(302);

});