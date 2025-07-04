<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HRController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PsgcController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Hr\JobVacancyController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\JobPositionController;
use App\Http\Controllers\User\JobApplicationController;
use App\Http\Controllers\User\UserJobVacancyController;


Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index']);

Route::get('/dashboard-test', function () {
    $openJobs = \App\Models\JobVacancy::where('status', 'open')->count();
    dd($openJobs);
});

Route::get('regions', [PsgcController::class, 'getRegions']);
Route::get('provinces', [PsgcController::class, 'getProvinces']);
Route::get('cities', [PsgcController::class, 'getCities']);
Route::get('barangays', [PsgcController::class, 'getBarangays']);

// Default dashboard route - redirects based on user role
Route::get('/dashboard', function () {
    $user = Auth::user();
    
    if ($user->role === 1) { // admin
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 2) { // hr
        return redirect()->route('hr.dashboard');
    } else { // user (role = 3)
        return redirect()->route('user.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');

    

    // Account management routes
    Route::get('/admin/accounts', [AdminController::class, 'accounts'])->name('admin.accounts');
    Route::post('/admin/accounts', [AdminController::class, 'storeAccount'])->name('admin.accounts.store');
    Route::put('/admin/accounts/{user}', [AdminController::class, 'updateAccount'])->name('admin.accounts.update');
    Route::delete('/admin/accounts/{user}', [AdminController::class, 'deleteAccount'])->name('admin.accounts.destroy');

    // create here the update_profile
    Route::get('/admin/update_profile', [AdminController::class, 'editProfile'])->name('update.profile');
    Route::put('/admin/update_profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    // cretae here the routes of the log
    Route::get('/admin/logs', [LogController::class, 'index'])->name('admin.logs');
    Route::get('/admin/logs/ajax', [\App\Http\Controllers\Admin\LogController::class, 'ajaxLogs'])->name('admin.logs.ajax');
    Route::get('/admin/logs/export', [LogController::class, 'export'])->name('admin.logs.export');
    
    // New routes for date filtering
    Route::post('/admin/logs/filter-by-date', [LogController::class, 'filterByDate'])->name('admin.logs.filter-by-date');
    Route::post('/admin/logs/ajax-by-date', [LogController::class, 'ajaxLogsByDate'])->name('admin.logs.ajax-by-date');
    Route::post('/admin/logs/export-by-date', [LogController::class, 'exportByDate'])->name('admin.logs.export-by-date');
    
    // Dashboard AJAX routes
    Route::get('/admin/dashboard/chart-data', [AdminController::class, 'getChartData'])->name('admin.dashboard.chart-data');
    Route::get('/admin/dashboard/stats', [AdminController::class, 'getStats'])->name('admin.dashboard.stats');

    // Admin Job Position Management Routes
    Route::get('/admin/job-positions', [JobPositionController::class, 'index'])->name('admin.job_positions.index');
    Route::get('/admin/job-positions/create', [JobPositionController::class, 'create'])->name('admin.job_positions.create');
    Route::post('/admin/job-positions', [JobPositionController::class, 'store'])->name('admin.job_positions.store');
    Route::get('/admin/job-positions/{id}', [JobPositionController::class, 'show'])->name('admin.job_positions.show');
    Route::get('/admin/job-positions/{id}/edit', [JobPositionController::class, 'edit'])->name('admin.job_positions.edit');
    Route::put('/admin/job-positions/{id}', [JobPositionController::class, 'update'])->name('admin.job_positions.update');
    Route::delete('/admin/job-positions/{id}', [JobPositionController::class, 'destroy'])->name('admin.job_positions.destroy');
    Route::post('/admin/job-positions/{id}/archive', [JobPositionController::class, 'archive'])->name('admin.job_positions.archive');
    Route::post('/admin/job-positions/{id}/restore', [JobPositionController::class, 'restore'])->name('admin.job_positions.restore');
    Route::get('/admin/job-positions/{id}/statistics', [JobPositionController::class, 'statistics'])->name('admin.job_positions.statistics');

});

// HR routes
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/hr/dashboard', [HRController::class, 'dashboard'])->name('hr.dashboard');

    // for update or edit profile sa hr
    Route::get('/hr/update_profile', [HRController::class, 'editProfile'])->name('update_profile_hr');
    Route::put('/hr/update_profile', [HRController::class, 'updateProfile'])->name('hr.profile.update');

    // create here the routes to create job vacancies
    Route::get('/hr/job-vacancies', [JobVacancyController::class, 'index'])->name('job_vacancies');
    Route::post('/hr/job-vacancies', [JobVacancyController::class, 'store'])->name('job_vacancies.store');
    Route::put('/hr/job-vacancies/{id}', [JobVacancyController::class, 'update'])->name('job_vacancies.update');
    Route::delete('/hr/job-vacancies/{id}', [JobVacancyController::class, 'destroy'])->name('job_vacancies.destroy');
    Route::post('/hr/job-vacancies/{id}/add-training', [JobVacancyController::class, 'addTraining'])->name('job_vacancies.add_training');
    
    // Archive and restore routes
    Route::post('/hr/job-vacancies/{id}/archive', [JobVacancyController::class, 'archive'])->name('job_vacancies.archive');
    Route::post('/hr/job-vacancies/{id}/restore', [JobVacancyController::class, 'restore'])->name('job_vacancies.restore');

    // HR Application Actions
    Route::post('/applications/{application}/shortlist', [App\Http\Controllers\Hr\JobApplicationController::class, 'shortlist'])->name('applications.shortlist');
    Route::post('/applications/{application}/reject', [App\Http\Controllers\Hr\JobApplicationController::class, 'reject'])->name('applications.reject');
    
    // HR Qualified Applicants
    Route::get('/qualified-applicants', [App\Http\Controllers\Hr\JobApplicationController::class, 'qualifiedApplicants'])->name('hr.qualified-applicants');

});

