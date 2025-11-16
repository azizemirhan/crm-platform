<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoTenantSeeder extends Seeder
{
    public function run(): void
    {
        $this->createTenant1();
        $this->createTenant2();
    }

    private function createTenant1(): void
    {
        echo "Creating Tenant 1: Tech Solutions Ltd...\n";

        // Create tenant
        if (Tenant::where('id', 'tech-solutions')->exists()) {
            echo "  ⚠️  Tenant 'tech-solutions' already exists, skipping...\n";
            return;
        }

        $tenant = Tenant::create([
            'id' => 'tech-solutions',
            'name' => 'Tech Solutions Ltd',
            'slug' => 'tech-solutions',
            'email' => 'admin@techsolutions.com',
            'schema_name' => 'tenant_tech_solutions',
            'owner_name' => 'Sarah Johnson',
            'owner_email' => 'sarah@techsolutions.com',
            'plan' => 'professional',
            'status' => 'active',
            'max_users' => 25,
            'max_contacts' => 10000,
            'max_storage_mb' => 10000,
        ]);

        $tenant->domains()->create(['domain' => 'tech-solutions.localhost']);
        echo "  ✅ Tenant created\n";

        // Run migrations for this tenant
        echo "  🔄 Running migrations...\n";
        \Artisan::call('tenants:migrate', ['--tenants' => $tenant->id]);
        echo "  ✅ Migrations completed\n";

        // Create users and accounts within tenant context
        $tenant->run(function () {
            // Create team
            $team = Team::create([
                'name' => 'Sales Team',
                'slug' => 'sales',
            ]);

            // Create users
            $users = [
                [
                    'name' => 'Sarah Johnson',
                    'email' => 'sarah@techsolutions.com',
                    'password' => Hash::make('password'),
                    'is_owner' => true,
                    'team_id' => $team->id,
                    'title' => 'CEO',
                ],
                [
                    'name' => 'Michael Chen',
                    'email' => 'michael@techsolutions.com',
                    'password' => Hash::make('password'),
                    'team_id' => $team->id,
                    'title' => 'Sales Manager',
                ],
                [
                    'name' => 'Emma Davis',
                    'email' => 'emma@techsolutions.com',
                    'password' => Hash::make('password'),
                    'team_id' => $team->id,
                    'title' => 'Sales Representative',
                ],
            ];

            $createdUsers = collect();
            foreach ($users as $userData) {
                $user = User::create(array_merge($userData, [
                    'email_verified_at' => now(),
                ]));
                $createdUsers->push($user);
                echo "  ✅ User: {$user->name}\n";
            }

            // Create accounts
            $accounts = [
                [
                    'name' => 'Global Innovations Inc',
                    'legal_name' => 'Global Innovations Incorporated',
                    'email' => 'contact@globalinnov.com',
                    'phone' => '+1 555-0101',
                    'industry' => 'Technology',
                    'type' => 'customer',
                    'size' => 'large',
                    'employee_count' => 500,
                    'annual_revenue' => 5000000,
                    'currency' => 'USD',
                ],
                [
                    'name' => 'StartupX',
                    'email' => 'hello@startupx.com',
                    'phone' => '+1 555-0102',
                    'industry' => 'Software',
                    'type' => 'prospect',
                    'size' => 'small',
                    'employee_count' => 15,
                    'annual_revenue' => 250000,
                    'currency' => 'USD',
                ],
                [
                    'name' => 'Enterprise Corp',
                    'legal_name' => 'Enterprise Corporation',
                    'email' => 'info@entcorp.com',
                    'phone' => '+1 555-0103',
                    'industry' => 'Finance',
                    'type' => 'customer',
                    'size' => 'enterprise',
                    'employee_count' => 2000,
                    'annual_revenue' => 50000000,
                    'currency' => 'USD',
                ],
                [
                    'name' => 'Local Business Co',
                    'email' => 'contact@localbiz.com',
                    'phone' => '+1 555-0104',
                    'industry' => 'Retail',
                    'type' => 'customer',
                    'size' => 'small',
                    'employee_count' => 25,
                    'annual_revenue' => 500000,
                    'currency' => 'USD',
                ],
                [
                    'name' => 'Future Tech Partners',
                    'email' => 'partners@futuretech.com',
                    'phone' => '+1 555-0105',
                    'industry' => 'Technology',
                    'type' => 'partner',
                    'size' => 'medium',
                    'employee_count' => 150,
                    'annual_revenue' => 3000000,
                    'currency' => 'USD',
                ],
            ];

            foreach ($accounts as $index => $accountData) {
                $account = Account::create(array_merge($accountData, [
                    'team_id' => $team->id,
                    'owner_id' => $createdUsers->random()->id,
                ]));
                echo "  ✅ Account: {$account->name}\n";
            }
        });

        echo "  🎉 Tenant 1 complete!\n\n";
    }

    private function createTenant2(): void
    {
        echo "Creating Tenant 2: Creative Agency...\n";

        if (Tenant::where('id', 'creative-agency')->exists()) {
            echo "  ⚠️  Tenant 'creative-agency' already exists, skipping...\n";
            return;
        }

        $tenant = Tenant::create([
            'id' => 'creative-agency',
            'name' => 'Creative Agency',
            'slug' => 'creative-agency',
            'email' => 'admin@creativeagency.com',
            'schema_name' => 'tenant_creative_agency',
            'owner_name' => 'Alex Martinez',
            'owner_email' => 'alex@creativeagency.com',
            'plan' => 'starter',
            'status' => 'active',
            'max_users' => 5,
            'max_contacts' => 1000,
            'max_storage_mb' => 2000,
        ]);

        $tenant->domains()->create(['domain' => 'creative-agency.localhost']);
        echo "  ✅ Tenant created\n";

        // Run migrations for this tenant
        echo "  🔄 Running migrations...\n";
        \Artisan::call('tenants:migrate', ['--tenants' => $tenant->id]);
        echo "  ✅ Migrations completed\n";

        $tenant->run(function () {
            $team = Team::create([
                'name' => 'Design Team',
                'slug' => 'design',
            ]);

            $users = [
                [
                    'name' => 'Alex Martinez',
                    'email' => 'alex@creativeagency.com',
                    'password' => Hash::make('password'),
                    'is_owner' => true,
                    'team_id' => $team->id,
                    'title' => 'Creative Director',
                ],
                [
                    'name' => 'Jessica Lee',
                    'email' => 'jessica@creativeagency.com',
                    'password' => Hash::make('password'),
                    'team_id' => $team->id,
                    'title' => 'Account Manager',
                ],
                [
                    'name' => 'David Brown',
                    'email' => 'david@creativeagency.com',
                    'password' => Hash::make('password'),
                    'team_id' => $team->id,
                    'title' => 'Designer',
                ],
            ];

            $createdUsers = collect();
            foreach ($users as $userData) {
                $user = User::create(array_merge($userData, [
                    'email_verified_at' => now(),
                ]));
                $createdUsers->push($user);
                echo "  ✅ User: {$user->name}\n";
            }

            $accounts = [
                [
                    'name' => 'Fashion Boutique',
                    'email' => 'info@fashionboutique.com',
                    'phone' => '+90 555-1001',
                    'industry' => 'Fashion',
                    'type' => 'customer',
                    'size' => 'small',
                    'employee_count' => 10,
                    'annual_revenue' => 150000,
                    'currency' => 'TRY',
                ],
                [
                    'name' => 'Restaurant Chain',
                    'email' => 'contact@restchain.com',
                    'phone' => '+90 555-1002',
                    'industry' => 'Food & Beverage',
                    'type' => 'customer',
                    'size' => 'medium',
                    'employee_count' => 80,
                    'annual_revenue' => 2000000,
                    'currency' => 'TRY',
                ],
                [
                    'name' => 'Fitness Studio',
                    'email' => 'hello@fitnessstudio.com',
                    'phone' => '+90 555-1003',
                    'industry' => 'Health & Wellness',
                    'type' => 'prospect',
                    'size' => 'small',
                    'employee_count' => 5,
                    'annual_revenue' => 75000,
                    'currency' => 'TRY',
                ],
                [
                    'name' => 'Law Firm Associates',
                    'legal_name' => 'Law Firm Associates LLP',
                    'email' => 'info@lawfirm.com',
                    'phone' => '+90 555-1004',
                    'industry' => 'Legal Services',
                    'type' => 'customer',
                    'size' => 'medium',
                    'employee_count' => 45,
                    'annual_revenue' => 1500000,
                    'currency' => 'TRY',
                ],
                [
                    'name' => 'E-commerce Startup',
                    'email' => 'team@ecommerce.com',
                    'phone' => '+90 555-1005',
                    'industry' => 'E-commerce',
                    'type' => 'prospect',
                    'size' => 'small',
                    'employee_count' => 12,
                    'annual_revenue' => 300000,
                    'currency' => 'TRY',
                ],
            ];

            foreach ($accounts as $accountData) {
                $account = Account::create(array_merge($accountData, [
                    'team_id' => $team->id,
                    'owner_id' => $createdUsers->random()->id,
                ]));
                echo "  ✅ Account: {$account->name}\n";
            }
        });

        echo "  🎉 Tenant 2 complete!\n\n";
    }
}
