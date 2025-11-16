<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Seed tenant database (runs inside tenant context)
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            TeamSeeder::class,
            UserSeeder::class,
            SampleDataSeeder::class, // Only for development
        ]);
    }
}
