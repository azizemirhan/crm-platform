<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\Activity;
use App\Models\Task;
use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $team = Team::where('slug', 'acme-corporation')->first();
        $users = User::where('team_id', $team->id)->get();
        $salesManager = User::where('email', 'ahmet@crmplatform.test')->first();
        $salesRep1 = User::where('email', 'ayse@crmplatform.test')->first();
        $salesRep2 = User::where('email', 'mehmet@crmplatform.test')->first();

        // Create Tags
        $tags = [
            ['name' => 'VIP', 'slug' => 'vip', 'color' => '#f59e0b', 'category' => 'priority'],
            ['name' => 'Hot Lead', 'slug' => 'hot-lead', 'color' => '#ef4444', 'category' => 'status'],
            ['name' => 'Enterprise', 'slug' => 'enterprise', 'color' => '#8b5cf6', 'category' => 'segment'],
            ['name' => 'SMB', 'slug' => 'smb', 'color' => '#3b82f6', 'category' => 'segment'],
            ['name' => 'Technology', 'slug' => 'technology', 'color' => '#10b981', 'category' => 'industry'],
            ['name' => 'Retail', 'slug' => 'retail', 'color' => '#06b6d4', 'category' => 'industry'],
        ];

        foreach ($tags as $tagData) {
            Tag::create(array_merge($tagData, ['team_id' => $team->id]));
        }

        // Create Accounts
        $accounts = [
            [
                'name' => 'TechCorp Solutions',
                'legal_name' => 'TechCorp Solutions Ltd. Şti.',
                'tax_number' => '1234567890',
                'website' => 'https://techcorp.example.com',
                'email' => 'info@techcorp.example.com',
                'phone' => '+90 212 555 1234',
                'industry' => 'Technology',
                'type' => 'customer',
                'size' => '51-200',
                'annual_revenue' => 5000000,
                'billing_city' => 'Istanbul',
                'billing_country' => 'TR',
            ],
            [
                'name' => 'RetailMart Inc',
                'legal_name' => 'RetailMart Perakende A.Ş.',
                'tax_number' => '0987654321',
                'website' => 'https://retailmart.example.com',
                'email' => 'contact@retailmart.example.com',
                'phone' => '+90 216 555 5678',
                'industry' => 'Retail',
                'type' => 'prospect',
                'size' => '201-500',
                'annual_revenue' => 12000000,
                'billing_city' => 'Ankara',
                'billing_country' => 'TR',
            ],
            [
                'name' => 'FinanceHub',
                'legal_name' => 'FinanceHub Finansal Hizmetler A.Ş.',
                'tax_number' => '5555666677',
                'website' => 'https://financehub.example.com',
                'email' => 'info@financehub.example.com',
                'phone' => '+90 312 555 9012',
                'industry' => 'Finance',
                'type' => 'customer',
                'size' => '11-50',
                'annual_revenue' => 2500000,
                'billing_city' => 'Izmir',
                'billing_country' => 'TR',
            ],
        ];

        $createdAccounts = [];
        foreach ($accounts as $accountData) {
            $createdAccounts[] = Account::create(array_merge($accountData, [
                'team_id' => $team->id,
                'owner_id' => $users->random()->id,
            ]));
        }

        // Create Contacts
        $contacts = [
            [
                'first_name' => 'Ali',
                'last_name' => 'Veli',
                'email' => 'ali.veli@techcorp.example.com',
                'phone' => '+90 532 111 2233',
                'mobile' => '+90 532 111 2233',
                'title' => 'CEO',
                'department' => 'Executive',
                'status' => 'active',
                'lead_source' => 'Referral',
            ],
            [
                'first_name' => 'Fatma',
                'last_name' => 'Şahin',
                'email' => 'fatma.sahin@retailmart.example.com',
                'phone' => '+90 533 222 3344',
                'mobile' => '+90 533 222 3344',
                'title' => 'Procurement Manager',
                'department' => 'Operations',
                'status' => 'active',
                'lead_source' => 'Website',
            ],
            [
                'first_name' => 'Can',
                'last_name' => 'Yılmaz',
                'email' => 'can.yilmaz@financehub.example.com',
                'phone' => '+90 534 333 4455',
                'mobile' => '+90 534 333 4455',
                'title' => 'CTO',
                'department' => 'Technology',
                'status' => 'active',
                'lead_source' => 'LinkedIn',
            ],
        ];

        $createdContacts = [];
        foreach ($contacts as $index => $contactData) {
            $createdContacts[] = Contact::create(array_merge($contactData, [
                'team_id' => $team->id,
                'account_id' => $createdAccounts[$index]->id,
                'owner_id' => $users->random()->id,
            ]));
        }

        // Create Leads
        $leads = [
            [
                'first_name' => 'Emre',
                'last_name' => 'Koç',
                'email' => 'emre.koc@example.com',
                'phone' => '+90 535 444 5566',
                'company' => 'StartupCo',
                'title' => 'Founder',
                'source' => 'google_ads',
                'status' => 'new',
                'rating' => 'hot',
                'score' => 85,
                'budget' => 50000,
            ],
            [
                'first_name' => 'Selin',
                'last_name' => 'Aydın',
                'email' => 'selin.aydin@example.com',
                'phone' => '+90 536 555 6677',
                'company' => 'GrowthLabs',
                'title' => 'Marketing Director',
                'source' => 'linkedin',
                'status' => 'contacted',
                'rating' => 'warm',
                'score' => 65,
                'budget' => 75000,
            ],
        ];

        foreach ($leads as $leadData) {
            Lead::create(array_merge($leadData, [
                'team_id' => $team->id,
                'owner_id' => $users->random()->id,
            ]));
        }

        // Create Opportunities
        $opportunities = [
            [
                'name' => 'TechCorp - Q4 Software License',
                'amount' => 150000,
                'stage' => 'proposal',
                'probability' => 60,
                'expected_close_date' => now()->addDays(30),
                'type' => 'new_business',
            ],
            [
                'name' => 'RetailMart - CRM Implementation',
                'amount' => 85000,
                'stage' => 'negotiation',
                'probability' => 75,
                'expected_close_date' => now()->addDays(15),
                'type' => 'new_business',
            ],
        ];

        $createdOpportunities = [];
        foreach ($opportunities as $index => $oppData) {
            $createdOpportunities[] = Opportunity::create(array_merge($oppData, [
                'team_id' => $team->id,
                'account_id' => $createdAccounts[$index]->id,
                'contact_id' => $createdContacts[$index]->id,
                'owner_id' => $users->random()->id,
            ]));
        }

        // Create Activities
        foreach ($createdContacts as $contact) {
            Activity::create([
                'team_id' => $team->id,
                'subject_type' => Contact::class,
                'subject_id' => $contact->id,
                'user_id' => $users->random()->id,
                'type' => 'call',
                'direction' => 'outbound',
                'status' => 'completed',
                'title' => 'Initial Discovery Call',
                'description' => 'Discussed potential needs and solution fit.',
                'duration' => 30,
                'completed_at' => now()->subDays(rand(1, 7)),
            ]);
        }

        // Create Tasks
        foreach ($users->take(3) as $user) {
            Task::create([
                'team_id' => $team->id,
                'assigned_to_id' => $user->id,
                'created_by_id' => $salesManager->id,
                'title' => 'Follow up with pending leads',
                'description' => 'Review and contact all pending leads from last week.',
                'priority' => 'high',
                'status' => 'not_started',
                'due_date' => now()->addDays(2),
            ]);
        }

        $this->command->info('Sample data created successfully!');
    }
}