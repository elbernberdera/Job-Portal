<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the dashboard based on user role.
     */
    public function index()
    {
        $user = Auth::user();

        $openJobs = JobVacancy::where('status', 'open')->count();

        dd([
            'user_role' => $user->role,
            'open_jobs_count' => $openJobs,
        ]);

        switch ($user->role) {
            case 1:
                return view('admin.dashboard');
            case 2:
                return view('hr.dashboard');
            case 3:
            default:
                // Count of open job vacancies
                $openJobs = JobVacancy::where('status', 'open')->count();
                
                // Count of jobs the user has applied for
                $appliedJobs = $user->jobApplications()->count();
                
                // Count of failed applications for the user
                $failedJobs = $user->jobApplications()->where('status', 'failed')->count();
                
                return view('user.dashboard', compact('openJobs', 'appliedJobs', 'failedJobs'));
        }
    }
}
