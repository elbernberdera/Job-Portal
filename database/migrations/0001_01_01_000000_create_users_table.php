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
        Schema::create('users', function (Blueprint $table) {
             $table->id();
            $table->string('first_name')-> required();
            $table->string('middle_initial', 1)->nullable();
            $table->string('last_name');
            $table->date('birth_date');
            $table->enum('sex', ['male', 'female']);
            $table->string('phone_number');
            $table->string('place_of_birth');
            $table->string('email')->unique();
            $table->string('region');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            $table->string('street_building_unit');
            $table->string('zipcode');
            $table->integer('role')->default(3)->comment('User roles: 1=admin, 2=HR, 3=user');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
