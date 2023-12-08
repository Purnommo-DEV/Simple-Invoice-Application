<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_barang' => 'IC-1000' . rand(10, 500),
            'deskripsi' => 'Nama Produk' . rand(10, 500),
            'harga_satuan' => mt_rand(100, 1000)
        ];
    }
}
