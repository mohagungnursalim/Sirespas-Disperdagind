<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasar>
 */
class PasarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'image' => fake()->image(),
            'tahun_pembangunan' => fake()->year(),
            'luas_lahan' => 23423,
            'sertifikat' => 'Ada',
            'kecamatan' => fake()->streetName(),
            'kelurahan' => fake()->streetName(),
            'status_pasar' => 'harian/mingguan',
            'pedagang' => 2334,
            'kios_petak' => 23425,
            'los_petak' => 234,
            'lapak_pelataran' => 2452,
            'ruko' => 34352,
            'baik' => 2352,
            'rusak' => 2342,
            'terpakai' => 2525,
            'kepala_pasar' => 33,
            'kebersihan' => 45,
            'keamanan' => 34,
            'retribusi' => 3,
            'created_at' => fake()->date(),
            'updated_at' => fake()->date()
        ];
    }
}
