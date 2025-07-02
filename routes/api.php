<?php

use App\Http\Controllers\PsgcController;

Route::get('test', function () {
    return ['message' => 'API is working'];
});

// Predictive search API endpoint
Route::get('/search/suggestions', function (Illuminate\Http\Request $request) {
    $query = $request->get('q');
    $type = $request->get('type', 'job_title'); // 'job_title' or 'location'
    
    if (strlen($query) < 3) {
        return response()->json([]);
    }
    
    $model = \App\Models\JobVacancy::where('status', 'open')
        ->where(function($subQuery) {
            $subQuery->whereNull('closing_date')
                     ->orWhere('closing_date', '>=', now()->toDateString());
        });
    
    if ($type === 'job_title') {
        $suggestions = $model->where('job_title', 'like', '%' . $query . '%')
            ->distinct()
            ->pluck('job_title')
            ->take(10)
            ->values();
    } else {
        $suggestions = $model->where('region', 'like', '%' . $query . '%')
            ->distinct()
            ->pluck('region')
            ->take(10)
            ->values();
    }
    
    return response()->json($suggestions);
});

