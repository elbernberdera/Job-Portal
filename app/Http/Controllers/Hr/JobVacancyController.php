<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobVacancy;

class JobVacancyController extends Controller
{
    public function index()
    {
        $vacancies = JobVacancy::all();
        return view('hr.job_vacancies', compact('vacancies'));
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
                'status' => 'required|in:open,closed',
                'date_posted' => 'nullable|date',
            ]);

            // Set default values for arrays if they're not present
            $validated['training'] = [];
            $validated['experience'] = [];
            $validated['benefits'] = [];
            
            // Set default status if not provided
            if (!isset($validated['status'])) {
                $validated['status'] = 'open';
            }

            // Set default date_posted if not provided
            if (!isset($validated['date_posted'])) {
                $validated['date_posted'] = now();
            }

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
            'monthly_salary' => 'nullable|numeric',
            'education' => 'nullable|string',
            'eligibility' => 'nullable|string',
            'date_posted' => 'nullable|date',
            'status' => 'required|in:open,closed',
            'training' => 'nullable|array',
            'training.*' => 'nullable|string',
            'experience' => 'nullable|array',
            'experience.*' => 'nullable|string',
            'benefits' => 'nullable|array',
            'benefits.*.amount' => 'nullable|numeric',
            'benefits.*.description' => 'nullable|string',
        ]);

        try {
            $vacancy = JobVacancy::findOrFail($id);
            $vacancy->job_title = $validated['job_title'];
            $vacancy->position_code = $validated['position_code'];
            $vacancy->division = $validated['division'];
            $vacancy->region = $validated['region'];
            $vacancy->monthly_salary = $validated['monthly_salary'] ?? null;
            $vacancy->education = $validated['education'] ?? null;
            $vacancy->eligibility = $validated['eligibility'] ?? null;
            $vacancy->date_posted = $validated['date_posted'] ?? null;
            $vacancy->status = $validated['status'];
            $vacancy->training = $validated['training'] ?? [];
            $vacancy->experience = $validated['experience'] ?? [];
            $vacancy->benefits = $validated['benefits'] ?? [];
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
} 