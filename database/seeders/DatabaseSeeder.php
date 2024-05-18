<?php

namespace Database\Seeders;
use App\Models\Satuan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $faker = Faker::create();

        for ($i = 0; $i < 100000; $i++) {
        Satuan::create([
                    'nama' => $faker->word
                    // Tambahkan kolom lainnya sesuai kebutuhan Anda
                ]);
        }
    }
}
