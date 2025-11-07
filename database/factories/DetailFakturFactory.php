<?php

namespace Database\Factories;

use App\Models\Faktur;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailFakturFactory extends Factory
{
    public function definition(): array
    {
        return [
            'no_faktur' => Faktur::factory(),
            'id_produk' => Produk::factory(),
            'qty' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->numberBetween(10000, 500000),
        ];
    }
}
