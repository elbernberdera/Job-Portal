<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile;
        // Decode educational background fields for display
        $elementary = $profile && $profile->elementary ? json_decode($profile->elementary, true) : [];
        $secondary = $profile && $profile->secondary ? json_decode($profile->secondary, true) : [];
        $vocational = $profile && $profile->vocational ? json_decode($profile->vocational, true) : [];
        $college = $profile && $profile->college ? json_decode($profile->college, true) : [];
        $graduate = $profile && $profile->graduate ? json_decode($profile->graduate, true) : [];
        return view('user.user_profile', compact('user', 'profile', 'elementary', 'secondary', 'vocational', 'college', 'graduate'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:1',
            'suffix' => 'nullable|string|max:10',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_initial' => $request->middle_initial,
            'suffix' => $request->suffix,
        ]);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete('profile_images/' . $user->profile_image);
        }

        $imageName = time() . '.' . $request->profile_image->extension();
        $request->profile_image->storeAs('profile_images', $imageName, 'public');

        $user->profile_image = $imageName;
        $user->save();

        return back()->with('success', 'Profile image updated!');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validate and update users table (basic info)
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'sex' => 'required|string',
            'civil_status' => 'required|string',
            'citizenship' => 'required|string',
            'dual_country_dropdown' => 'nullable|string',
        ]);
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'middle_initial' => $request->input('middle_initial'),
            'suffix' => $request->input('suffix'),
            'birth_date' => $request->input('birth_date'),
            'place_of_birth' => $request->input('place_of_birth'),
            'sex' => $request->input('sex'),
        ]);

        // Prepare profile data (all fields from migration except user_id)
        $profileData = $request->only([
            'height', 'weight', 'blood_type', 'gsis_id_no', 'pagibig_id_no', 'philhealth_no', 'sss_no', 'tin_no', 'agency_employee_no',
            'citizenship', 'dual_country_dropdown', 'dual_country',
            'perm_house_unit_no', 'perm_street', 'perm_barangay', 'perm_city_municipality', 'perm_province', 'perm_zipcode',
            'res_house_unit_no', 'res_street', 'res_barangay', 'res_city_municipality', 'res_province', 'res_zipcode',
            'spouse_surname', 'spouse_first_name', 'spouse_middle_name', 'spouse_name_extension', 'spouse_occupation', 'spouse_employer', 'spouse_business_address', 'spouse_telephone_no',
            'father_surname', 'father_first_name', 'father_middle_name', 'father_name_extension',
            'mother_surname', 'mother_first_name', 'mother_middle_name',
            'children', 'elementary', 'secondary', 'vocational', 'college', 'graduate',
            'eligibility', 'work_experience', 'voluntary_work', 'learning_development',
            'special_skills', 'non_academic_distinctions', 'association_memberships', 'other_information',
            'civil_status',
            'dual_country_dropdown',
        ]);

        // Validate civil_status for profile
        $request->validate([
            'civil_status' => 'required|string',
        ]);

        // Prepare children array
        $children = [];
        $names = $request->input('children_names', []);
        $birthdates = $request->input('children_birthdates', []);
        for ($i = 0; $i < count($names); $i++) {
            if (!empty($names[$i]) || !empty($birthdates[$i])) {
                $children[] = [
                    'name' => $names[$i] ?? '',
                    'birthdate' => $birthdates[$i] ?? '',
                ];
            }
        }
        $profileData['children'] = json_encode($children);

        // Prepare eligibility array
        $eligibility = [];
        $service = $request->input('eligibility_service', []);
        $rating = $request->input('eligibility_rating', []);
        $exam_date = $request->input('eligibility_exam_date', []);
        $exam_place = $request->input('eligibility_exam_place', []);
        $license = $request->input('eligibility_license', []);
        $license_number = $request->input('eligibility_license_number', []);
        $validity = $request->input('eligibility_validity', []);
        for ($i = 0; $i < count($service); $i++) {
            if (!empty($service[$i]) || !empty($rating[$i]) || !empty($exam_date[$i]) || !empty($exam_place[$i]) || !empty($license[$i]) || !empty($license_number[$i]) || !empty($validity[$i])) {
                $eligibility[] = [
                    'service' => $service[$i] ?? '',
                    'rating' => $rating[$i] ?? '',
                    'exam_date' => $exam_date[$i] ?? '',
                    'exam_place' => $exam_place[$i] ?? '',
                    'license' => $license[$i] ?? '',
                    'license_number' => $license_number[$i] ?? '',
                    'validity' => $validity[$i] ?? '',
                ];
            }
        }
        $profileData['eligibility'] = json_encode($eligibility);

        // Collect arrays from the request
        $work_inclusive_dates = $request->input('work_inclusive_dates', []);
        $work_position_title = $request->input('work_position_title', []);
        $work_department = $request->input('work_department', []);
        $work_monthly_salary = $request->input('work_monthly_salary', []);
        $work_salary_grade = $request->input('work_salary_grade', []);
        $work_status = $request->input('work_status', []);
        $work_govt_service = $request->input('work_govt_service', []);

        $work_experience = [];
        for ($i = 0; $i < count($work_inclusive_dates); $i++) {
            $work_experience[] = [
                'inclusive_dates' => $work_inclusive_dates[$i] ?? '',
                'position_title' => $work_position_title[$i] ?? '',
                'department' => $work_department[$i] ?? '',
                'monthly_salary' => $work_monthly_salary[$i] ?? '',
                'salary_grade' => $work_salary_grade[$i] ?? '',
                'status' => $work_status[$i] ?? '',
                'govt_service' => $work_govt_service[$i] ?? '',
            ];
        }

        // Add to profile data array
        $profileData['work_experience'] = json_encode($work_experience);

        // Collect voluntary work data from the request
        $voluntary = $request->input('voluntary', []);

        // Clean up empty rows (optional, but recommended)
        $voluntary_work = [];
        foreach ($voluntary as $row) {
            // Only add if at least one field is filled
            if (
                !empty($row['organization']) ||
                !empty($row['from']) ||
                !empty($row['to']) ||
                !empty($row['hours']) ||
                !empty($row['position'])
            ) {
                $voluntary_work[] = [
                    'organization' => $row['organization'] ?? '',
                    'from' => $row['from'] ?? '',
                    'to' => $row['to'] ?? '',
                    'hours' => $row['hours'] ?? '',
                    'position' => $row['position'] ?? '',
                ];
            }
        }

        // Add to profile data array
        $profileData['voluntary_work'] = json_encode($voluntary_work);

        // Collect learning and development data from the request (section VII)
        $ld = $request->input('ld', []);

        
        $learning_development = [];
        foreach ($ld as $row) {
            if (
                !empty($row['title']) ||
                !empty($row['from']) ||
                !empty($row['to']) ||
                !empty($row['hours']) ||
                !empty($row['type']) ||
                !empty($row['sponsor'])
            ) {
                $learning_development[] = [
                    'title' => $row['title'] ?? '',
                    'from' => $row['from'] ?? '',
                    'to' => $row['to'] ?? '',
                    'hours' => $row['hours'] ?? '',
                    'type' => $row['type'] ?? '',
                    'sponsor' => $row['sponsor'] ?? '',
                ];
            }
        }
        $profileData['learning_development'] = json_encode($learning_development);

        // Save educational background as JSON
        $elementary = [
            'school_name' => $request->input('elementary_school_name'),
            'degree' => $request->input('elementary_degree'),
            'from' => $request->input('elementary_from'),
            'to' => $request->input('elementary_to'),
            'highest_level' => $request->input('elementary_highest_level'),
            'year_graduated' => $request->input('elementary_year_graduated'),
            'honors' => $request->input('elementary_honors'),
        ];
        $profileData['elementary'] = json_encode($elementary);
        $secondary = [
            'school_name' => $request->input('secondary_school_name'),
            'degree' => $request->input('secondary_degree'),
            'from' => $request->input('secondary_from'),
            'to' => $request->input('secondary_to'),
            'highest_level' => $request->input('secondary_highest_level'),
            'year_graduated' => $request->input('secondary_year_graduated'),
            'honors' => $request->input('secondary_honors'),
        ];
        $profileData['secondary'] = json_encode($secondary);
        $vocational = [
            'school_name' => $request->input('vocational_school_name'),
            'degree' => $request->input('vocational_degree'),
            'from' => $request->input('vocational_from'),
            'to' => $request->input('vocational_to'),
            'highest_level' => $request->input('vocational_highest_level'),
            'year_graduated' => $request->input('vocational_year_graduated'),
            'honors' => $request->input('vocational_honors'),
        ];
        $profileData['vocational'] = json_encode($vocational);
        $college = [
            'school_name' => $request->input('college_school_name'),
            'degree' => $request->input('college_degree'),
            'from' => $request->input('college_from'),
            'to' => $request->input('college_to'),
            'highest_level' => $request->input('college_highest_level'),
            'year_graduated' => $request->input('college_year_graduated'),
            'honors' => $request->input('college_honors'),
        ];
        $profileData['college'] = json_encode($college);
        $graduate = [
            'school_name' => $request->input('graduate_school_name'),
            'degree' => $request->input('graduate_degree'),
            'from' => $request->input('graduate_from'),
            'to' => $request->input('graduate_to'),
            'highest_level' => $request->input('graduate_highest_level'),
            'year_graduated' => $request->input('graduate_year_graduated'),
            'honors' => $request->input('graduate_honors'),
        ];
        $profileData['graduate'] = json_encode($graduate);

        // Section VIII: Special Skills and Hobbies
        $special_skills = array_filter($request->input('special_skills_hobbies', []), function($v) {
            return !empty($v);
        });
        $profileData['special_skills'] = json_encode(array_values($special_skills));

        // Section VIII: Non-Academic Distinctions / Recognition
        $distinctions = array_filter($request->input('non_academic_distinctions', []), function($v) {
            return !empty($v);
        });
        $profileData['non_academic_distinctions'] = json_encode(array_values($distinctions));

        // Section VIII: Membership in Association/Organization
        $memberships = array_filter($request->input('association_memberships', []), function($v) {
            return !empty($v);
        });
        $profileData['association_memberships'] = json_encode(array_values($memberships));

        // Section IX: Other Information
        $other_information = [
            'q35b' => $request->input('q35b'),
            'q35b_details' => $request->input('q35b_details'),
            'q35b_date_filed' => $request->input('q35b_date_filed'),
            'q35b_status' => $request->input('q35b_status'),
            'q36' => $request->input('q36'),
            'q36_details' => $request->input('q36_details'),
            'q37' => $request->input('q37'),
            'q37_details' => $request->input('q37_details'),
            'q38a' => $request->input('q38a'),
            'q38a_details' => $request->input('q38a_details'),
            'q38b' => $request->input('q38b'),
            'q38b_details' => $request->input('q38b_details'),
            'q39' => $request->input('q39'),
            'q39_details' => $request->input('q39_details'),
            'q40a' => $request->input('q40a'),
            'q40a_details' => $request->input('q40a_details'),
            'q40b' => $request->input('q40b'),
            'q40b_id' => $request->input('q40b_id'),
            'q40c' => $request->input('q40c'),
            'q40c_id' => $request->input('q40c_id'),
        ];
        $profileData['other_information'] = json_encode($other_information);

        $user->profile()->updateOrCreate(['user_id' => $user->id], $profileData);

        return redirect()->back()->with('success', 'Profile updated!');
    }
} 