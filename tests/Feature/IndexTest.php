<?php

use App\Models\Barang;
use App\Models\Komoditas;

test('Halaman Index bisa ditampilkan', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('Pencarian harga barang berhasil dilakukan', function () {
    // Buat data komoditas untuk dihubungkan dengan barang
    $komoditas = Komoditas::factory()->create(['nama' => 'Komoditas Tes']);

    // Buat data barang untuk diuji
    Barang::factory()->create(['nama' => 'Barang Pertama', 'komoditas_id' => $komoditas->id]);
    Barang::factory()->create(['nama' => 'Barang Kedua', 'komoditas_id' => $komoditas->id]);

    // Mengirimkan permintaan GET dengan parameter pencarian
    $response = $this->get('/', ['search_query' => 'Jagung']);

    // Memeriksa apakah permintaan berhasil dengan status 200 OK
    $response->assertStatus(200);

});

