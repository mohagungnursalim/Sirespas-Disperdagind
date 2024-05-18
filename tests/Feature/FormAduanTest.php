<?php

use App\Models\Aduan;
use App\Models\Pasar;
use GuzzleHttp\Psr7\UploadedFile;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;

test('Halaman Form Aduan Pasar bisa ditampilkan', function () {
    $response = $this->get('/aduan-pasar');

    $response->assertStatus(200);
});

test('Aduan dapat dimasukan ke database', function() {

   $faker = Faker::create();
   $pasar = Pasar::factory()->create();

   $data = [
    'nama' => fake()->name(),
    'no_hp' => $faker->phoneNumber,
    'pasar' => $pasar->nama,
    'gambar' => fake()->image(),
    'isi_aduan' => fake()->word(),
    'created_at' => now(),
    'updated_at' => now()
   ];
    
   $response = $this->post('/aduan-pasar', $data);

   $response->assertRedirect('/aduan-pasar');

    
});
