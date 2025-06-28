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
        $qualifiedApplicants = collect();
        
        // Get all job vacancies with applications
        $jobVacancies = JobVacancy::with(['jobApplications.user'])->get();
        
        foreach ($jobVacancies as $job) {
            foreach ($job->jobApplications as $application) {
                $result = $job->checkQualification($application->user);
                if ($result['qualified']) {
                    $qualifiedApplicants->push([
                        'job' => $job,
                        'application' => $application,
                        'result' => $result
                    ]);
                }
            }
        }
        
        // Sort by qualification score (highest first)
        $qualifiedApplicants = $qualifiedApplicants->sortByDesc(function ($item) {
            return $item['result']['percentage'];
        });
        
        return view('hr.qualified_applicants', compact('qualifiedApplicants'));
    }
} 