<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InterestCalculation>
 */
class InterestCalculationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::now()->subDays(rand(30, 180));
        $endDate = (clone $startDate)->addDays(rand(1, 30));

        return [
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'principal_amount' => $this->faker->numberBetween(1000, 1000000),
            'days_count' => $startDate->diffInDays($endDate) + 1,
            'calculated_interest' => $this->faker->randomFloat(2, 10, 1000),
            'interest_rate' => $this->faker->randomFloat(2, 1, 20) . '%',
        ];
    }
}
