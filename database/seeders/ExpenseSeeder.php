<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\Vehicle;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $mockExpenses = [
            ['tanggal' => '2024-02-01', 'kodePengeluaran' => 'B-01', 'keterangan' => 'Solar Full Tank', 'nominal' => 1850000],
            ['tanggal' => '2024-02-02', 'kodePengeluaran' => 'U-01', 'keterangan' => 'Upah Sopir Luar Kota', 'nominal' => 800000],
            ['tanggal' => '2024-02-03', 'kodePengeluaran' => 'B-07', 'keterangan' => 'Ganti Ban Depan', 'nominal' => 2200000],
            ['tanggal' => '2024-02-04', 'kodePengeluaran' => 'B-08', 'keterangan' => 'Oli Mesin Shell', 'nominal' => 550000],
            ['tanggal' => '2024-02-05', 'kodePengeluaran' => 'T-02', 'keterangan' => 'Retribusi Terminal', 'nominal' => 30000],
            ['tanggal' => '2024-02-06', 'kodePengeluaran' => 'B-03', 'keterangan' => 'Tiket Tol Trans Jawa', 'nominal' => 450000],
            ['tanggal' => '2024-02-07', 'kodePengeluaran' => 'B-01', 'keterangan' => 'Biosolar', 'nominal' => 950000],
            ['tanggal' => '2024-02-08', 'kodePengeluaran' => 'U-03', 'keterangan' => 'Uang Makan Driver', 'nominal' => 150000],
            ['tanggal' => '2024-02-09', 'kodePengeluaran' => 'A-01', 'keterangan' => 'DP Unit Baru', 'nominal' => 35000000],
            ['tanggal' => '2024-02-10', 'kodePengeluaran' => 'S-01', 'keterangan' => 'Sewa Trip Jogja', 'nominal' => 12000000],
        ];

        foreach ($mockExpenses as $e) {

            $categoryId = ExpenseCategory::where('code', $e['kodePengeluaran'])->value('id');

            // create expense record (no direct vehicle_id)
            $expense = Expense::create([
                'date' => $e['tanggal'],
                'description' => $e['keterangan'],
                'nominal' => $e['nominal'],
                'expense_category_id' => $categoryId,
            ]);

            // attach between 1 and 3 random vehicles to this expense via pivot
            $vehicleCount = Vehicle::count();
            if ($vehicleCount > 0) {
                $pick = rand(1, min(3, $vehicleCount));
                $vehicleIds = Vehicle::inRandomOrder()->take($pick)->pluck('id')->toArray();
                $expense->vehicles()->attach($vehicleIds);
            }
        }
    }


}