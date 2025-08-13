<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesReport>
 */
class SalesReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->date(),
            'memberships_only' => fake()->numberBetween(0, 100),
            'walk_in_regular_on_sign_up' => fake()->numberBetween(0, 100),
            'walk_in_student_on_sign_up' => fake()->numberBetween(0, 100),
            'personal_trainer_on_sign_up' => fake()->numberBetween(0, 100),
            '1_month_regular' => fake()->numberBetween(0, 100),
            '1_month_student' => fake()->numberBetween(0, 100),
            '3_months_regular' => fake()->numberBetween(0, 100),
            '3_months_student' => fake()->numberBetween(0, 100),
            'walk_in_regular' => fake()->numberBetween(0, 100),
            'walk_in_student' => fake()->numberBetween(0, 100),
            'gym_access_1_month_regular' => fake()->numberBetween(0, 100),
            'gym_access_1_month_student' => fake()->numberBetween(0, 100),
            'gym_access_3_months_regular' => fake()->numberBetween(0, 100),
            'gym_access_3_months_student' => fake()->numberBetween(0, 100),
            'personal_trainer_1_month' => fake()->numberBetween(0, 100),
            'personal_trainer_walk_in' => fake()->numberBetween(0, 100),
            'total_sales' => fake()->numberBetween(0, 100),
        ];
    }
}
