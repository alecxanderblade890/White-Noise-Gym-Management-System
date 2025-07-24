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
            'name' => fake()->name(),
            'photo_url' => fake()->imageUrl(200, 200, 'people', true),
            'payment_date_membership' => now(),
            'membership_term_gym_access' => fake()->numberBetween(1, 12), // Random number between 1-12 months
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'billing_rate'=>1000,
            'payment_date_gym_access'=>fake()->date(),
            'address'=>fake()->address(),
            'date_of_birth'=>fake()->date(),
            'id_presented'=>'ID',
            'id_number'=>fake()->numberBetween(100000, 999999),
            'email'=>fake()->email(),
            'phone_number'=>fake()->phoneNumber(),
            'contact_person'=>fake()->name(),
            'emergency_contact_number'=>fake()->phoneNumber(),
            'weight_kg'=>fake()->numberBetween(50, 200),
            'height_cm'=>fake()->numberBetween(150, 250),
            'notes'=>fake()->text(),
        ];
    }
}
