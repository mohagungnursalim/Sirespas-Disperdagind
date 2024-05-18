<?php

use App\Models\barang;
use App\Models\Komoditas;
use App\Models\Satuan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('Halaman Satuan pada dashboard bisa ditampilkan', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard/satuan');

    $response->assertStatus(200);
});

test('Pencarian data satuan', function() {
    
    // Buat user yang autentikasi
    $user = User::factory()->create();

    // Simulasikan pencarian dengan parameter 'filter'
    $response = $this->actingAs($user)->get('/dashboard/satuan?search=Kg');

    // Pastikan respons berhasil
    $response->assertStatus(200);

});

test('Satuan dapat dimasukan ke database', function() {

    $user = User::factory()->create();
    $satuan = Satuan::factory()->create();
    
      // Data yang akan dikirim 
      $data = [
        'nama' => $satuan->name,
        'created_at' => $satuan->created_at,
        'updated_at' => $satuan->updated_at
      ];
    
      // Mengirimkan permintaan untuk menyimpan data
      $response = $this->actingAs($user)->post('/dashboard/satuan', $data);
    
      // Memastikan respons redirect ke halaman yang benar 
      $response->assertStatus(302);
    
});

test('Satuan dapat dihapus dari database', function() {
  
  $user = User::factory()->create();
  $satuan = Satuan::factory()->create();

  $response = $this->actingAs($user)->delete("/dashboard/satuan/{$satuan->id}");

  $response->assertStatus(302);

});