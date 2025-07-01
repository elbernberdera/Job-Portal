<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Log;

class JobPositionController extends Controller
{
    /**
     * Display a listing of job positions.
     */
    public function index()
    {
        $jobPositions = JobVacancy::with(['hr', 'admin', 'jobApplications.user.profile'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics for each job position
        foreach ($jobPositions as $jobPosition) {
            $applications = $jobPosition->jobApplications;
            
            // Gender statistics
            $genderStats = $applications->groupBy('user.sex')
                ->map(function ($group) {
                    return $group->count();
                });
            
            $jobPosition->gender_stats = [
                'male' => $genderStats['male'] ?? 0,
                'female' => $genderStats['female'] ?? 0,
                'total' => $applications->count()
            ];

            // Qualification statistics
            $qualifiedCount = 0;
            $notQualifiedCount = 0;
            
            foreach ($applications as $application) {
                if ($application->user && $application->user->profile) {
                    $result = $jobPosition->checkQualification($application->user);
                    if (is_array($result) && isset($result['qualified']) && $result['qualified']) {
                        $qualifiedCount++;
                    } else {
                        $notQualifiedCount++;
                    }
                } else {
                    $notQualifiedCount++;
                }
            }
            
            $jobPosition->qualification_stats = [
                'qualified' => $qualifiedCount,
                'not_qualified' => $notQualifiedCount,
                'total' => $applications->count()
            ];
        }

        return view('admin.job_positions.index', compact('jobPositions'));
    }

    /**
     * Show the form for creating a new job position.
     */
    public function create()
    {
        return view('admin.job_positions.create');
    }

    /**
     * Store a newly created job position.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'job_title' => 'required|string|max:255',
                'position_code' => 'required|string|unique:job_vacancies,position_code',
                'division' => 'required|string|max:255',
                'region' => 'required|string|max:255',
                'monthly_salary' => 'nullable|numeric|min:0',
                'education' => 'nullable|string',
                'training' => 'nullable|array',
                'training.*' => 'nullable|string',
                'experience' => 'nullable|array',
                'experience.*' => 'nullable|string',
                'eligibility' => 'nullable|string',
                'benefits' => 'nullable|array',
                'benefits.*.amount' => 'nullable|numeric',
                'benefits.*.description' => 'nullable|string',
                'status' => 'required|in:open,closed,archived',
                'date_posted' => 'nullable|date',
                'closing_date' => 'nullable|date|after_or_equal:date_posted',
                'min_education_level' => 'nullable|string',
                'required_course' => 'nullable|string',
                'min_years_experience' => 'nullable|integer|min:0',
                'required_eligibility' => 'nullable|string',
                'required_skills' => 'nullable|array',
                'required_skills.*' => 'nullable|string',
                'age_min' => 'nullable|integer|min:18|max:65',
                'age_max' => 'nullable|integer|min:18|max:65',
                'civil_status_requirement' => 'nullable|string',
                'citizenship_requirement' => 'nullable|string',
            ]);

            // Set default values
            $validated['training'] = $validated['training'] ?? [];
            $validated['experience'] = $validated['experience'] ?? [];
            $validated['benefits'] = $validated['benefits'] ?? [];
            $validated['required_skills'] = $validated['required_skills'] ?? [];
            
            if (!isset($validated['status'])) {
                $validated['status'] = 'open';
            }

            if (!isset($validated['date_posted'])) {
                $validated['date_posted'] = now();
            }

            // Set admin_id to the currently logged-in admin
            $validated['admin_id'] = auth()->id();

            $jobPosition = JobVacancy::create($validated);

            Log::info('Admin created job position', [
                'admin_id' => auth()->id(),
                'job_position_id' => $jobPosition->id,
                'job_title' => $jobPosition->job_title
            ]);

            return redirect()->route('admin.job_positions.index')
                ->with('success', 'Job position created successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to create job position', [
                'error' => $e->getMessage(),
                'admin_id' => auth()->id()
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create job position: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified job position.
     */
    public function show($id)
    {
        $jobPosition = JobVacancy::with(['hr', 'admin'])->findOrFail($id);
        return view('admin.job_positions.show', compact('jobPosition'));
    }

    /**
     * Show the form for editing the specified job position.
     */
    public function edit($id)
    {
        $jobPosition = JobVacancy::findOrFail($id);
        return view('admin.job_positions.edit', compact('jobPosition'));
    }

    /**
     * Update the specified job position.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'job_title' => 'required|string|max:255',
                'position_code' => 'required|string|unique:job_vacancies,position_code,' . $id,
                'division' => 'required|string|max:255',
                'region' => 'required|string|max:255',
                'monthly_salary' => 'nullable|numeric|min:0',
                'education' => 'nullable|string',
                'training' => 'nullable|array',
                'training.*' => 'nullable|string',
                'experience' => 'nullable|array',
                'experience.*' => 'nullable|string',
                'eligibility' => 'nullable|string',
                'benefits' => 'nullable|array',
                'benefits.*.amount' => 'nullable|numeric',
                'benefits.*.description' => 'nullable|string',
                'status' => 'required|in:open,closed,archived',
                'date_posted' => 'nullable|date',
                'closing_date' => 'nullable|date|after_or_equal:date_posted',
                'min_education_level' => 'nullable|string',
                'required_course' => 'nullable|string',
                'min_years_experience' => 'nullable|integer|min:0',
                'required_eligibility' => 'nullable|string',
                'required_skills' => 'nullable|array',
                'required_skills.*' => 'nullable|string',
                'age_min' => 'nullable|integer|min:18|max:65',
                'age_max' => 'nullable|integer|min:18|max:65',
                'civil_status_requirement' => 'nullable|string',
                'citizenship_requirement' => 'nullable|string',
            ]);

            $jobPosition = JobVacancy::findOrFail($id);
            
            // Set default values for arrays
            $validated['training'] = $validated['training'] ?? [];
            $validated['experience'] = $validated['experience'] ?? [];
            $validated['benefits'] = $validated['benefits'] ?? [];
            $validated['required_skills'] = $validated['required_skills'] ?? [];

            $jobPosition->update($validated);

            Log::info('Admin updated job position', [
                'admin_id' => auth()->id(),
                'job_position_id' => $jobPosition->id,
                'job_title' => $jobPosition->job_title
            ]);

            return redirect()->route('admin.job_positions.index')
                ->with('success', 'Job position updated successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to update job position', [
                'error' => $e->getMessage(),
                'admin_id' => auth()->id(),
                'job_position_id' => $id
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update job position: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified job position.
     */
    public function destroy($id)
    {
        try {
            $jobPosition = JobVacancy::findOrFail($id);
            $jobTitle = $jobPosition->job_title;
            
            $jobPosition->delete();

            Log::info('Admin deleted job position', [
                'admin_id' => auth()->id(),
                'job_position_id' => $id,
                'job_title' => $jobTitle
            ]);

            return redirect()->route('admin.job_positions.index')
                ->with('success', 'Job position deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to delete job position', [
                'error' => $e->getMessage(),
                'admin_id' => auth()->id(),
                'job_position_id' => $id
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete job position: ' . $e->getMessage()]);
        }
    }

    /**
     * Archive a job position.
     */
    public function archive($id)
    {
        try {
            $jobPosition = JobVacancy::findOrFail($id);
            $jobPosition->status = 'archived';
            $jobPosition->save();

            Log::info('Admin archived job position', [
                'admin_id' => auth()->id(),
                'job_position_id' => $id,
                'job_title' => $jobPosition->job_title
            ]);

            return redirect()->route('admin.job_positions.index')
                ->with('success', 'Job position archived successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to archive job position', [
                'error' => $e->getMessage(),
                'admin_id' => auth()->id(),
                'job_position_id' => $id
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Failed to archive job position: ' . $e->getMessage()]);
        }
    }

    /**
     * Restore an archived job position.
     */
    public function restore($id)
    {
        try {
            $jobPosition = JobVacancy::findOrFail($id);
            $jobPosition->status = 'open';
            $jobPosition->save();

            Log::info('Admin restored job position', [
                'admin_id' => auth()->id(),
                'job_position_id' => $id,
                'job_title' => $jobPosition->job_title
            ]);

            return redirect()->route('admin.job_positions.index')
                ->with('success', 'Job position restored successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to restore job position', [
                'error' => $e->getMessage(),
                'admin_id' => auth()->id(),
                'job_position_id' => $id
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Failed to restore job position: ' . $e->getMessage()]);
        }
    }

    /**
     * Get detailed statistics for a specific job position.
     */
    public function statistics($id)
    {
        $jobPosition = JobVacancy::with(['hr', 'admin', 'jobApplications.user.profile'])
            ->findOrFail($id);

        $applications = $jobPosition->jobApplications;
        
        // Gender statistics
        $genderStats = $applications->groupBy('user.sex')
            ->map(function ($group) {
                return $group->count();
            });
        
        $genderData = [
            'male' => $genderStats['male'] ?? 0,
            'female' => $genderStats['female'] ?? 0,
            'total' => $applications->count()
        ];

        // Qualification statistics
        $qualifiedCount = 0;
        $notQualifiedCount = 0;
        $qualifiedDetails = [];
        $notQualifiedDetails = [];
        
        foreach ($applications as $application) {
            if ($application->user && $application->user->profile) {
                $result = $jobPosition->checkQualification($application->user);
                if (is_array($result) && isset($result['qualified']) && $result['qualified']) {
                    $qualifiedCount++;
                    $qualifiedDetails[] = [
                        'user' => $application->user,
                        'result' => $result,
                        'application' => $application
                    ];
                } else {
                    $notQualifiedCount++;
                    $notQualifiedDetails[] = [
                        'user' => $application->user,
                        'result' => $result,
                        'application' => $application
                    ];
                }
            } else {
                $notQualifiedCount++;
                $notQualifiedDetails[] = [
                    'user' => $application->user,
                    'result' => null,
                    'application' => $application
                ];
            }
        }
        
        $qualificationData = [
            'qualified' => $qualifiedCount,
            'not_qualified' => $notQualifiedCount,
            'total' => $applications->count(),
            'qualified_details' => $qualifiedDetails,
            'not_qualified_details' => $notQualifiedDetails
        ];

        return view('admin.job_positions.statistics', compact('jobPosition', 'genderData', 'qualificationData'));
    }
} 