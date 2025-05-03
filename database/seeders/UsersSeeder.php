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
    }
}
