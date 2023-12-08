<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FakturBarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'faktur_id' => $this->faker->numberBetween(100, 1000),
            'produk_id' => $this->faker->numberBetween(10, 100),
            'harga_satuan' => $this->faker->numberBetween(100, 5000),
            'kuantitas' => $this->faker->numberBetween(1, 5)
        ];
    }
}
