<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $admin = [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '+6285155487112',
            'password' => bcrypt('password'),
        ];

        $admin = User::create($admin);
        $admin->assignRole('admin');

        $driver = [
            'name' => 'Driver',
            'email' => 'driver@gmail.com',
            'phone' => '+6285155487113',
            'password' => bcrypt('password'),
        ];

        $driver = User::create($driver);
        $driver->assignRole('driver');

        $customer = [
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'phone' => '+6285155487114',
            'password' => bcrypt('password'),
        ];

        $customer = User::create($customer);
        $customer->assignRole('customer');
    }
}
