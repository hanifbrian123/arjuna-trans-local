<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Create predefined customers
        $customers = [
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti.customer@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '+6284567890123',
            ],
            [
                'name' => 'Joko Widodo',
                'email' => 'joko.customer@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '+6285678901234',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.customer@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '+6286789012345',
            ],
            [
                'name' => 'Rudi Hartono',
                'email' => 'rudi.customer@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '+6287890123456',
            ],
            [
                'name' => 'Ani Wijaya',
                'email' => 'ani.customer@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '+6288901234567',
            ],
        ];

        foreach ($customers as $customerData) {
            $user = User::create($customerData);
            $user->assignRole('customer');
        }

        // Create additional random customers
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                $user->assignRole('customer');
            });
    }
}
