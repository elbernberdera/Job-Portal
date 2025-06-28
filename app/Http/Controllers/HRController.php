<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HRController extends Controller
{
    /**
     * Show the HR dashboard.
     */
    public function dashboard()
    {
        $hr = auth()->user();

        // Job posts by this HR
        $jobCount = \App\Models\JobVacancy::where('hr_id', $hr->id)->count();

        // Applications for this HR's jobs
        $jobIds = \App\Models\JobVacancy::where('hr_id', $hr->id)->pluck('id');
        $applicationCount = \App\Models\JobApplication::whereIn('job_vacancy_id', $jobIds)->count();
        $shortlistedCount = \App\Models\JobApplication::whereIn('job_vacancy_id', $jobIds)->where('status', 'shortlisted')->count();
        $hiredCount = \App\Models\JobApplication::whereIn('job_vacancy_id', $jobIds)->where('status', 'hired')->count();

        // Chart data: Applications per month (last 6 months)
        $chartLabels = [];
        $applicationsChartData = [];
        $months = collect(range(0, 5))->map(function($i) {
            return now()->subMonths($i)->format('Y-m');
        })->reverse();
        foreach ($months as $month) {
            $chartLabels[] = date('M Y', strtotime($month.'-01'));
            $applicationsChartData[] = \App\Models\JobApplication::whereIn('job_vacancy_id', $jobIds)
                ->whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count();
        }

        // Status breakdown for pie chart
        $statusBreakdown = [
            'Pending' => \App\Models\JobApplication::whereIn('job_vacancy_id', $jobIds)->where('status', 'pending')->count(),
            'Shortlisted' => $shortlistedCount,
            'Hired' => $hiredCount,
            'Rejected' => \App\Models\JobApplication::whereIn('job_vacancy_id', $jobIds)->where('status', 'rejected')->count(),
        ];

        // Latest applications
        $latestApplications = \App\Models\JobApplication::with(['user', 'jobVacancy'])
            ->whereIn('job_vacancy_id', $jobIds)
            ->latest()
            ->take(5)
            ->get();

        // Recent activity (last 5 actions by this HR)
        $recentActivity = \App\Models\ActivityLog::where('user_id', $hr->id)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('hr.dashboard', compact(
            'jobCount',
            'applicationCount',
            'shortlistedCount',
            'hiredCount',
            'chartLabels',
            'applicationsChartData',
            'statusBreakdown',
            'latestApplications',
            'recentActivity'
        ));
    }

    public function editProfile(Request $request)
    {
        return view('hr.update_profile');
    }


    //here is the update profile hr
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('update_profile_hr')->with('success', 'Profile updated successfully!');
    }

    //create here the controller to create job vacancies can display data and add job vacancies
} 