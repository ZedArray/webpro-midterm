<?php

namespace Database\Factories;

use Carbon\Carbon;
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

        static $startDate;

        if (!$startDate) {
            $startDate = Carbon::now()->subDays(30); // Start 30 days ago
        } else {
            $startDate = $startDate->addDay(); // Increment each new expense by 1 day
        }

        return [
            'amount' => $this->faker->randomFloat(0, 10000, 500000), // Random amount between 5 and 1000
            'description' => $this->faker->sentence(3), // Random description
            'category' => $this->faker->randomElement(['Food', 'Transport', 'Entertainment', 'Shopping']),
            'date' => $startDate->format('Y-m-d'),
        ];
    }
}
