<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Schema;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+2 months');
        $endDate = $this->faker->dateTimeBetween(
            $startDate->format('Y-m-d H:i:s') . ' +1 day',
            $startDate->format('Y-m-d H:i:s') . ' +10 days'
        );

        $rentalPrice = $this->faker->numberBetween(500000, 5000000);
        $downPayment = $this->faker->optional(0.8)->numberBetween(100000, $rentalPrice / 2);
        $remainingCost = $downPayment ? $rentalPrice - $downPayment : $rentalPrice;

        // Get a random vehicle type
        $vehicleType = Vehicle::inRandomOrder()->first()?->type ?? 'ISUZU ELF LONG';

        // Get a random driver
        $driver = Driver::with('user')->where('status', 'active')->inRandomOrder()->first();
        $driverName = $driver?->user->name ?? 'Default Driver';

        // Get a random customer
        $customer = User::role('customer')->inRandomOrder()->first();

        // Check if user_id and driver_id columns exist in the orders table
        $hasUserIdColumn = Schema::hasColumn('orders', 'user_id');
        $hasDriverIdColumn = Schema::hasColumn('orders', 'driver_id');

        $data = [
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'pickup_address' => $this->faker->address(),
            'destination' => $this->faker->city(),
            'route' => $this->faker->paragraph(),
            'vehicle_count' => $this->faker->numberBetween(1, 5),
            'vehicle_type' => $vehicleType,
            'driver_name' => $driverName,
            'rental_price' => $rentalPrice,
            'down_payment' => $downPayment,
            'remaining_cost' => $remainingCost,
            'status' => $this->faker->randomElement(['waiting', 'approved', 'canceled']),
            'additional_notes' => $this->faker->optional(0.7)->paragraph(),
        ];

        // Add user_id and driver_id if the columns exist
        if ($hasUserIdColumn && $customer) {
            $data['user_id'] = $customer->id;
        }

        if ($hasDriverIdColumn && $driver) {
            $data['driver_id'] = $driver->id;
        }

        return $data;
    }

    /**
     * Indicate that the order is waiting.
     */
    public function waiting(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'waiting',
        ]);
    }

    /**
     * Indicate that the order is approved.
     */
    public function approved(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'approved',
        ]);
    }

    /**
     * Indicate that the order is canceled.
     */
    public function canceled(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'canceled',
        ]);
    }

    /**
     * Configure the order to be in progress (current date is between start and end date).
     */
    public function inProgress(): static
    {
        return $this->state(function (array $attributes) {
            $startDate = now()->subDays(rand(1, 3));
            $endDate = now()->addDays(rand(1, 5));

            $data = [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'approved',
            ];

            // Make sure we have a driver assigned if the column exists
            if (Schema::hasColumn('orders', 'driver_id')) {
                $driver = Driver::where('status', 'active')->inRandomOrder()->first();
                if ($driver) {
                    $data['driver_id'] = $driver->id;
                }
            }

            return $data;
        });
    }
}
