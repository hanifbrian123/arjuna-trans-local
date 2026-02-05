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

        // Create sample customers used by orders seeder
        $customers = [
            [
                'name' => 'PUPUT INDAH SARI',
                'email' => 'puput@example.com',
                'phone' => '-',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'FAIZIN',
                'email' => 'faizin@example.com',
                'phone' => '-',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'ZUBAID NGORO',
                'email' => 'zubaid@example.com',
                'phone' => '085854220995',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($customers as $cust) {
            $u = User::firstOrCreate(
                ['email' => $cust['email']],
                $cust
            );
            $u->assignRole('customer');
        }
    }
}
