<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faktur>
 */
class FakturFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor' => $this->faker->numberBetween(10, 1000),
            'pelanggan_id' => $this->faker->numberBetween(1, 20),
            'tanggal' => $this->faker->date,
            'batas_waktu' => $this->faker->date,
            'referensi' => 'REF-' . rand(10, 500),
            'syarat_dan_ketentuan' => $this->faker->paragraph(2),
            'sub_total' => $this->faker->numberBetween(100, 1000),
            'diskon' => $this->faker->numberBetween(10, 1000),
            'total' => $this->faker->numberBetween(20, 2000)
        ];
    }
}
