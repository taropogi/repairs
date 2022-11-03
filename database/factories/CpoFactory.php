<?php

namespace Database\Factories;

use App\Models\HeaderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class CpoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_name' => $this->faker->name,
            'rpo_number' => $this->faker->numerify('##########'),
            'customer_address' => $this->faker->address,
            'contact_number' => $this->faker->numerify('0920-###-####'),
            'prepared_by' => $this->faker->name,
            'authorized_by' => $this->faker->name,
            'status_id' => 1

        ];
    }
}