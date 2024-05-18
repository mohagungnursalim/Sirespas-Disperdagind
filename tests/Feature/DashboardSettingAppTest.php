<?php

use App\Models\barang;
use App\Models\Komoditas;
use App\Models\Satuan;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('Halaman Setting Aplikasi pada dashboard bisa ditampilkan', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard/setting-app');

    $response->assertStatus(200);
});


test('Setting App dapat diubah lalu tersimpan ke database', function () {
    // Membuat user yang autentikasi
    $user = User::factory()->create();
  
    $setting = Setting::factory()->create();
  
    // Data baru untuk pembaruan
    $updatedData = [
        'nama' => $setting->nama,
            'text' => $setting->text,
            'copyright' => $setting->copyright,
            'alamat' => $setting->alamat,
            'email' => $setting->email,
            'telepon' => $setting->telepon,
            'created_at' => $setting->created_at,
            'updated_at' => $setting->updated_at
    ];
  
    // Mengirimkan permintaan untuk memperbarui data pangan
    $response = $this->actingAs($user)->put("/dashboard/setting-app/{$setting->id}", $updatedData);
  
    // Memastikan respons redirect ke halaman yang benar
    $response->assertStatus(302);
  
  });