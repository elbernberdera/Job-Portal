<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobVacancy;

class JobVacancyController extends Controller
{
    public function index()
    {
        // Get all vacancies with counts and eager load applications and users
        $allVacancies = \App\Models\JobVacancy::with([
            'jobApplications.user',
        ])->withCount([
            'jobApplications as applications_count',
            'jobApplications as shortlisted_count' => function ($query) {
                $query->where('status', 'shortlisted');
            }
        ])->get();

        // Separate active and archived vacancies
        $activeVacancies = $allVacancies->whereNotIn('status', ['archived']);
        $archivedVacancies = $allVacancies->where('status', 'archived');

        return view('hr.job_vacancies', compact('activeVacancies', 'archivedVacancies'));
    }

    public function store(Request $request)
    {
        // Debug the incoming request
        $requestData = $request->all();
        \Log::info('Incoming request data:', $requestData);

        try {
            $validated = $request->validate([
                'job_title' => 'required|string',
                'position_code' => 'required|string|unique:job_vacancies,position_code',
                'division' => 'required|string',
                'region' => 'required|string',
                'salary_grade' => 'nullable|integer|min:1|max:33',
                'monthly_salary' => 'nullable|numeric',
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
                'required_course' => 'nullable|string',
                'min_years_experience' => 'nullable|integer|min:0',
                'required_skills' => 'nullable|string',
                'citizenship_requirement' => 'nullable|string',
            ]);

            // Set default values for arrays if they're not present
            $validated['training'] = $validated['training'] ?? [];
            $validated['experience'] = $validated['experience'] ?? [];
            $validated['benefits'] = $validated['benefits'] ?? [];
            
            // Handle required_skills as array
            if (isset($validated['required_skills']) && is_string($validated['required_skills'])) {
                $validated['required_skills'] = array_map('trim', explode(',', $validated['required_skills']));
            } else {
                $validated['required_skills'] = [];
            }
            
            // Set default status if not provided
            if (!isset($validated['status'])) {
                $validated['status'] = 'open';
            }

            // Set default date_posted if not provided
            if (!isset($validated['date_posted'])) {
                $validated['date_posted'] = now();
            }

            // Set hr_id to the currently logged-in HR
            $validated['hr_id'] = auth()->id();

            \Log::info('Attempting to create job vacancy with data:', $validated);

            $job = JobVacancy::create($validated);

            if (!$job) {
                \Log::error('Failed to create job vacancy - returned false');
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['error' => 'Failed to create job vacancy: Database error']);
            }

            \Log::info('Job vacancy created successfully:', ['job_id' => $job->id]);
            return redirect()->route('job_vacancies')->with('success', 'Job vacancy created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Validation failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Job vacancy creation failed:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create job vacancy: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'job_title' => 'required|string',
            'position_code' => 'required|string',
            'division' => 'required|string',
            'region' => 'required|string',
            'salary_grade' => 'nullable|integer|min:1|max:33',
            'monthly_salary' => 'nullable|numeric',
            'education' => 'nullable|string',
            'eligibility' => 'nullable|string',
            'date_posted' => 'nullable|date',
            'closing_date' => 'nullable|date|after_or_equal:date_posted',
            'status' => 'required|in:open,closed,archived',
            'training' => 'nullable|array',
            'training.*' => 'nullable|string',
            'experience' => 'nullable|array',
            'experience.*' => 'nullable|string',
            'benefits' => 'nullable|array',
            'benefits.*.amount' => 'nullable|numeric',
            'benefits.*.description' => 'nullable|string',
            'required_course' => 'nullable|string',
            'min_years_experience' => 'nullable|integer|min:0',
            'required_skills' => 'nullable|string',
            'citizenship_requirement' => 'nullable|string',
        ]);

        try {
            $vacancy = JobVacancy::findOrFail($id);
            $vacancy->job_title = $validated['job_title'];
            $vacancy->position_code = $validated['position_code'];
            $vacancy->division = $validated['division'];
            $vacancy->region = $validated['region'];
            $vacancy->salary_grade = $validated['salary_grade'] ?? null;
            $vacancy->monthly_salary = $validated['monthly_salary'] ?? null;
            $vacancy->education = $validated['education'] ?? null;
            $vacancy->eligibility = $validated['eligibility'] ?? null;
            $vacancy->date_posted = $validated['date_posted'] ?? null;
            $vacancy->closing_date = $validated['closing_date'] ?? null;
            $vacancy->status = $validated['status'];
            $vacancy->training = $validated['training'] ?? [];
            $vacancy->experience = $validated['experience'] ?? [];
            $vacancy->benefits = $validated['benefits'] ?? [];
            $vacancy->required_course = $validated['required_course'] ?? null;
            $vacancy->min_years_experience = $validated['min_years_experience'] ?? null;
            $vacancy->required_skills = $validated['required_skills'] ? explode(',', $validated['required_skills']) : [];
            $vacancy->citizenship_requirement = $validated['citizenship_requirement'] ?? null;
            $vacancy->save();
            return redirect()->route('job_vacancies')->with('success', 'Job vacancy updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update job vacancy: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $vacancy = JobVacancy::findOrFail($id);
            $vacancy->delete();
            return redirect()->route('job_vacancies')->with('success', 'Job vacancy deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete job vacancy: ' . $e->getMessage()]);
        }
    }

    public function addTraining(Request $request, $id)
    {
        $request->validate(['training' => 'required|string']);
        $vacancy = JobVacancy::findOrFail($id);
        $trainings = is_array($vacancy->training) ? $vacancy->training : [];
        $trainings[] = $request->training;
        $vacancy->training = $trainings;
        $vacancy->save();
        return response()->json(['success' => true, 'trainings' => $trainings]);
    }

    /**
     * Archive a job vacancy
     */
    public function archive($id)
    {
        try {
            $vacancy = JobVacancy::findOrFail($id);
            $vacancy->archive();
            return redirect()->route('job_vacancies')->with('success', 'Job vacancy archived successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to archive job vacancy: ' . $e->getMessage()]);
        }
    }

    /**
     * Restore an archived job vacancy
     */
    public function restore($id)
    {
        try {
            $vacancy = JobVacancy::findOrFail($id);
            $vacancy->status = 'open';
            $vacancy->save();
            return redirect()->route('job_vacancies')->with('success', 'Job vacancy restored successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to restore job vacancy: ' . $e->getMessage()]);
        }
    }
} 