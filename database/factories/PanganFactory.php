<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\Komoditas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pangan>
 */
class PanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $user = User::factory()->create(['password' => Hash::make('password')]);
        return [
            'user_id' => $user->id,
            'barang_id' => Barang::factory(),
            'komoditas_id' => Komoditas::factory(),
            'satuan' => $this->faker->word,
            'pasar' => $this->faker->word,
            'harga_sebelum' => 2500,
            'harga' => 5000,
            'perubahan_rp' => 2500,
            'perubahan_persen' => 2,
            'keterangan' => 'naik',
            'periode' => now(),
        ];
    }
}
