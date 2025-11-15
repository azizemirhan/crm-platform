<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'account_id' => Account::factory(),
            'owner_id' => User::factory(),
            'salutation' => fake()->randomElement(['Mr', 'Mrs', 'Ms', 'Dr']),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'mobile' => fake()->phoneNumber(),
            'title' => fake()->jobTitle(),
            'department' => fake()->randomElement(['Sales', 'Marketing', 'IT', 'HR', 'Finance']),
            'mailing_street' => fake()->streetAddress(),
            'mailing_city' => fake()->city(),
            'mailing_state' => fake()->state(),
            'mailing_postal_code' => fake()->postcode(),
            'mailing_country' => 'TR',
            'status' => fake()->randomElement(['active', 'inactive']),
            'lead_source' => fake()->randomElement(['web_form', 'google_ads', 'referral', 'cold_call']),
            'engagement_score' => fake()->numberBetween(0, 100),
        ];
    }
}