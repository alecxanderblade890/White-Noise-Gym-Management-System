<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Member;

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
        $member = Member::inRandomOrder()->first();
        
        return [
            'date' => fake()->date('Y-m-d', '2025-01-01'), // Start date to now
            'time_in' => fake()->time(),
            'time_out' => fake()->time(),
            'member_id' => $member->id,
            'full_name' => $member->full_name,
            'payment_method' => fake()->randomElement(['None', 'Cash', 'GCash', 'Bank Transfer']),
            'payment_amount' => fake()->randomFloat(2, 100, 1000), // Random amount between 100 and 1000
            'purpose_of_visit' => fake()->randomElement(['Membership', 'Membership Term', 'Personal Trainer', 'Gym Use', 'Gym Use & Membership', 'Gym Use & Membership Term', 'Gym Use & Personal Trainer']),
            'staff_assigned' => fake()->name(),
            'upgrade_gym_access' => fake()->boolean(),
            'items_bought' => [
                'Pocari Sweat',
                'Bottled Water',
                'Black - Large',
            ],
            'notes' => fake()->text()
        ];
    }
}
