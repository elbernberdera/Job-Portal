<?php

use App\Http\Controllers\PsgcController;
use Illuminate\Support\Facades\Route;

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

Route::get('/regions', function () {
    return response()->json([
        'success' => true,
        'regions' => [
            ['code' => 'NCR', 'name' => 'National Capital Region'],
            ['code' => '01', 'name' => 'Ilocos Region'],
            ['code' => '02', 'name' => 'Cagayan Valley'],
            ['code' => '03', 'name' => 'Central Luzon'],
            ['code' => '04', 'name' => 'CALABARZON'],
            ['code' => '05', 'name' => 'Bicol Region'],
            ['code' => '06', 'name' => 'Western Visayas'],
            ['code' => '07', 'name' => 'Central Visayas'],
            ['code' => '08', 'name' => 'Eastern Visayas'],
            ['code' => '09', 'name' => 'Zamboanga Peninsula'],
            ['code' => '10', 'name' => 'Northern Mindanao'],
            ['code' => '11', 'name' => 'Davao Region'],
            ['code' => '12', 'name' => 'SOCCSKSARGEN'],
            ['code' => '13', 'name' => 'Caraga'],
            ['code' => '14', 'name' => 'Autonomous Region in Muslim Mindanao'],
            ['code' => '15', 'name' => 'Cordillera Administrative Region'],
        ]
    ]);
});

