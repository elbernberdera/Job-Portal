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
        // Fetch all open job vacancies from the database
        $jobs = JobVacancy::where('status', 'open')->latest()->get();
        // Pass jobs to the user job vacancies view
        return view('user.job_vacancies', compact('jobs'));
    }

    // Show job details
    public function show($id)
    {
        $job = JobVacancy::findOrFail($id);
        return view('user.job_vacancy_details', compact('job'));
    }

    // Show apply form (or handle application logic)
    public function apply($id)
    {
        $job = JobVacancy::findOrFail($id);
        // You can return a view or handle application logic here
        return view('user.apply_job', compact('job'));
    }
} 