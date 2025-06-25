<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->string('position_code')->unique();
            $table->string('division');
            $table->string('region');
            $table->decimal('monthly_salary', 10, 2)->nullable();
            $table->string('education')->nullable();
            $table->string('training')->nullable();
            $table->string('experience')->nullable();
            $table->string('eligibility')->nullable();
            $table->json('benefits')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->date('date_posted')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
}; 