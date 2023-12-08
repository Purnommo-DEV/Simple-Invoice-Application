<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PelangganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_depan' => $this->faker->name,
            'nama_belakang' => $this->faker->name,
            'email' => $this->faker->email,
            'alamat' => $this->faker->address
        ];
    }
}
