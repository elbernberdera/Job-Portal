<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->string('min_education_level')->nullable();
            $table->string('required_course')->nullable();
            $table->integer('min_years_experience')->nullable();
            $table->string('required_eligibility')->nullable();
            $table->json('required_skills')->nullable();
            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();
            $table->string('civil_status_requirement')->nullable();
            $table->string('citizenship_requirement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->dropColumn([
                'min_education_level',
                'required_course',
                'min_years_experience',
                'required_eligibility',
                'required_skills',
                'age_min',
                'age_max',
                'civil_status_requirement',
                'citizenship_requirement',
            ]);
        });
    }
};
