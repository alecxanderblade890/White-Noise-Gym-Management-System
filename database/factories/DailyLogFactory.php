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
            'date' => fake()->dateTimeThisYear(),
            'time_in' => fake()->time(),
            'time_out' => fake()->time(),
            'member_id' => $member->id,
            'full_name' => $member->full_name,
            'membership_term_gym_access' => $member->membership_term_gym_access,
            'payment_method' => fake()->randomElement(['Cash', 'GCash', 'Bank Transfer']),
            'payment_amount' => fake()->randomFloat(2, 100, 1000), // Random amount between 100 and 1000
            'purpose_of_visit' => fake()->sentence(),
            'staff_assigned' => fake()->name(),
            'upgrade_gym_access' => fake()->boolean(),
            'notes' => fake()->text()
        ];
    }
}
