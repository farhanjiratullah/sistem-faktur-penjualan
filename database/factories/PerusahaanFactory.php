<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PerusahaanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_perusahaan' => $this->faker->company(),
            'alamat' => $this->faker->address(),
            'no_telp' => $this->faker->numerify('021-#######'),
            'fax' => $this->faker->numerify('021-#######'),
        ];
    }
}
