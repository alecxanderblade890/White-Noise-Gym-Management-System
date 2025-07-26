<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DailyLogFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeThisYear(),
            'time_in' => fake()->time(),
            'time_out' => fake()->time(),
            'member_id' => fake()->numberBetween(1, 100), // Assuming you
            'full_name' => fake()->name(),
            'membership_term_gym_access' => fake()->numberBetween(1, 12), // Random number between 1-12 months
            'payment_method' => fake()->randomElement(['Cash', 'GCash', 'Bank Transfer']),
            'purpose_of_visit' => fake()->sentence(),
            'staff_assigned' => fake()->name(), // Assuming staff assigned is a string
            'upgrade_gym_access' => fake()->boolean(), // Assuming upgrade is a boolean
            'notes' => fake()->text()
        ];
    }
}
