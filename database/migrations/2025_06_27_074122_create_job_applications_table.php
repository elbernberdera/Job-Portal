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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_vacancy_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_profile_id')->constrained('user_profiles')->onDelete('cascade');
            $table->enum('status', ['applied', 'under_review', 'shortlisted', 'interviewed', 'offered', 'hired', 'rejected', 'failed'])->default('applied');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
