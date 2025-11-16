<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if column doesn't exist before adding
        if (!Schema::hasColumn('users', 'is_owner')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_owner')->default(false)->after('is_active');
                $table->index('is_owner');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'is_owner')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex(['is_owner']);
                $table->dropColumn('is_owner');
            });
        }
    }
};
