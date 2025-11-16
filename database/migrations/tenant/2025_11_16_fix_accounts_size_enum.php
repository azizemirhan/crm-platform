<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Fix size enum values
        DB::statement("ALTER TABLE accounts DROP CONSTRAINT IF EXISTS accounts_size_check");
        DB::statement("ALTER TABLE accounts ALTER COLUMN size TYPE VARCHAR(50)");

        // Add check constraint with correct values
        DB::statement("ALTER TABLE accounts ADD CONSTRAINT accounts_size_check CHECK (size IN ('small', 'medium', 'large', 'enterprise') OR size IS NULL)");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE accounts DROP CONSTRAINT IF EXISTS accounts_size_check");
        DB::statement("ALTER TABLE accounts ALTER COLUMN size TYPE VARCHAR(50)");
        DB::statement("ALTER TABLE accounts ADD CONSTRAINT accounts_size_check CHECK (size IN ('1-10', '11-50', '51-200', '201-500', '501-1000', '1000+') OR size IS NULL)");
    }
};