// User routes
Route::middleware(['auth', 'role:3'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    // Update profile for user
    Route::get('/user/update_profile', [UserController::class, 'editProfile'])->name('update_profile_user');
    Route::put('/user/update_profile', [UserController::class, 'updateProfile'])->name('user.profile.update');

    //creat here the route for user profile
    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('user.profile');
    Route::put('/user/profile', [UserProfileController::class, 'update'])->name('user.profile.update');
    Route::post('/user/profile/upload', [UserProfileController::class, 'uploadProfileImage'])->name('user.profile.upload');

    // Route to store the data in the new user_profiles table and update the users table
    Route::post('/user/profile', [App\Http\Controllers\User\UserProfileController::class, 'store'])->name('user.profile.store');
    // Job application route
    Route::post('/user/apply/{job}', [JobApplicationController::class, 'apply'])->name('user.apply');

    // =====================
    // User Job Vacancies (NEW)
    // =====================
    Route::get('/user/job_vacancies', [\App\Http\Controllers\User\UserJobVacancyController::class, 'index'])->name('user.job.vacancies'); // List all jobs
    Route::get('/user/job_vacancies/{id}', [\App\Http\Controllers\User\UserJobVacancyController::class, 'show'])->name('user.job.details'); // View job details
    Route::get('/user/job_vacancies/{id}/apply', [\App\Http\Controllers\User\UserJobVacancyController::class, 'apply'])->name('user.job.apply'); // Apply to job

    // Add the new route for editing the user profile
    Route::get('/user/profile/edit', [App\Http\Controllers\User\UserProfileController::class, 'show'])->name('user.profile.edit');

    // Add the new route for the PDS form
    Route::get('/user/pds-form/{job}', [App\Http\Controllers\User\UserProfileController::class, 'showPDSForm'])->name('user.pds.form');
    Route::post('/user/pds-form/{job}', [App\Http\Controllers\User\UserProfileController::class, 'storePDS'])->name('user.pds.store');

    // Add the new route for the user's applied jobs
    Route::get('/user/applied-jobs', [UserJobVacancyController::class, 'appliedJobs'])->name('user.appliedJob');

    // Route to check profile completeness before applying
    Route::get('/user/apply-for-job/{job}', [App\Http\Controllers\User\UserProfileController::class, 'applyForJob'])->name('user.apply_for_job');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
