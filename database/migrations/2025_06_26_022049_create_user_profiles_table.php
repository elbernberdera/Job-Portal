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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Personal info (not in users table)
            // $table->string('suffix')->nullable(); // Removed, now only in users table
            $table->string('civil_status')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('gsis_id_no')->nullable();
            $table->string('pagibig_id_no')->nullable();
            $table->string('philhealth_no')->nullable();
            $table->string('sss_no')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('agency_employee_no')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('dual_country_dropdown')->nullable();
            $table->string('dual_country')->nullable();
            // Permanent address
            $table->string('perm_house_unit_no')->nullable();
            $table->string('perm_street')->nullable();
            $table->string('perm_barangay')->nullable();
            $table->string('perm_city_municipality')->nullable();
            $table->string('perm_province')->nullable();
            $table->string('perm_zipcode')->nullable();
            // Resident address
            $table->string('res_house_unit_no')->nullable();
            $table->string('res_street')->nullable();
            $table->string('res_barangay')->nullable();
            $table->string('res_city_municipality')->nullable();
            $table->string('res_province')->nullable();
            $table->string('res_zipcode')->nullable();
            // Section II: Family Background
            // Spouse
            $table->string('spouse_surname')->nullable();
            $table->string('spouse_first_name')->nullable();
            $table->string('spouse_middle_name')->nullable();
            $table->string('spouse_name_extension')->nullable();
            $table->string('spouse_occupation')->nullable();
            $table->string('spouse_employer')->nullable();
            $table->string('spouse_business_address')->nullable();
            $table->string('spouse_telephone_no')->nullable();
            // Father
            $table->string('father_surname')->nullable();
            $table->string('father_first_name')->nullable();
            $table->string('father_middle_name')->nullable();
            $table->string('father_name_extension')->nullable();
            // Mother
            $table->string('mother_surname')->nullable();
            $table->string('mother_first_name')->nullable();
            $table->string('mother_middle_name')->nullable();
            // Children (store as JSON array of objects: [{name, birthdate}])
            $table->json('children')->nullable();
            // Section III: Educational Background
            $table->json('elementary')->nullable();
            $table->json('secondary')->nullable();
            $table->json('vocational')->nullable();
            $table->json('college')->nullable();
            $table->json('graduate')->nullable();
            // Section IV: Civil Service Eligibility
            $table->json('eligibility')->nullable();
            // Section V: Work Experience
            $table->json('work_experience')->nullable();
            // Section VI: Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organizations
            $table->json('voluntary_work')->nullable();
            // Section VII: Learning and Development Interventions/Training Programs Attended
            $table->json('learning_development')->nullable();
            // Section VIII: Special Skills, Non-Academic Distinctions, and Association Memberships
            $table->json('special_skills')->nullable();
            $table->json('non_academic_distinctions')->nullable();
            $table->json('association_memberships')->nullable();
            // Section IX: Other Information
            $table->json('other_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
