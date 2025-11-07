<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_customer' => $this->faker->company(),
            'perusahaan_cust' => $this->faker->company() . ' ' . $this->faker->companySuffix(),
            'alamat' => $this->faker->address(),
        ];
    }
}
