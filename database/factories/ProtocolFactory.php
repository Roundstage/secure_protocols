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
            'description' => fake()->word() . ' protocol',
            'priority' => fake()->randomNumber(2),
        ];
    }
}
