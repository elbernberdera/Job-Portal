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
                    $result = $job->checkQualification($application->user);
                    $allApplicants->push([
                        'job' => $job,
                        'application' => $application,
                        'score' => $result['score'] ?? 0,
                        'percentage' => $result['percentage'] ?? 0,
                        'total_criteria' => $result['total_criteria'] ?? 100,
                        'failed_criteria' => $result['failed_criteria'] ?? [],
                        'qualified' => $result['qualified'] ?? false,
                    ]);
                }
            }
        }

        // Sort by highest percentage score
        $allApplicants = $allApplicants->sortByDesc('percentage');

        return view('hr.qualified_applicants', ['qualifiedApplicants' => $allApplicants]);
    }
} 