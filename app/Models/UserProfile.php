<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $casts = [
        'children' => 'array',
    ];

    protected $fillable = [
        'user_id', 'civil_status', 'height', 'weight', 'blood_type', 'gsis_id_no', 'pagibig_id_no', 'philhealth_no', 'sss_no', 'tin_no', 'agency_employee_no',
        'citizenship', 'dual_country_dropdown', 'dual_country',
        'perm_house_unit_no', 'perm_street', 'perm_barangay', 'perm_city_municipality', 'perm_province', 'perm_zipcode',
        'res_house_unit_no', 'res_street', 'res_barangay', 'res_city_municipality', 'res_province', 'res_zipcode',
        'spouse_surname', 'spouse_first_name', 'spouse_middle_name', 'spouse_name_extension', 'spouse_occupation', 'spouse_employer', 'spouse_business_address', 'spouse_telephone_no',
        'father_surname', 'father_first_name', 'father_middle_name', 'father_name_extension',
        'mother_surname', 'mother_first_name', 'mother_middle_name',
        'children', 'elementary', 'secondary', 'vocational', 'college', 'graduate',
        'eligibility', 'work_experience', 'voluntary_work', 'learning_development',
        'special_skills', 'non_academic_distinctions', 'association_memberships', 'other_information',
        
    ];
}
