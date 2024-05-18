<?php

namespace Tests\Feature;

use App\Http\Controllers\PanganController;
use App\Models\Barang;
use App\Models\Komoditas;
use App\Models\Pangan;
use App\Models\Pasar;
use App\Models\Satuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Tests\TestCase;



test('Halaman Harga Pangan pada dashboard bisa ditampilkan', function () {
  $user = User::factory()->create([
      'password' => Hash::make('password'),
      'is_admin' => true
  ]);

  $response = $this->actingAs($user)->get('/dashboard/harga-pangan');

  $response->assertStatus(200);
});

test('Filter harga pangan berdasarkan Pasar yang dipilih', function () {

  // Buat user yang autentikasi
  $user = User::factory()->create([
    'password' =>Hash::make('password')
  ]);

  // Simulasikan pencarian dengan parameter 'filter'
  $response = $this->actingAs($user)->get('/dashboard/harga-pangan?filter=Pasar Inpres Manonda');

  // Pastikan respons berhasil
  $response->assertStatus(200);

});

test('Harga pangan dapat dimasukan ke database', function () {
    $user = User::factory()->create([
      'password' => Hash::make('password'),
    ]);
  
    // Membuat entri komoditas dan barang untuk data pengujian
    $komoditas = Komoditas::factory()->create();
    $barang = Barang::factory()->create();
    $pasar = Pasar::factory()->create();
    $satuan = Satuan::factory()->create();
  
    // Data yang akan dikirim dalam permintaan POST (perbaiki dengan nilai valid)
    $data = [
      'komoditas_id' => $komoditas->id,
      'pasar' => $pasar->nama, // Gunakan ID pasar yang valid
      'satuan' => $satuan->nama, // Gunakan ID satuan yang valid
      'barang_id' => $barang->id,
      'harga' => 10000, // Harga yang sesuai dengan validasi
      'periode' => '2024-03-19',
    ];
  
    // Mengirimkan permintaan untuk menyimpan data
    $response = $this->actingAs($user)->post('/dashboard/harga-pangan', $data);
  
    // Memastikan respons redirect ke halaman yang benar (sesuaikan dengan routing Anda)
    $response->assertRedirect('/dashboard/harga-pangan');
  
    // Memastikan data berhasil tersimpan di database
    $this->assertDatabaseHas('pangans', [
      'komoditas_id' => $komoditas->id,
      'barang_id' => $barang->id,
      'pasar' => $pasar->nama,
      'satuan' => $satuan->nama,
      'harga' => 10000,
      'periode' => '2024-03-19',
    ]);
  });

test('Harga pangan dapat diubah lalu tersimpan ke database', function () {
    // Membuat user yang autentikasi
    $user = User::factory()->create([
      'password' => Hash::make('password'),
  ]);

  // Membuat entri komoditas, barang, pasar, dan satuan untuk data pengujian
  $komoditas = Komoditas::factory()->create();
  $barang = Barang::factory()->create();
  $pasar = Pasar::factory()->create();
  $satuan = Satuan::factory()->create();

  // Membuat entri pangan untuk data pengujian
  $pangan = Pangan::factory()->create();

  // Data baru untuk pembaruan
  $updatedData = [
      'user_id' => $user->id,
      'barang_id' => $barang->id,
      'komoditas_id' => $komoditas->id,
      'satuan' => $satuan->nama,
      'pasar' => $pasar->nama,
      'harga_sebelum' => 2500,
      'harga' => 5000,
      'perubahan_rp' => 2500,
      'perubahan_persen' => 2,
      'keterangan' => 'naik',
      'periode' => now(),
  ];

  // Mengirimkan permintaan untuk memperbarui data pangan
  $response = $this->actingAs($user)->put("/dashboard/harga-pangan/{$pangan->id}", $updatedData);

  // Memastikan respons redirect ke halaman yang benar
  $response->assertRedirect('/dashboard/harga-pangan');


});

test('Harga pangan dapat dihapus dari database', function () {

    $user = User::factory()->create([
      'password' => Hash::make('password')
    ]);

    // Membuat pangan baru
    $pangan = Pangan::factory()->create();

    // Melakukan permintaan penghapusan
    $response = $this->delete("/dashboard/harga-pangan/{$pangan->id}");

    // Mengirimkan permintaan untuk memperbarui data pangan
    $response = $this->actingAs($user)->delete("/dashboard/harga-pangan/{$pangan->id}");

    // Memastikan respons redirect ke halaman yang benar
    $response->assertRedirect('/dashboard/harga-pangan');

});

test('Ekspor data menjadi file xlsx', function () {

      // Membuat pengguna baru dan autentikasi
      $user = User::factory()->create([
        'password' => Hash::make('password')
      ]);
      $this->actingAs($user);

      // Membuat instance request
      $request = new \Illuminate\Http\Request();

      // Melakukan permintaan ekspor
      $response = $this->get('/export', $request->toArray());

      // Memeriksa bahwa respons adalah instance dari Excel download
      $response->assertStatus(200);
      $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

});

