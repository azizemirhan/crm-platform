<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $acmeTeam = Team::where('slug', 'acme-corporation')->first();
        $demoTeam = Team::where('slug', 'demo-team')->first();

        // Super Admin User
        $superAdmin = User::create([
            'team_id' => $acmeTeam->id,
            'name' => 'Super Admin',
            'email' => 'admin@crmplatform.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'timezone' => 'Europe/Istanbul',
            'locale' => 'tr',
            'is_active' => true,
        ]);
        $superAdmin->assignRole('Super Admin');

        // Update team owner
        $acmeTeam->update(['owner_id' => $superAdmin->id]);

        // Sales Manager
        $salesManager = User::create([
            'team_id' => $acmeTeam->id,
            'name' => 'Ahmet Yılmaz',
            'email' => 'ahmet@crmplatform.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'title' => 'Sales Manager',
            'department' => 'Sales',
            'phone' => '+90 532 123 4567',
            'timezone' => 'Europe/Istanbul',
            'locale' => 'tr',
            'is_active' => true,
        ]);
        $salesManager->assignRole('Sales Manager');

        // Sales Representatives
        $salesRep1 = User::create([
            'team_id' => $acmeTeam->id,
            'name' => 'Ayşe Demir',
            'email' => 'ayse@crmplatform.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'title' => 'Senior Sales Representative',
            'department' => 'Sales',
            'phone' => '+90 532 234 5678',
            'timezone' => 'Europe/Istanbul',
            'locale' => 'tr',
            'is_active' => true,
        ]);
        $salesRep1->assignRole('Sales Representative');

        $salesRep2 = User::create([
            'team_id' => $acmeTeam->id,
            'name' => 'Mehmet Kaya',
            'email' => 'mehmet@crmplatform.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'title' => 'Sales Representative',
            'department' => 'Sales',
            'phone' => '+90 532 345 6789',
            'timezone' => 'Europe/Istanbul',
            'locale' => 'tr',
            'is_active' => true,
        ]);
        $salesRep2->assignRole('Sales Representative');

        // Marketing User
        $marketing = User::create([
            'team_id' => $acmeTeam->id,
            'name' => 'Zeynep Arslan',
            'email' => 'zeynep@crmplatform.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'title' => 'Marketing Specialist',
            'department' => 'Marketing',
            'phone' => '+90 532 456 7890',
            'timezone' => 'Europe/Istanbul',
            'locale' => 'tr',
            'is_active' => true,
        ]);
        $marketing->assignRole('Marketing');

        // Demo Team Admin
        $demoAdmin = User::create([
            'team_id' => $demoTeam->id,
            'name' => 'Demo Admin',
            'email' => 'demo@crmplatform.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'timezone' => 'Europe/Istanbul',
            'locale' => 'tr',
            'is_active' => true,
        ]);
        $demoAdmin->assignRole('Admin');

        // Update demo team owner
        $demoTeam->update(['owner_id' => $demoAdmin->id]);

        $this->command->info('Users created successfully!');
        $this->command->info('');
        $this->command->info('Login credentials:');
        $this->command->info('Super Admin: admin@crmplatform.test / password');
        $this->command->info('Sales Manager: ahmet@crmplatform.test / password');
        $this->command->info('Sales Rep 1: ayse@crmplatform.test / password');
        $this->command->info('Sales Rep 2: mehmet@crmplatform.test / password');
        $this->command->info('Marketing: zeynep@crmplatform.test / password');
        $this->command->info('Demo Admin: demo@crmplatform.test / password');
    }
}