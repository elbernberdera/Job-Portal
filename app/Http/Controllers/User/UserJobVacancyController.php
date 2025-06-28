<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobVacancy;

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
        
        // Check if job is accessible for applications
        if ($job->status !== 'open' || ($job->closing_date && $job->closing_date < now()->toDateString())) {
            abort(404, 'Job vacancy is not accepting applications.');
        }
        
        // You can return a view or handle application logic here
        return view('user.apply_job', compact('job'));
    }
} 