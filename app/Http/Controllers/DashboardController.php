<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

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
                // Always get the current count of open job vacancies from HR postings
                $openJobs = \App\Models\JobVacancy::where('status', 'open')->whereNotNull('hr_id')->count();
                \Log::info('Open jobs count:', ['count' => $openJobs]);
                
                // Count of jobs the user has applied for
                $appliedJobs = $user->jobApplications()->count();
                
                // Count of failed applications for the user
                $failedJobs = $user->jobApplications()->where('status', 'failed')->count();

                // Application Status Breakdown
                $statusCounts = $user->jobApplications()
                    ->selectRaw('status, COUNT(*) as count')
                    ->groupBy('status')
                    ->pluck('count', 'status');

                // Recent Applications (latest 5)
                $recentApplications = $user->jobApplications()
                    ->with('jobVacancy')
                    ->latest()
                    ->take(5)
                    ->get();

                // Profile Completion (all fields from user_profiles table)
                $profile = $user->profile;
                $profileFields = UserProfile::requiredFields();
                $filled = 0;
                if ($profile) {
                    foreach ($profileFields as $field) {
                        if (isset($profile->$field)) {
                            // For JSON fields, check if not empty array/object
                            if (is_array($profile->$field) || is_object($profile->$field)) {
                                if (!empty((array)$profile->$field)) $filled++;
                            } else {
                                if (!empty($profile->$field)) $filled++;
                            }
                        }
                    }
                }
                $profileCompletion = count($profileFields) > 0 ? round(($filled / count($profileFields)) * 100) : 0;

                // Gather user events for calendar
                $userEvents = $user->jobApplications()
                    ->with('jobVacancy')
                    ->whereIn('status', ['applied', 'interviewed', 'hired'])
                    ->orderByDesc('created_at')
                    ->get()
                    ->map(function($app) {
                        $eventType = ucfirst($app->status);
                        if ($app->status === 'applied') $eventType = 'Application Submitted';
                        if ($app->status === 'interviewed') $eventType = 'Interviewed';
                        if ($app->status === 'hired') $eventType = 'Hired';
                        return [
                            'type' => $eventType,
                            'job' => $app->jobVacancy->title ?? 'N/A',
                            'date' => $app->created_at->format('Y-m-d'),
                            'status' => ucfirst($app->status),
                        ];
                    });

                return view('user.dashboard', compact(
                    'openJobs', 'appliedJobs', 'failedJobs',
                    'statusCounts', 'recentApplications', 'profileCompletion', 'userEvents'
                ));
        }
    }
}
