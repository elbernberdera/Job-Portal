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

    public function isComplete()
    {
        $requiredFields = [
            'civil_status', 'height', 'weight', 'blood_type', 'gsis_id_no', 'pagibig_id_no', 'philhealth_no', 'sss_no', 'tin_no', 'agency_employee_no',
            'citizenship',
            'perm_house_unit_no', 'perm_street', 'perm_barangay', 'perm_city_municipality', 'perm_province', 'perm_zipcode',
            'res_house_unit_no', 'res_street', 'res_barangay', 'res_city_municipality', 'res_province', 'res_zipcode',
            // Add more required fields as needed
        ];
        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }
        return true;
    }

    public static function requiredFields()
    {
        return [
            'civil_status', 'height', 'weight', 'blood_type', 'gsis_id_no', 'pagibig_id_no', 'philhealth_no', 'sss_no', 'tin_no', 'agency_employee_no',
            'citizenship', 'dual_country_dropdown', 'dual_country',
            'perm_house_unit_no', 'perm_street', 'perm_barangay', 'perm_city_municipality', 'perm_province', 'perm_zipcode',
            'res_house_unit_no', 'res_street', 'res_barangay', 'res_city_municipality', 'res_province', 'res_zipcode',
            // ...add more as needed
        ];
    }

   // Calculate qualification score out of 100 including course alignment
   public function calculateQualificationScore($requiredCourse = null, $minYearsExperience = null, $requiredEligibility = null, $requiredSkills = [])
   {
       $score = 0;
       $breakdown = [];

       // 1. Education Level
       if (!empty($this->graduate)) {
           $score += 15;
           $breakdown['education'] = 15;
       } elseif (!empty($this->college)) {
           $score += 10;
           $breakdown['education'] = 10;
       } else {
           $breakdown['education'] = 0;
       }

       // 2. Course/Degree Alignment
       $coursePoints = 0;
       if ($requiredCourse) {
           // Try to extract the degree/course from the college JSON
           $collegeArr = json_decode($this->college, true);
           $applicantCourse = '';
           if (is_array($collegeArr) && count($collegeArr) > 0) {
               // Try to use 'degree' or 'basic_education_degree_course'
               $applicantCourse = strtolower(trim(
                   $collegeArr['degree'] ?? $collegeArr['basic_education_degree_course'] ?? ''
               ));
           } else {
               $applicantCourse = strtolower(trim($this->college ?? ''));
           }
           $requiredCourse = strtolower(trim($requiredCourse));

           if ($applicantCourse === $requiredCourse) {
               $coursePoints = 15; // Exact match
           } elseif (strpos($applicantCourse, $requiredCourse) !== false || strpos($requiredCourse, $applicantCourse) !== false) {
               $coursePoints = 10; // Partial match
           }
           // else 0 points if no match
       }
       $score += $coursePoints;
       $breakdown['course'] = $coursePoints;

       // 3. Work Experience (2 pts per year, max 20)
       $workYears = 0;
       if (!empty($this->work_experience)) {
           $work = json_decode($this->work_experience, true);
           if (is_array($work)) {
               foreach ($work as $job) {
                   if (!empty($job['date_from']) && !empty($job['date_to'])) {
                       $start = \Carbon\Carbon::parse($job['date_from']);
                       $end = \Carbon\Carbon::parse($job['date_to']);
                       if ($end->greaterThan($start)) {
                           $workYears += $start->diffInYears($end);
                       }
                   }
               }
           }
       }
       $workPoints = min($workYears * 2, 20);
       if ($minYearsExperience !== null && $workYears < $minYearsExperience) {
           $workPoints = 0;
       }
       $score += $workPoints;
       $breakdown['work_experience'] = $workPoints;

       // 4. Eligibility (15 points if required eligibility present)
       $eligibility = json_decode($this->eligibility, true);
       $hasRequiredEligibility = false;
       if ($requiredEligibility) {
           if (is_array($eligibility)) {
               foreach ($eligibility as $item) {
                   if (isset($item['service']) && stripos($item['service'], $requiredEligibility) !== false) {
                       $hasRequiredEligibility = true;
                       break;
                   }
               }
           }
       } else {
           $hasRequiredEligibility = (is_array($eligibility) && count($eligibility) > 0);
       }
       $eligibilityPoints = $hasRequiredEligibility ? 15 : 0;
       $score += $eligibilityPoints;
       $breakdown['eligibility'] = $eligibilityPoints;

       // 5. Skills (3 pts per skill, max 15)
       $skills = json_decode($this->special_skills, true);
       $userSkills = is_array($skills) ? array_map('strtolower', $skills) : [];
       $requiredSkills = is_array($requiredSkills) ? array_map('strtolower', $requiredSkills) : [];
       $hasAllRequiredSkills = empty($requiredSkills) || !array_diff($requiredSkills, $userSkills);
       $skillPoints = is_array($skills) ? min(count($skills) * 3, 15) : 0;
       if (!$hasAllRequiredSkills) {
           $skillPoints = 0;
       }
       $score += $skillPoints;
       $breakdown['skills'] = $skillPoints;

       // 6. Training (3 pts per training, max 15)
       $training = json_decode($this->learning_development, true);
       $trainingPoints = is_array($training) ? min(count($training) * 3, 15) : 0;
       $score += $trainingPoints;
       $breakdown['training'] = $trainingPoints;

       // 7. Distinctions (1 pt each, max 5)
       $distinctions = json_decode($this->non_academic_distinctions, true);
       $distPoints = is_array($distinctions) ? min(count($distinctions), 5) : 0;
       $score += $distPoints;
       $breakdown['distinctions'] = $distPoints;

       // 8. Voluntary Work (1 pt each, max 5)
       $volWork = json_decode($this->voluntary_work, true);
       $volPoints = is_array($volWork) ? min(count($volWork), 5) : 0;
       $score += $volPoints;
       $breakdown['voluntary_work'] = $volPoints;

       // 9. Associations (1 pt each, max 5)
       $assoc = json_decode($this->association_memberships, true);
       $assocPoints = is_array($assoc) ? min(count($assoc), 5) : 0;
       $score += $assocPoints;
       $breakdown['associations'] = $assocPoints;

       return [
           'score' => $score,
           'breakdown' => $breakdown
       ];
   }
}
