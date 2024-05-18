<?php

use App\Models\Aduan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('Halaman Dashboard Aduan bisa ditampilkan', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard/aduan-masuk');

    $response->assertStatus(200);
});

test('Melakukan pencarian aduan', function () {

    // Buat user yang autentikasi
    $user = User::factory()->create();
  
    // Simulasikan pencarian dengan parameter 'filter'
    $response = $this->actingAs($user)->get('/dashboard/aduan-masuk?search=aduan sampah');
  
    // Pastikan respons berhasil
    $response->assertStatus(200);
  
});

test('Aduan masuk dapat dihapus dari database', function () {

    $user = User::factory()->create();

    // Membuat aduan baru
    $aduan = Aduan::factory()->create();

    // Mengirimkan permintaan untuk hapus data
    $response = $this->actingAs($user)->delete("/aduan-pasar/{$aduan->id}");

     
    // Memastikan respons redirect ke halaman aduan-masuk
    $response->assertRedirect('/dashboard/aduan-masuk');

});

test('Ekspor aduan menjadi file xlsx', function () {

  // Membuat pengguna baru dan autentikasi
  $user = User::factory()->create();
  $this->actingAs($user);

  // Membuat instance request
  $request = new \Illuminate\Http\Request();

  // Melakukan permintaan ekspor
  $response = $this->get('/export-aduan', $request->toArray());

  // Memeriksa bahwa respons adalah instance dari Excel download
  $response->assertStatus(200);
  $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

});

test('Kirim balasan aduan ke nomor pengadu', function() {

  $balasan = 'Ini adalah balasan aduan dari sistem GadeMart';
    $no_hp = '+6285757063915';

    // Kirim permintaan POST dengan data yang diperlukan
    $response = $this->post('/kirim-pesan-whatsapp', [
        'balasan' => $balasan,
        'no_hp' => $no_hp, // Ganti dengan nomor telepon yang sesuai
    ]);

    // Pastikan respons adalah pengalihan
    $response->assertStatus(302);

    // Dapatkan URL yang diharapkan untuk tautan WhatsApp
    $expectedUrl = "whatsapp://send?text=" . urlencode($balasan) . "&phone=$no_hp";

    // Pastikan respons diarahkan ke URL yang sesuai
    $response->assertRedirect($expectedUrl);
});