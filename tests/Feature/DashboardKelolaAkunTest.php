<?php

use App\Models\barang;
use App\Models\Komoditas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('Halaman Kelola Akun pada dashboard bisa ditampilkan', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard/buat-akun');

    $response->assertStatus(200);
});

test('Pencarian data pengguna', function() {
    
      // Buat user yang autentikasi
    $user = User::factory()->create([
        'password' => Hash::make('password'),
        'is_admin' => true
    ]);

    // Simulasikan pencarian dengan parameter 'filter'
    $response = $this->actingAs($user)->get('/dashboard/buat-akun?search=user');

    // Pastikan respons berhasil
    $response->assertStatus(200);

});

test('Pengguna dapat dimasukan ke database', function() {

    $user = User::factory()->create();
    
      // Data yang akan dikirim 
      $data = [
        'nama' => $user->name,
        'is_admin' => $user->is_admin,
        'operator' => $user->operator,
        'email' => $user->email,
        'password' => $user->password
      ];
    
      // Mengirimkan permintaan untuk menyimpan data
      $response = $this->actingAs($user)->post('/dashboard/buat-akun', $data);
    
      // Memastikan respons redirect ke halaman yang benar 
      $response->assertStatus(302);
    
});

test('Pengguna dapat dihapus dari database', function() {
  
  $user = User::factory()->create();

  $response = $this->actingAs($user)->delete("/dashboard/buat-akun/{$user->id}");

  $response->assertStatus(302);

});