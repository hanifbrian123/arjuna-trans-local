<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        // Create predefined drivers
        $drivers = [
            [
                'user' => [
                    'name' => 'Budi Santoso',
                    'email' => 'budi.driver@gmail.com',
                    'password' => bcrypt('password'),
                    'phone' => '+6281234567890',
                ],
                'driver' => [
                    'address' => 'Jl. Pahlawan No. 123, Jakarta Selatan',
                    'phone_number' => '+6281234567890',
                    'license_type' => 'B',
                    'status' => 'active',
                    'notes' => 'Experienced driver with 5+ years of service',
                ],
            ],
            [
                'user' => [
                    'name' => 'Ahmad Rizal',
                    'email' => 'ahmad.driver@gmail.com',
                    'password' => bcrypt('password'),
                    'phone' => '+6282345678901',
                ],
                'driver' => [
                    'address' => 'Jl. Merdeka No. 45, Jakarta Timur',
                    'phone_number' => '+6282345678901',
                    'license_type' => 'A',
                    'status' => 'active',
                    'notes' => 'Specialized in long-distance trips',
                ],
            ],
            [
                'user' => [
                    'name' => 'Dedi Kurniawan',
                    'email' => 'dedi.driver@gmail.com',
                    'password' => bcrypt('password'),
                    'phone' => '+6283456789012',
                ],
                'driver' => [
                    'address' => 'Jl. Sudirman No. 78, Jakarta Pusat',
                    'phone_number' => '+6283456789012',
                    'license_type' => 'B',
                    'status' => 'inactive',
                    'notes' => 'Currently on leave',
                ],
            ],
        ];

        foreach ($drivers as $driverData) {
            $user = User::create($driverData['user']);
            $user->assignRole('driver');
            
            $driverData['driver']['user_id'] = $user->id;
            Driver::create($driverData['driver']);
        }

        // Create additional random drivers
        Driver::factory()->count(8)->create();

        // Create some drivers that are specifically active
        Driver::factory()->active()->count(5)->create();

        // Create some drivers that are specifically inactive
        Driver::factory()->inactive()->count(2)->create();
    }
}
