<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->json('training')->nullable()->change();
            $table->json('experience')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->string('training')->nullable()->change();
            $table->string('experience')->nullable()->change();
        });
    }
}; 