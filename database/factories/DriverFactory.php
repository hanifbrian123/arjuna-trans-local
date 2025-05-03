<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'address' => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
            'license_type' => $this->faker->randomElements(['A', 'B', 'C', 'D', 'E'], $this->faker->numberBetween(1, 3)),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'notes' => $this->faker->optional(0.7)->paragraph(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Driver $driver) {
            // Ensure the user has the driver role
            $driver->user->assignRole('driver');

            // Update the user's phone to match the driver's phone
            $driver->user->update(['phone' => $driver->phone_number]);
        });
    }

    /**
     * Indicate that the driver is active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the driver is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
