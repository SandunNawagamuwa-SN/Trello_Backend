<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'group_id' => rand(1,7),
            'name' => $this->faker->text(15),
            'description' => $this->faker->text(200),
        ];
    }
}
