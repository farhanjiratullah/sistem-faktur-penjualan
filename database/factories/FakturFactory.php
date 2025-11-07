<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;

class FakturFactory extends Factory
{
    public function definition(): array
    {
        return [
            'no_faktur' => 'PJ' . date('ymd') . $this->faker->unique()->numerify('####'),
            'tgl_faktur' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'id_customer' => Customer::factory(),
            'id_perusahaan' => Perusahaan::factory(),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'metode_bayar' => $this->faker->randomElement(['TUNAI', 'TRANSFER', 'KREDIT']),
            'ppn' => $this->faker->numberBetween(0, 15),
            'dp' => $this->faker->numberBetween(0, 100000),
            'grand_total' => $this->faker->numberBetween(100000, 10000000),
            'user' => 'Test User',
        ];
    }
}
