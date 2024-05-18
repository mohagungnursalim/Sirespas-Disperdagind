<?php

use App\Models\Pasar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('Halaman Data Pasar pada dashboard bisa ditampilkan', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard/pasar');

    $response->assertStatus(200);
});

test('Pasar dapat dimasukan ke database', function() {

    $user = User::factory()->create();
    
      // Membuat entri pasar data pengujian
      $pasar = Pasar::factory()->create();
    
      // Data yang akan dikirim 
      $data = [
        'nama' => $pasar->nama,
        'image' => $pasar->image,
        'tahun_pembangunan' => $pasar->tahun_pembangunan,
        'luas_lahan' => $pasar->luas_lahan,
        'sertifikat' => $pasar->sertifikat,
        'kecamatan' => $pasar->kecamatan,
        'kelurahan' => $pasar->kelurahan,
        'status_pasar' => $pasar->status_pasar,
        'pedagang' => $pasar->pedagang,
        'kios_petak' => $pasar->kios_petak,
        'los_petak' => $pasar->los_petak,
        'lapak_pelataran' => $pasar->lapak_pelataran,
        'ruko' => $pasar->ruko,
        'baik' => $pasar->baik,
        'rusak' => $pasar->rusak,
        'terpakai' => $pasar->terpakai,
        'kepala_pasar' => $pasar->kepala_pasar,
        'kebersihan' => $pasar->kebersihan,
        'keamanan' => $pasar->keamanan,
        'retribusi' => $pasar->retribusi,
        'created_at' => $pasar->created_at,
        'updated_at' => $pasar->updated_at
      ];
    
      // Mengirimkan permintaan untuk menyimpan data
      $response = $this->actingAs($user)->post('/dashboard/pasar', $data);
    
      // Memastikan respons redirect ke halaman yang benar 
      $response->assertStatus(302);
    
});

test('Pasar dapat diubah lalu tersimpan ke database', function () {
  // Membuat user yang autentikasi
  $user = User::factory()->create();

  // Membuat entri pasar untuk data pengujian
  $pasar = Pasar::factory()->create();

  // Data baru untuk pembaruan
  $updatedData = [
    'nama' => $pasar->nama,
    'image' => $pasar->image,
    'tahun_pembangunan' => $pasar->tahun_pembangunan,
    'luas_lahan' => $pasar->luas_lahan,
    'sertifikat' => $pasar->sertifikat,
    'kecamatan' => $pasar->kecamatan,
    'kelurahan' => $pasar->kelurahan,
    'status_pasar' => $pasar->status_pasar,
    'pedagang' => $pasar->pedagang,
    'kios_petak' => $pasar->kios_petak,
    'los_petak' => $pasar->los_petak,
    'lapak_pelataran' => $pasar->lapak_pelataran,
    'ruko' => $pasar->ruko,
    'baik' => $pasar->baik,
    'rusak' => $pasar->rusak,
    'terpakai' => $pasar->terpakai,
    'kepala_pasar' => $pasar->kepala_pasar,
    'kebersihan' => $pasar->kebersihan,
    'keamanan' => $pasar->keamanan,
    'retribusi' => $pasar->retribusi,
    'created_at' => $pasar->created_at,
    'updated_at' => $pasar->updated_at
  ];

  // Mengirimkan permintaan untuk memperbarui data pangan
  $response = $this->actingAs($user)->put("/dashboard/pasar/{$pasar->id}", $updatedData);

  // Memastikan respons redirect ke halaman yang benar
  $response->assertStatus(302);

});

test('Pasar dapat dihapus dari database', function() {
  
  $user = User::factory()->create();

  $pasar = Pasar::factory()->create();

  $response = $this->actingAs($user)->delete("/dashboard/pasar/{$pasar->id}");

  $response->assertStatus(302);

});