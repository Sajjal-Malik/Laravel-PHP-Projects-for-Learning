<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => bcrypt('password'),
            'age' => $this->faker->numberBetween(15, 60),
            'phoneNumber' => $this->faker->phoneNumber,
            'bio' => $this->faker->paragraph,
            'DOB' => $this->faker->date('Y-m-d'),
            'profileImage' => null,   // default null just for now

            'createdAt' => now(),
            'updatedAt' => now()
        ];
    }
}
