<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing settings to have proper types
        DB::table('settings')->whereNull('type')->update(['type' => 'string']);
        
        // Ensure maintenance_mode has boolean type
        DB::table('settings')
            ->where('key', 'maintenance_mode')
            ->update(['type' => 'boolean']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this migration
    }
}; 