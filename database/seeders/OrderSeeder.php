<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Get some customers, drivers, and vehicles to use in predefined orders
        $customers = User::role('customer')->get();
        $drivers = Driver::with('user')->where('status', 'active')->get();
        $vehicles = Vehicle::where('status', 'ready')->get();

        if ($customers->isEmpty() || $drivers->isEmpty() || $vehicles->isEmpty()) {
            $this->command->info('Skipping predefined orders due to missing data. Run customer, driver, and vehicle seeders first.');
            return;
        }

        // Check if user_id and driver_id columns exist in the orders table
        $hasUserIdColumn = Schema::hasColumn('orders', 'user_id');
        $hasDriverIdColumn = Schema::hasColumn('orders', 'driver_id');

        // Create predefined orders
        $orders = [
            [
                'name' => $customers[0]->name,
                'phone_number' => $customers[0]->phone,
                'address' => 'Jl. Gatot Subroto No. 123, Jakarta Selatan',
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(7),
                'pickup_address' => 'Jl. Gatot Subroto No. 123, Jakarta Selatan',
                'destination' => 'Bandung, Jawa Barat',
                'route' => 'Jakarta - Puncak - Bandung',
                'vehicle_count' => 1,
                'vehicle_type' => $vehicles[0]->type,
                'driver_name' => $drivers[0]->user->name,
                'rental_price' => 2500000,
                'down_payment' => 1000000,
                'remaining_cost' => 1500000,
                'status' => 'waiting',
                'additional_notes' => 'Perjalanan wisata keluarga',
            ],
            [
                'name' => $customers[1]->name,
                'phone_number' => $customers[1]->phone,
                'address' => 'Jl. Sudirman No. 45, Jakarta Pusat',
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(3),
                'pickup_address' => 'Jl. Sudirman No. 45, Jakarta Pusat',
                'destination' => 'Yogyakarta',
                'route' => 'Jakarta - Semarang - Yogyakarta',
                'vehicle_count' => 2,
                'vehicle_type' => $vehicles[1]->type,
                'driver_name' => $drivers[1]->user->name,
                'rental_price' => 5000000,
                'down_payment' => 2000000,
                'remaining_cost' => 3000000,
                'status' => 'approved',
                'additional_notes' => 'Perjalanan dinas perusahaan',
            ],
            [
                'name' => $customers[2]->name,
                'phone_number' => $customers[2]->phone,
                'address' => 'Jl. Thamrin No. 67, Jakarta Pusat',
                'start_date' => now()->subDays(10),
                'end_date' => now()->subDays(8),
                'pickup_address' => 'Jl. Thamrin No. 67, Jakarta Pusat',
                'destination' => 'Surabaya',
                'route' => 'Jakarta - Semarang - Surabaya',
                'vehicle_count' => 1,
                'vehicle_type' => $vehicles[2]->type,
                'driver_name' => $drivers[0]->user->name,
                'rental_price' => 4500000,
                'down_payment' => 2000000,
                'remaining_cost' => 2500000,
                'status' => 'canceled',
                'additional_notes' => 'Dibatalkan karena perubahan jadwal',
            ],
        ];

        // Add user_id and driver_id if the columns exist
        if ($hasUserIdColumn) {
            $orders[0]['user_id'] = $customers[0]->id;
            $orders[1]['user_id'] = $customers[1]->id;
            $orders[2]['user_id'] = $customers[2]->id;
        }

        if ($hasDriverIdColumn) {
            $orders[0]['driver_id'] = null;
            $orders[1]['driver_id'] = $drivers[1]->id;
            $orders[2]['driver_id'] = null;
        }

        foreach ($orders as $orderData) {
            Order::create($orderData);
        }

        // Create random orders
        Order::factory()->count(15)->create();

        // Create some orders that are specifically waiting
        Order::factory()->waiting()->count(8)->create();

        // Create some orders that are specifically approved
        Order::factory()->approved()->count(5)->create();

        // Create some orders that are specifically canceled
        Order::factory()->canceled()->count(3)->create();

        // Create some orders that are in progress (current date is between start and end date)
        Order::factory()->inProgress()->count(4)->create();
    }
}
