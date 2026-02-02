<?php

namespace Database\Factories;

use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseCategoryFactory extends Factory
{
    protected $model = ExpenseCategory::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->lexify('?-??')),
            'name' => $this->faker->sentence(3),
            'pallete' => $this->faker->hexColor(),
        ];
    }
}
