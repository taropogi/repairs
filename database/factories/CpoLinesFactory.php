<?php

namespace Database\Factories;

use App\Models\Cpo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CpoLinesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cpo_id' => Cpo::all()->random()->id,
            'line_number' => 1,
            'description' => $this->faker->text(50),
            'comments' => $this->faker->text(50),
            'price' => 34.67,
            'hcopy' => 'WL 001298',
            'qty_returned' => 60,
            'qty_inspect' => 60,
            'unit' => 'PC'
        ];
    }
}