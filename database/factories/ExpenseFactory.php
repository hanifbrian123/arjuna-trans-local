<?php

namespace Database\Factories;

use App\Models\Vehicle;
use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(10),
            'nominal' => $this->faker->randomFloat(2, 10000, 1000000),
            'expense_category_id' => ExpenseCategory::factory(),
            'vehicle_id' => Vehicle::query()->inRandomOrder()->value('id') ?? null,
        ];
    }

}
