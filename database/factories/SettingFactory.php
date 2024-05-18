<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
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
            'text' => fake()->word(),
            'copyright' => fake()->word(),
            'alamat' => fake()->address(),
            'email' => fake()->email(),
            'telepon' => fake()->phoneNumber(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
