<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class ProtocolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word() . ' protocol',
            'description' => fake()->paragraph(),
            'priority' => fake()->randomNumber(2),
        ];
    }
}
