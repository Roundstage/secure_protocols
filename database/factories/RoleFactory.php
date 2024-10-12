<?php

namespace Database\Factories;

use App\Enums\RolesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->jobTitle,
            'level' => fake()->randomElement(RolesEnum::cases()),
        ];
    }
}
