<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class JobApplicationController extends Controller
{
    public function apply(Request $request, $jobId)
    {
        try {
            $user = Auth::user();
            $job = JobVacancy::findOrFail($jobId);

            // Check if user already applied for this job
            $existingApplication = JobApplication::where('user_id', $user->id)
                ->where('job_vacancy_id', $jobId)
                ->first();

            if ($existingApplication) {
                return redirect()->back()->with('error', 'You have already applied for this position.');
            }

            // Create the application
            $application = JobApplication::create([
                'user_id' => $user->id,
                'job_vacancy_id' => $jobId,
                'status' => 'pending',
                'applied_at' => now(),
            ]);

            // Log the activity
            ActivityLog::create([
                'user_id' => $user->id,
                'user_name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'ip_address' => $request->ip(),
                'device' => $request->header('User-Agent'),
                'activity' => 'Applied for job: ' . $job->position_title,
                'role' => $user->role,
            ]);

            return redirect()->back()->with('success', 'Application submitted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit application. Please try again.');
        }
    }
} 