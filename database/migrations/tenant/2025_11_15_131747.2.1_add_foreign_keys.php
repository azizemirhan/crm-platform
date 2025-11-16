<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->foreign('lead_id')->references('id')->on('leads')->nullOnDelete();
            $table->foreign('competitor_lost_to')->references('id')->on('accounts')->nullOnDelete();
        });
        
        Schema::table('leads', function (Blueprint $table) {
            $table->foreign('converted_contact_id')->references('id')->on('contacts')->nullOnDelete();
            $table->foreign('converted_account_id')->references('id')->on('accounts')->nullOnDelete();
            $table->foreign('converted_opportunity_id')->references('id')->on('opportunities')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropForeign(['lead_id']);
            $table->dropForeign(['competitor_lost_to']);
        });
        
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['converted_contact_id']);
            $table->dropForeign(['converted_account_id']);
            $table->dropForeign(['converted_opportunity_id']);
        });
    }
};