<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aduan>
 */
class AduanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();
        return [
            'nama' => fake()->name(),
            'no_hp' => $faker->phoneNumber,
            'pasar' => fake()->name(),
            'gambar' => fake()->image(),
            'isi_aduan' => fake()->word(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
