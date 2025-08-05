<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
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
            'full_name' => fake()->name(),
            'photo_url' => fake()->imageUrl(200, 200, 'people', true),
            'membership_term_gym_access' => fake()->randomElement(['None', '1 month', '3 months', 'Walk in']),
            'member_type' => fake()->randomElement(['Student', 'Regular']),
            'with_pt' => fake()->randomElement(['None', '1 month']),
            'pt_start_date' => fake()->date(),
            'pt_end_date' => fake()->date(),
            'membership_start_date' => fake()->date(),
            'membership_end_date' => fake()->date(),
            'gym_access_start_date' => fake()->date(),
            'gym_access_end_date' => fake()->date(),
            'membership_term_billing_rate'=>1000,
            'with_pt_billing_rate'=>3000,
            'address'=>fake()->address(),
            'date_of_birth'=>fake()->date(),
            'id_presented'=>'ID',
            'id_number'=>fake()->numberBetween(100000, 999999),
            'email'=>fake()->email(),
            'phone_number'=>fake()->phoneNumber(),
            'emergency_contact_person'=>fake()->name(),
            'emergency_contact_number'=>fake()->phoneNumber(),
            'weight_kg'=>fake()->numberBetween(50, 200),
            'height_cm'=>fake()->numberBetween(150, 250),
            'notes'=>fake()->text(),
        ];
    }
}
