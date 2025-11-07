<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_produk' => $this->faker->words(3, true),
            'price' => $this->faker->numberBetween(10000, 1000000),
            'satuan' => $this->faker->randomElement(['pcs', 'box', 'kg', 'liter']),
            'jenis' => $this->faker->randomElement(['Elektronik', 'Makanan', 'Pakaian', 'Alat Tulis']),
            'stock' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
