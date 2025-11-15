<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Acme Corporation',
                'slug' => 'acme-corporation',
                'description' => 'Main company team for Acme Corporation',
                'plan' => 'enterprise',
                'max_users' => 100,
                'max_contacts' => 50000,
                'settings' => [
                    'timezone' => 'Europe/Istanbul',
                    'date_format' => 'd/m/Y',
                    'currency' => 'TRY',
                    'language' => 'tr',
                ],
            ],
            [
                'name' => 'Demo Team',
                'slug' => 'demo-team',
                'description' => 'Demo team for testing purposes',
                'plan' => 'professional',
                'max_users' => 25,
                'max_contacts' => 10000,
                'trial_ends_at' => now()->addDays(30),
                'settings' => [
                    'timezone' => 'Europe/Istanbul',
                    'date_format' => 'd/m/Y',
                    'currency' => 'TRY',
                    'language' => 'tr',
                ],
            ],
        ];

        foreach ($teams as $teamData) {
            Team::create($teamData);
        }

        $this->command->info('Teams created successfully!');
    }
}