<?php

namespace Database\Factories;

use App\Models\User;
use App\Traits\FileUploadTrait;
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
    use FileUploadTrait;

    protected $model = User::class;

    public function definition(): array
    {
        return [
            'firstName' => $this->faker->firstName,
            'lastName'  => $this->faker->lastName,
            'userName'  => $this->faker->unique()->userName,
            'email'     => $this->faker->unique()->safeEmail,
            'empPhoto'  => $this->uploadFileFromFactory('employee.jpg', 'employee-photos'),
            'phone'     => $this->faker->phoneNumber,
            'password'  => bcrypt('password'),
            'role'      => 2,
            'status'    => 'Active',
        ];
    }
    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
