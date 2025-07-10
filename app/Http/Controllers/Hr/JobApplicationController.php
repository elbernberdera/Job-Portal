<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\JobVacancy;

class JobApplicationController extends Controller
{
    public function shortlist($id)
    {
        $application = JobApplication::findOrFail($id);
        $application->status = 'shortlisted';
        $application->save();
        return redirect()->back()->with('success', 'Applicant has been shortlisted.');
    }

    public function reject($id)
    {
        $application = JobApplication::findOrFail($id);
        $application->status = 'rejected';
        $application->save();
        return redirect()->back()->with('success', 'Applicant has been rejected.');
    }

    public function qualifiedApplicants()
    {
        $allApplicants = collect();

        // Get all open job vacancies with applications and user profiles
        $jobVacancies = JobVacancy::with(['jobApplications.user.profile'])
            ->where('status', JobVacancy::STATUS_OPEN)
            ->get();

        foreach ($jobVacancies as $job) {
            foreach ($job->jobApplications as $application) {
                $profile = $application->user->profile;
                if ($profile) {
                    $result = $profile->calculateQualificationScore($job->required_course);
                    $check = $job->checkQualification($application->user);

                    // Debug: Print everything you need
                    \Log::info('Applicant Debug', [
                        'profile_id' => $profile->id,
                        'user_id' => $application->user->id,
                        'job_id' => $job->id,
                        'job_title' => $job->job_title,
                        'job_required_course' => $job->required_course,
                        'job_min_years_experience' => $job->min_years_experience,
                        'job_required_eligibility' => $job->required_eligibility,
                        'score' => $result['score'],
                        'breakdown' => $result['breakdown'],
                        'qualified' => $check['qualified'],
                        'failed_criteria' => $check['failed_criteria'],
                        'raw_profile' => [
                            'college' => $profile->college,
                            'graduate' => $profile->graduate,
                            'work_experience' => $profile->work_experience,
                            'eligibility' => $profile->eligibility,
                            'special_skills' => $profile->special_skills,
                            'learning_development' => $profile->learning_development,
                            'non_academic_distinctions' => $profile->non_academic_distinctions,
                            'voluntary_work' => $profile->voluntary_work,
                            'association_memberships' => $profile->association_memberships,
                        ]
                    ]);

                    $allApplicants->push([
                        'job' => $job,
                        'application' => $application,
                        'score' => $result['score'],
                        'breakdown' => $result['breakdown'],
                        'percentage' => $check['percentage'] ?? 0,
                        'total_criteria' => $check['total_criteria'] ?? 100,
                        'failed_criteria' => $check['failed_criteria'] ?? [],
                        'qualified' => $check['qualified'] ?? false,
                    ]);
                }
            }
        }

        // Sort by highest percentage score
        $allApplicants = $allApplicants->sortByDesc('percentage');

        return view('hr.qualified_applicants', ['qualifiedApplicants' => $allApplicants]);
    }
} 