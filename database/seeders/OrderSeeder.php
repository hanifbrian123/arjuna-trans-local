<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

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
        // $orders = [
        //     [
        //         'name' => $customers[0]->name,
        //         'phone_number' => $customers[0]->phone,
        //         'address' => 'Jl. Gatot Subroto No. 123, Jakarta Selatan',
        //         'start_date' => now()->addDays(5),
        //         'end_date' => now()->addDays(7),
        //         'pickup_address' => 'Jl. Gatot Subroto No. 123, Jakarta Selatan',
        //         'destination' => 'Bandung, Jawa Barat',
        //         'route' => 'Jakarta - Puncak - Bandung',
        //         'vehicle_count' => 1,
        //         'vehicle_type' => $vehicles[0]->type,
        //         'driver_name' => $drivers[0]->user->name,
        //         'rental_price' => 2500000,
        //         'down_payment' => 1000000,
        //         'remaining_cost' => 1500000,
        //         'status' => 'waiting',
        //         'additional_notes' => 'Perjalanan wisata keluarga',
        //     ],
        //     [
        //         'name' => $customers[1]->name,
        //         'phone_number' => $customers[1]->phone,
        //         'address' => 'Jl. Sudirman No. 45, Jakarta Pusat',
        //         'start_date' => now()->subDays(2),
        //         'end_date' => now()->addDays(3),
        //         'pickup_address' => 'Jl. Sudirman No. 45, Jakarta Pusat',
        //         'destination' => 'Yogyakarta',
        //         'route' => 'Jakarta - Semarang - Yogyakarta',
        //         'vehicle_count' => 2,
        //         'vehicle_type' => $vehicles[1]->type,
        //         'driver_name' => $drivers[1]->user->name,
        //         'rental_price' => 5000000,
        //         'down_payment' => 2000000,
        //         'remaining_cost' => 3000000,
        //         'status' => 'approved',
        //         'additional_notes' => 'Perjalanan dinas perusahaan',
        //     ],
        //     [
        //         'name' => $customers[2]->name,
        //         'phone_number' => $customers[2]->phone,
        //         'address' => 'Jl. Thamrin No. 67, Jakarta Pusat',
        //         'start_date' => now()->subDays(10),
        //         'end_date' => now()->subDays(8),
        //         'pickup_address' => 'Jl. Thamrin No. 67, Jakarta Pusat',
        //         'destination' => 'Surabaya',
        //         'route' => 'Jakarta - Semarang - Surabaya',
        //         'vehicle_count' => 1,
        //         'vehicle_type' => $vehicles[2]->type,
        //         'driver_name' => $drivers[0]->user->name,
        //         'rental_price' => 4500000,
        //         'down_payment' => 2000000,
        //         'remaining_cost' => 2500000,
        //         'status' => 'canceled',
        //         'additional_notes' => 'Dibatalkan karena perubahan jadwal',
        //     ],
        // ];

        // // Add user_id and driver_id if the columns exist
        // if ($hasUserIdColumn) {
        //     $orders[0]['user_id'] = $customers[0]->id;
        //     $orders[1]['user_id'] = $customers[1]->id;
        //     $orders[2]['user_id'] = $customers[2]->id;
        // }

        // if ($hasDriverIdColumn) {
        //     $orders[0]['driver_id'] = null;
        //     $orders[1]['driver_id'] = $drivers[1]->id;
        //     $orders[2]['driver_id'] = null;
        // }

        // foreach ($orders as $orderData) {
        //     Order::create($orderData);
        // }

        // Manually add realistic sample orders (from provided example)
        $manualOrders = [
            [
                'order_num' => 'ORD-20260506-005',
                'name' => 'PUPUT INDAH SARI',
                'phone_number' => '-',
                'address' => 'Pantai Malang Selatan',
                'start_date' => now()->create(2026,5,10),
                'end_date' => now()->create(2026,5,11),
                'pickup_address' => 'Pantai Malang Selatan',
                'destination' => 'PANTAI MALANG SELATAN',
                'route' => 'Surabaya - Malang - Pantai Malang Selatan',
                'vehicle_count' => 2,
                'rental_price' => 1600000,
                'down_payment' => 50000,
                'remaining_cost' => 0,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20260506-006',
                'name' => 'FAIZIN',
                'phone_number' => '-',
                'address' => 'Jogoroto',
                'start_date' => now()->create(2026,6,12),
                'end_date' => now()->create(2026,6,12),
                'pickup_address' => 'Jogoroto',
                'destination' => 'JOGOROTO',
                'route' => 'Surabaya - Jombang - Jogoroto',
                'vehicle_count' => 3,
                'rental_price' => 500000,
                'down_payment' => 400000,
                'remaining_cost' => 100000,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20250508-005',
                'name' => 'ZUBAID NGORO',
                'phone_number' => '085854220995',
                'address' => 'Lamongan',
                'start_date' => now()->create(2025,5,25),
                'end_date' => now()->create(2025,5,25),
                'pickup_address' => 'Lamongan',
                'destination' => 'LAMONGAN',
                'route' => 'Surabaya - Gresik - Lamongan',
                'vehicle_count' => 1,
                'rental_price' => 2400000,
                'down_payment' => 100000,
                'remaining_cost' => 2300000,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20250508-006',
                'name' => 'Bpk Agung',
                'phone_number' => '085706542709',
                'address' => 'Iring-Iring',
                'start_date' => now()->create(2025,6,17),
                'end_date' => now()->create(2025,6,17),
                'pickup_address' => 'Iring-Iring',
                'destination' => 'Ir­ing-Iring',
                'route' => 'Surabaya - Sidoarjo - Iring-Iring',
                'vehicle_count' => 4,
                'rental_price' => 450000,
                'down_payment' => 50000,
                'remaining_cost' => 400000,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20250508-007',
                'name' => 'ZUBAID NGORO',
                'phone_number' => '085854220995',
                'address' => 'PONOROGO',
                'start_date' => now()->create(2025,5,11),
                'end_date' => now()->create(2025,5,12),
                'pickup_address' => 'Ponorogo',
                'destination' => 'PONOROGO',
                'route' => 'Surabaya - Madiun - Ponorogo',
                'vehicle_count' => 1,
                'rental_price' => 4200000,
                'down_payment' => 250000,
                'remaining_cost' => 0,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20250508-009',
                'name' => 'ZUBAID NGORO',
                'phone_number' => '085854220995',
                'address' => 'Jepara',
                'start_date' => now()->create(2025,6,12),
                'end_date' => now()->create(2025,6,12),
                'pickup_address' => 'Jepara',
                'destination' => 'Jepara',
                'route' => 'Semarang - Demak - Jepara',
                'vehicle_count' => 2,
                'rental_price' => 5300000,
                'down_payment' => 250000,
                'remaining_cost' => 5050000,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20250508-010',
                'name' => 'ZUBAID NGORO',
                'phone_number' => '085854220995',
                'address' => 'Surabaya',
                'start_date' => now()->create(2025,5,27),
                'end_date' => now()->create(2025,5,27),
                'pickup_address' => 'Surabaya',
                'destination' => 'Surabaya',
                'route' => 'Surabaya - Surabaya',
                'vehicle_count' => 1,
                'rental_price' => 1100000,
                'down_payment' => 100000,
                'remaining_cost' => 1000000,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20250508-011',
                'name' => 'Purwanto / M Akbar Firmansyah',
                'phone_number' => '-',
                'address' => 'Tulungagung Kota',
                'start_date' => now()->create(2025,6,7),
                'end_date' => now()->create(2025,6,8),
                'pickup_address' => 'Tulungagung',
                'destination' => 'Tulungagung Kota',
                'route' => 'Surabaya - Tulungagung',
                'vehicle_count' => 3,
                'rental_price' => 7000000,
                'down_payment' => 1500000,
                'remaining_cost' => 5500000,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20250509-002',
                'name' => 'ANANDA ALIF',
                'phone_number' => '081938845765',
                'address' => 'JOGJA',
                'start_date' => now()->create(2025,5,9),
                'end_date' => now()->create(2025,5,9),
                'pickup_address' => 'Jogja',
                'destination' => 'JOGJA',
                'route' => 'Yogyakarta - Jogja',
                'vehicle_count' => 1,
                'rental_price' => 3000000,
                'down_payment' => 100000,
                'remaining_cost' => 2900000,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20250512-001',
                'name' => 'Mbah Oyoh',
                'phone_number' => '+62 858-3162-7903',
                'address' => 'Karanganyar dan Solo',
                'start_date' => now()->create(2025,6,28),
                'end_date' => now()->create(2025,6,28),
                'pickup_address' => 'Karanganyar',
                'destination' => 'Karanganyar dan Solo',
                'route' => 'Solo - Karanganyar - Solo',
                'vehicle_count' => 1,
                'rental_price' => 4300000,
                'down_payment' => 500000,
                'remaining_cost' => 3800000,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20250515-002',
                'name' => 'Diki',
                'phone_number' => '085731659270',
                'address' => 'Jls',
                'start_date' => now()->create(2025,6,7),
                'end_date' => now()->create(2025,6,8),
                'pickup_address' => 'Jls',
                'destination' => 'Jls',
                'route' => 'Local',
                'vehicle_count' => 1,
                'rental_price' => 2800000,
                'down_payment' => 200000,
                'remaining_cost' => 2600000,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20250518-001',
                'name' => 'H. Ashari',
                'phone_number' => '+6285608681925',
                'address' => 'Jember',
                'start_date' => now()->create(2025,5,18),
                'end_date' => now()->create(2025,5,18),
                'pickup_address' => 'Jember',
                'destination' => 'Jember',
                'route' => 'Banyuwangi - Jember',
                'vehicle_count' => 2,
                'rental_price' => 3300000,
                'down_payment' => 0,
                'remaining_cost' => 3300000,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20250524-001',
                'name' => 'Hamzah',
                'phone_number' => '085854220995',
                'address' => 'Kediri',
                'start_date' => now()->create(2025,8,10),
                'end_date' => now()->create(2025,8,10),
                'pickup_address' => 'Kediri',
                'destination' => 'Kediri',
                'route' => 'Surabaya - Kediri',
                'vehicle_count' => 1,
                'rental_price' => 2300000,
                'down_payment' => 100000,
                'remaining_cost' => 2200000,
                'status' => 'approved',
            ],
            [
                'order_num' => 'ORD-20250524-002',
                'name' => 'M Aqil KH',
                'phone_number' => '+62 857-3199-9470',
                'address' => 'blitar',
                'start_date' => now()->create(2025,5,29),
                'end_date' => now()->create(2025,5,29),
                'pickup_address' => 'Blitar',
                'destination' => 'blitar',
                'route' => 'Surabaya - Blitar',
                'vehicle_count' => 2,
                'rental_price' => 2200000,
                'down_payment' => 500000,
                'remaining_cost' => 1700000,
                'status' => 'approved',
            ],
        ];

        foreach ($manualOrders as $m) {
            // copy base structure and attach user/driver if available
            $data = $m;

            if ($hasUserIdColumn) {
                $data['user_id'] = $customers->random()->id;
            }

            if ($hasDriverIdColumn) {
                $driver = $drivers->random();
                $data['driver_id'] = $driver->id;
                $data['driver_name'] = $driver->user->name;
            }

            // Ensure vehicle_type is present (DB requires it) and determine vehicles to attach
            $attachVehicleIds = [];
            if ($vehicles->isNotEmpty()) {
                $attachCount = isset($m['vehicle_count']) ? min($m['vehicle_count'], $vehicles->count()) : 1;
                // Use collection shuffle() since $vehicles is a Collection (not a query builder)
                $attachVehicleIds = $vehicles->shuffle()->take($attachCount)->pluck('id')->toArray();

                // set primary vehicle_type from the first attached vehicle
                $primaryVehicle = Vehicle::find($attachVehicleIds[0]);
                if ($primaryVehicle) {
                    $data['vehicle_type'] = $primaryVehicle->type;
                }
            } else {
                // fallback default
                $data['vehicle_type'] = $data['vehicle_type'] ?? 'Unknown';
            }

            $data['created_at'] = Carbon::parse($data['start_date'])->subDays(rand(3, 14));

            $order = Order::create($data);

            // attach determined vehicle(s)
            if (!empty($attachVehicleIds)) {
                $order->vehicles()->attach($attachVehicleIds);
            }
        }
    }
}
