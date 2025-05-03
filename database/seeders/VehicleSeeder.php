<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        // Create predefined vehicles
        $vehicles = [
            [
                'license_plate' => 'B 1234 ABC',
                'name' => 'Isuzu Elf 01',
                'type' => 'ISUZU ELF LONG',
                'capacity' => 20,
                'facilities' => ['AC', 'TV', 'DVD Player', 'Reclining Seats', 'Charging Port'],
                'status' => 'ready',
            ],
            [
                'license_plate' => 'B 5678 DEF',
                'name' => 'Isuzu Elf 02',
                'type' => 'ISUZU ELF SHORT',
                'capacity' => 15,
                'facilities' => ['AC', 'TV', 'Reclining Seats'],
                'status' => 'ready',
            ],
            [
                'license_plate' => 'B 9012 GHI',
                'name' => 'Toyota Hiace 01',
                'type' => 'TOYOTA HIACE',
                'capacity' => 12,
                'facilities' => ['AC', 'TV', 'DVD Player', 'WiFi'],
                'status' => 'ready',
            ],
            [
                'license_plate' => 'B 3456 JKL',
                'name' => 'Toyota Alphard 01',
                'type' => 'TOYOTA ALPHARD',
                'capacity' => 7,
                'facilities' => ['AC', 'TV', 'DVD Player', 'Karaoke', 'Reclining Seats', 'WiFi', 'Refrigerator'],
                'status' => 'ready',
            ],
            [
                'license_plate' => 'B 7890 MNO',
                'name' => 'Mercedes Sprinter 01',
                'type' => 'MERCEDES BENZ SPRINTER',
                'capacity' => 16,
                'facilities' => ['AC', 'TV', 'DVD Player', 'Reclining Seats', 'WiFi', 'Toilet'],
                'status' => 'maintenance',
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }

        // Create additional random vehicles
        Vehicle::factory()->count(10)->create();

        // Create some vehicles that are specifically ready
        Vehicle::factory()->ready()->count(5)->create();

        // Create some vehicles that are specifically under maintenance
        Vehicle::factory()->maintenance()->count(3)->create();
    }
}
