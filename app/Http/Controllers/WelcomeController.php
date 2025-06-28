<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancy::where('status', 'open')
            ->where(function($subQuery) {
                $subQuery->whereNull('closing_date')
                         ->orWhere('closing_date', '>=', now()->toDateString());
            });

        // Search by job title
        if ($request->filled('job_title')) {
            $query->where('job_title', 'like', '%' . $request->job_title . '%');
        }

        // Search by region (location)
        if ($request->filled('location')) {
            $query->where('region', 'like', '%' . $request->location . '%');
        }

        $jobs = $query->orderBy('date_posted', 'desc')
            ->take(8)
            ->get();

        return view('welcome', compact('jobs'));
    }
} 