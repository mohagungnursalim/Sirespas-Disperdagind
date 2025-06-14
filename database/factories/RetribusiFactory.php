<?php

namespace Database\Factories;

use App\Models\Pasar;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RetribusiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'pasar_id' => Pasar::factory(),
            'user_id' => User::factory(),
            'no_pembayaran' => 'INV' . now()->format('dmy') . $this->faker->unique()->randomNumber(5),
            'nama_pedagang' => $this->faker->name,
            'alamat' => $this->faker->address,
            'jenis_retribusi' => $this->faker->randomElement(['Parkir', 'Kebersihan', 'Izin Usaha', 'Pengelolaan Air', 'Penggunaan Jalan', 'Sampah', 'Keamanan', 'Perizinan Bangunan', 'Penggunaan Fasilitas Umum']),
            'jumlah_pembayaran' => $this->faker->numberBetween(10000, 100000),
            'metode_pembayaran' => $this->faker->randomElement(['Tunai', 'Transfer Bank', 'Kartu Kredit', 'Kartu Debit', 'E Wallet']),
            'keterangan' => $this->faker->randomElement(['Lunas', 'Belum Lunas']),
            'gambar' => null,
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}