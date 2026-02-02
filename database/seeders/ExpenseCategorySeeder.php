<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['code' => 'A-01', 'name' => 'Pembelian Aset Kendaraan', 'pallete' => '#a855f7'],
            ['code' => 'A-02', 'name' => 'Pembelian Aset Non-kendaraan', 'pallete' => '#a855f7'],

            ['code' => 'B-01', 'name' => 'Solar / BBM / Biosolar', 'pallete' => '#10b981'],
            ['code' => 'B-02', 'name' => 'Servis / Perawatan / Sparepart / Bengkel', 'pallete' => '#10b981'],
            ['code' => 'B-03', 'name' => 'Tol / e-Tol', 'pallete' => '#10b981'],
            ['code' => 'B-04', 'name' => 'Parkir', 'pallete' => '#10b981'],
            ['code' => 'B-05', 'name' => 'Makan Crew / Minum / Snack', 'pallete' => '#10b981'],
            ['code' => 'B-06', 'name' => 'Perlengkapan Bus', 'pallete' => '#10b981'],
            ['code' => 'B-07', 'name' => 'Ban (Baru/Tambal/Kampas)', 'pallete' => '#10b981'],
            ['code' => 'B-08', 'name' => 'Oli & Cairan', 'pallete' => '#10b981'],
            ['code' => 'B-09', 'name' => 'Donasi / Sodaqoh', 'pallete' => '#10b981'],
            ['code' => 'B-10', 'name' => 'Lain-lain Operasional', 'pallete' => '#10b981'],

            ['code' => 'U-01', 'name' => 'Upah Supir / Driver', 'pallete' => '#fb923c'],
            ['code' => 'U-02', 'name' => 'Upah Kernet', 'pallete' => '#fb923c'],
            ['code' => 'U-03', 'name' => 'Fee Crew / Komisi / DP', 'pallete' => '#fb923c'],

            ['code' => 'T-01', 'name' => 'Pajak Kendaraan', 'pallete' => '#38bdf8'],
            ['code' => 'T-02', 'name' => 'Retribusi / Perizinan', 'pallete' => '#38bdf8'],

            ['code' => 'S-01', 'name' => 'Pemasukan Sewa Perjalanan', 'pallete' => '#f43f5e'],
            ['code' => 'S-02', 'name' => 'DP Sewa', 'pallete' => '#f43f5e'],
        ];

        foreach ($categories as $c) {
            ExpenseCategory::create($c);
        }
    }

}


