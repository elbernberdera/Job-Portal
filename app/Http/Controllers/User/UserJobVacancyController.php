<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;

class UserJobVacancyController extends Controller
{
    // Display all open job vacancies to the user
    public function index()
    {
        // Fetch all open job vacancies from the database (exclude archived)
        $jobs = JobVacancy::where('status', 'open')
            ->where(function($query) {
                $query->whereNull('closing_date')
                      ->orWhere('closing_date', '>=', now()->toDateString());
            })
            ->latest()
            ->get();
        
        // Pass jobs to the user job vacancies view
        return view('user.job_vacancies', compact('jobs'));
    }

    // Show job details
    public function show($id)
    {
        $job = JobVacancy::findOrFail($id);
        
        // Check if job is accessible (not archived and not expired)
        if ($job->status === 'archived' || ($job->closing_date && $job->closing_date < now()->toDateString())) {
            abort(404, 'Job vacancy not found or no longer available.');
        }
        
        return view('user.job_vacancy_details', compact('job'));
    }

    // Show apply form (or handle application logic)
    public function apply($id)
    {
        $job = JobVacancy::findOrFail($id);
        $user = auth()->user();
        $profile = $user->profile;

        // Check if job is accessible for applications
        if ($job->status !== 'open' || ($job->closing_date && $job->closing_date < now()->toDateString())) {
            abort(404, 'Job vacancy is not accepting applications.');
        }

        // If profile does not exist, treat as 0% complete
        $completion = $profile ? $this->getProfileCompletion($profile) : 0;

        if ($completion < 80) {
            return redirect()->route('user.profile.edit')
                ->with('warning', 'Please complete at least 80% of your Personal Data Sheet (PDS) before applying.');
        }

        // If profile is 80% or more complete, show modal for update or proceed
        return view('user.apply_job', compact('job'));
    }

    /**
     * Helper to check if profile is empty (all fields null/empty)
     */
    protected function isProfileEmpty($profile)
    {
        $fields = \App\Models\UserProfile::requiredFields();
        foreach ($fields as $field) {
            if (!empty($profile->$field)) {
                return false; // At least one field is filled
            }
        }
        return true; // All fields are empty
    }

    /**
     * Helper to calculate profile completion percentage
     */
    protected function getProfileCompletion($profile)
    {
        $fields = \App\Models\UserProfile::requiredFields();
        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($profile->$field)) {
                $filled++;
            }
        }
        return count($fields) > 0 ? round(($filled / count($fields)) * 100) : 0;
    }

    /**
     * Display a listing of the jobs the user has applied to.
     */
    public function appliedJobs()
    {
        $userId = Auth::id();
        $appliedJobs = JobApplication::where('user_id', $userId)
            ->with('jobVacancy')
            ->get();
        return view('user.applied_jobs', compact('appliedJobs'));
    }
} 