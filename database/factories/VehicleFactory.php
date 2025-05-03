<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        $vehicleTypes = [
            'ISUZU ELF LONG',
            'ISUZU ELF SHORT',
            'TOYOTA HIACE',
            'TOYOTA ALPHARD',
            'MERCEDES BENZ SPRINTER',
            'TOYOTA AVANZA',
            'TOYOTA INNOVA',
            'TOYOTA FORTUNER',
        ];

        $facilities = [
            'AC',
            'TV',
            'DVD Player',
            'Karaoke',
            'Reclining Seats',
            'Charging Port',
            'WiFi',
            'Toilet',
            'Refrigerator',
        ];

        // Randomly select 3-6 facilities
        $selectedFacilities = $this->faker->randomElements(
            $facilities,
            $this->faker->numberBetween(3, 6)
        );

        return [
            'license_plate' => $this->faker->regexify('[A-Z]{2} [0-9]{4} [A-Z]{3}'),
            'name' => $this->faker->randomElement(['Armada', 'Bus', 'Van', 'Car']) . ' ' . $this->faker->randomNumber(3, true),
            'type' => $this->faker->randomElement($vehicleTypes),
            'capacity' => $this->faker->numberBetween(4, 50),
            'facilities' => $selectedFacilities,
            'status' => $this->faker->randomElement(['ready', 'maintenance']),
        ];
    }

    /**
     * Indicate that the vehicle is ready.
     */
    public function ready(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'ready',
        ]);
    }

    /**
     * Indicate that the vehicle is under maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'maintenance',
        ]);
    }
}
