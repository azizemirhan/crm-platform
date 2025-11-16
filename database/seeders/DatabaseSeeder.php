<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the central database (NOT tenant databases)
     */
    public function run(): void
    {
        // Only seed central/super-admin data here
        // Tenant-specific seeding happens via DemoTenantSeeder or tenants:seed command
    }
}