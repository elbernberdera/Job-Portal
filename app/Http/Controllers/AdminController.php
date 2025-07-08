<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use App\Models\ActivityLog;
use App\Models\Setting;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        // Total job listings
        $totalJobListings = JobVacancy::count();
        
        // Users by role (1=Admin, 2=HR, 3=Applicant)
        $hrUsers = User::where('role', 2)->count();
        $applicantUsers = User::where('role', 3)->count();
        $totalUsers = User::count();
        
        // Applications by status
        $pendingApplications = JobApplication::whereIn('status', ['applied', 'under_review'])->count();
        $approvedApplications = JobApplication::whereIn('status', ['shortlisted', 'interviewed', 'offered', 'hired'])->count();
        $rejectedApplications = JobApplication::whereIn('status', ['rejected', 'not_qualified'])->count();
        $totalApplications = JobApplication::count();
        
        // Recent applications (last 10)
        $recentApplications = JobApplication::with(['user', 'jobVacancy'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Recent activity logs (last 20)
        $recentActivities = ActivityLog::orderByDesc('login_at')
            ->orderByDesc('logout_at')
            ->limit(20)
            ->get()
            ->flatMap(function($log) {
                $actions = collect();
                if ($log->login_at) {
                    $actions->push([
                        'user' => $log->user_name,
                        'action' => 'logged in',
                        'time' => $log->login_at,
                        'type' => 'login'
                    ]);
                }
                if ($log->logout_at) {
                    $actions->push([
                        'user' => $log->user_name,
                        'action' => 'logged out',
                        'time' => $log->logout_at,
                        'type' => 'logout'
                    ]);
                }
                return $actions;
            })
            ->sortByDesc('time')
            ->take(15);

        // Chart data: Job post trends (last 6 months)
        $jobTrendLabels = [];
        $jobTrendData = [];
        $months = collect(range(0, 5))->map(function($i) {
            return now()->subMonths($i)->format('Y-m');
        })->reverse();
        
        foreach ($months as $month) {
            $jobTrendLabels[] = date('M Y', strtotime($month.'-01'));
            $jobTrendData[] = JobVacancy::whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count();
        }

        // User activity chart (last 6 months)
        $userActivityLabels = [];
        $userActivityData = [];
        foreach ($months as $month) {
            $userActivityLabels[] = date('M Y', strtotime($month.'-01'));
            $userActivityData[] = User::whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count();
        }

        // Application status distribution for pie chart
        $applicationStatusData = [
            'Pending' => $pendingApplications,
            'Approved' => $approvedApplications,
            'Rejected' => $rejectedApplications,
        ];

        // User role distribution for pie chart
        $userRoleData = [
            'HR Users' => $hrUsers,
            'Applicants' => $applicantUsers,
        ];

        return view('admin.dashboard', compact(
            'totalJobListings',
            'hrUsers',
            'applicantUsers',
            'totalUsers',
            'pendingApplications',
            'approvedApplications',
            'rejectedApplications',
            'totalApplications',
            'recentApplications',
            'recentActivities',
            'jobTrendLabels',
            'jobTrendData',
            'userActivityLabels',
            'userActivityData',
            'applicationStatusData',
            'userRoleData'
        ));
    }

    /**
     * Show the user management page.
     */
    public function manageUsers()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Store a new account (Admin, Staff, User).
     */
    public function storeAccount(Request $request)
    {
        Log::info('storeAccount request data', $request->all());
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'role' => 'required|in:1,2,3', // 1=Admin, 2=Staff, 3=User
                'password' => 'required|string|min:8|confirmed',
                'birth_date' => 'required|date',
                'phone_number' => 'required|regex:/^09\\d{9}$/',
                'place_of_birth' => 'required|string|max:255',
                'region' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'barangay' => 'required|string|max:255',
                'street_building_unit' => 'required|string|max:255',
                'zipcode' => 'required|string|max:255',
            ]);
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'birth_date' => $request->birth_date,
                'phone_number' => $request->phone_number,
                'place_of_birth' => $request->place_of_birth,
                'region' => $request->region,
                'province' => $request->province,
                'city' => $request->city,
                'barangay' => $request->barangay,
                'street_building_unit' => $request->street_building_unit,
                'zipcode' => $request->zipcode,
            ]);
            Log::info('User created', ['user_id' => $user->id]);
            return redirect()->route('admin.accounts')->with('success', 'Account created successfully!');
        } catch (\Exception $e) {
            Log::error('Account creation failed', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Failed to create account: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing account.
     */
    public function updateAccount(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:1,2,3',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.accounts')->with('success', 'Account updated successfully');
    }

    /**
     * Delete an account.
     */
    public function deleteAccount(User $user)
    {
        $user->delete();
        return redirect()->route('admin.accounts')->with('success', 'Account deleted successfully');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function accounts()
    {
        $users = \App\Models\User::all();
        return view('admin.accounts', compact('users'));
    }

    public function editProfile(Request $request)
    {
        return view('admin.update_profile');
    }

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

        // Log activity
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->first_name . ' ' . $user->last_name,
            'email' => $user->email,
            'ip_address' => $request->ip(),
            'device' => $request->header('User-Agent'),
            'activity' => 'Updated Profile',
            'role' => $user->role,
        ]);

        return redirect()->route('update.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Get chart data for AJAX requests
     */
    public function getChartData()
    {
        $chartLabels = [];
        $applicationsData = [];
        $usersData = [];
        $months = collect(range(0, 5))->map(function($i) {
            return now()->subMonths($i)->format('Y-m');
        })->reverse();
        
        foreach ($months as $month) {
            $chartLabels[] = date('M Y', strtotime($month.'-01'));
            
            // Applications data
            $applicationsData[] = JobApplication::whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count();
            
            // Users data
            $usersData[] = User::whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count();
        }

        return response()->json([
            'labels' => $chartLabels,
            'applications' => $applicationsData,
            'users' => $usersData
        ]);
    }

    /**
     * Get dashboard statistics for AJAX requests
     */
    public function getStats()
    {
        $userCount = User::count();
        $jobCount = JobVacancy::count();
        $applicationCount = JobApplication::count();
        $logCount = ActivityLog::count();

        // Enhanced statistics
        $activeUsers = User::where('created_at', '>=', now()->subDays(30))->count();
        $qualifiedApplicants = JobApplication::whereIn('status', ['shortlisted', 'interviewed', 'offered', 'hired'])->count();
        $pendingReviews = JobApplication::whereIn('status', ['applied', 'under_review'])->count();
        $thisMonthApplications = JobApplication::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return response()->json([
            'userCount' => $userCount,
            'jobCount' => $jobCount,
            'applicationCount' => $applicationCount,
            'logCount' => $logCount,
            'activeUsers' => $activeUsers,
            'qualifiedApplicants' => $qualifiedApplicants,
            'pendingReviews' => $pendingReviews,
            'thisMonthApplications' => $thisMonthApplications
        ]);
    }

    // ========================================
    // APPLICANTS MANAGEMENT
    // ========================================

    /**
     * Show all applicants
     */
    public function applicants(Request $request)
    {
        $query = User::where('role', 3); // Applicants only

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $applicants = $query->with(['jobApplications'])->paginate(15);

        return view('admin.applicants.index', compact('applicants'));
    }

    /**
     * View applicant profile and resume
     */
    public function viewApplicant(User $user)
    {
        if ($user->role !== 3) {
            return redirect()->route('admin.applicants')->with('error', 'User is not an applicant');
        }

        $user->load(['jobApplications.jobVacancy', 'profile']);
        return view('admin.applicants.view', compact('user'));
    }

    /**
     * Deactivate applicant account
     */
    public function deactivateApplicant(User $user)
    {
        if ($user->role !== 3) {
            return redirect()->back()->with('error', 'User is not an applicant');
        }

        $user->update(['is_active' => false]);
        return redirect()->back()->with('success', 'Applicant account deactivated successfully');
    }

    /**
     * Activate applicant account
     */
    public function activateApplicant(User $user)
    {
        if ($user->role !== 3) {
            return redirect()->back()->with('error', 'User is not an applicant');
        }

        $user->update(['is_active' => true]);
        return redirect()->back()->with('success', 'Applicant account activated successfully');
    }

    /**
     * Delete applicant account
     */
    public function deleteApplicant(User $user)
    {
        if ($user->role !== 3) {
            return redirect()->back()->with('error', 'User is not an applicant');
        }

        $user->delete();
        return redirect()->route('admin.applicants')->with('success', 'Applicant account deleted successfully');
    }

    // ========================================
    // HR ACCOUNTS MANAGEMENT
    // ========================================

    /**
     * Show all HR accounts
     */
    public function hrAccounts(Request $request)
    {
        $query = User::where('role', 2); // HR users only

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by approval status
        if ($request->filled('approval_status')) {
            if ($request->approval_status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->approval_status === 'approved') {
                $query->where('is_approved', true);
            }
        }

        // Filter by account status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $hrAccounts = $query->with(['jobVacancies'])->paginate(15);

        return view('admin.hr-accounts.index', compact('hrAccounts'));
    }

    /**
     * Approve HR account
     */
    public function approveHrAccount(User $user)
    {
        if ($user->role !== 2) {
            return redirect()->back()->with('error', 'User is not an HR account');
        }

        $user->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'HR account approved successfully');
    }

    /**
     * Reject HR account
     */
    public function rejectHrAccount(User $user)
    {
        if ($user->role !== 2) {
            return redirect()->back()->with('error', 'User is not an HR account');
        }

        $user->update(['is_approved' => false]);
        return redirect()->back()->with('success', 'HR account rejected');
    }

    /**
     * Deactivate HR account
     */
    public function deactivateHrAccount(User $user)
    {
        if ($user->role !== 2) {
            return redirect()->back()->with('error', 'User is not an HR account');
        }

        $user->update(['is_active' => false]);
        return redirect()->back()->with('success', 'HR account deactivated successfully');
    }

    /**
     * Activate HR account
     */
    public function activateHrAccount(User $user)
    {
        if ($user->role !== 2) {
            return redirect()->back()->with('error', 'User is not an HR account');
        }

        $user->update(['is_active' => true]);
        return redirect()->back()->with('success', 'HR account activated successfully');
    }

    /**
     * Delete HR account
     */
    public function deleteHrAccount(User $user)
    {
        if ($user->role !== 2) {
            return redirect()->back()->with('error', 'User is not an HR account');
        }

        $user->delete();
        return redirect()->route('admin.hr-accounts')->with('success', 'HR account deleted successfully');
    }

    /**
     * View HR activity logs
     */
    public function hrActivity(User $user)
    {
        if ($user->role !== 2) {
            return redirect()->back()->with('error', 'User is not an HR account');
        }

        $postedJobs = JobVacancy::where('created_by', $user->id)->with('applications')->get();
        $hiredUsers = JobApplication::whereHas('jobVacancy', function($q) use ($user) {
            $q->where('created_by', $user->id);
        })->whereIn('status', ['hired'])->with(['user', 'jobVacancy'])->get();

        return view('admin.hr-accounts.activity', compact('user', 'postedJobs', 'hiredUsers'));
    }

    // ========================================
    // ADMIN ACCOUNTS MANAGEMENT
    // ========================================

    /**
     * Show all admin accounts
     */
    public function adminAccounts(Request $request)
    {
        $query = User::where('role', 1); // Admin users only

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $adminAccounts = $query->paginate(15);

        return view('admin.admin-accounts.index', compact('adminAccounts'));
    }

    /**
     * Store new admin account
     */
    public function storeAdminAccount(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'birth_date' => 'required|date',
            'phone_number' => 'required|regex:/^09\\d{9}$/',
            'place_of_birth' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street_building_unit' => 'required|string|max:255',
            'zipcode' => 'required|string|max:255',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 1, // Admin role
            'birth_date' => $request->birth_date,
            'phone_number' => $request->phone_number,
            'place_of_birth' => $request->place_of_birth,
            'region' => $request->region,
            'province' => $request->province,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'street_building_unit' => $request->street_building_unit,
            'zipcode' => $request->zipcode,
            'is_active' => true,
            'is_approved' => true,
        ]);

        return redirect()->route('admin.admin-accounts')->with('success', 'Admin account created successfully!');
    }

    /**
     * Update admin account
     */
    public function updateAdminAccount(Request $request, User $user)
    {
        if ($user->role !== 1) {
            return redirect()->back()->with('error', 'User is not an admin account');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.admin-accounts')->with('success', 'Admin account updated successfully');
    }

    /**
     * Delete admin account
     */
    public function deleteAdminAccount(User $user)
    {
        if ($user->role !== 1) {
            return redirect()->back()->with('error', 'User is not an admin account');
        }

        // Prevent deleting the current user
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();
        return redirect()->route('admin.admin-accounts')->with('success', 'Admin account deleted successfully');
    }

    // ========================================
    // SYSTEM SETTINGS / CONFIGURATION
    // ========================================

    /**
     * Show the site configuration page.
     */
    public function siteConfig()
    {
        $settings = [
            'site_name' => Setting::get('site_name', config('app.name')),
            'site_description' => Setting::get('site_description', ''),
            'contact_email' => Setting::get('contact_email', ''),
            'maintenance_mode' => Setting::get('maintenance_mode', false),
            'notification_enabled' => Setting::get('notification_enabled', true),
            'job_approval_required' => Setting::get('job_approval_required', true),
            'max_job_applications' => Setting::get('max_job_applications', 5),
            'auto_archive_days' => Setting::get('auto_archive_days', 30),
        ];

        return view('admin.system-settings.site-config', compact('settings'));
    }

    /**
     * Update site configuration.
     */
    public function updateSiteConfig(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'contact_email' => 'required|email',
            'max_job_applications' => 'required|integer|min:1|max:20',
            'auto_archive_days' => 'required|integer|min:1|max:365',
        ]);

        // Update settings
        Setting::set('site_name', $request->site_name);
        Setting::set('site_description', $request->site_description);
        Setting::set('contact_email', $request->contact_email);
        Setting::set('maintenance_mode', $request->has('maintenance_mode'));
        Setting::set('notification_enabled', $request->has('notification_enabled'));
        Setting::set('job_approval_required', $request->has('job_approval_required'));
        Setting::set('max_job_applications', $request->max_job_applications);
        Setting::set('auto_archive_days', $request->auto_archive_days);

        return redirect()->route('admin.site-config')->with('success', 'Site configuration updated successfully.');
    }

    /**
     * Show job categories management page
     */
    public function jobCategories(Request $request)
    {
        $query = \App\Models\JobCategory::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $categories = $query->withCount('jobVacancies')->paginate(15);
        
        return view('admin.system-settings.job-categories', compact('categories'));
    }

    /**
     * Store new job category
     */
    public function storeJobCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:job_categories',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        \App\Models\JobCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.job-categories')->with('success', 'Job category created successfully!');
    }

    /**
     * Update job category
     */
    public function updateJobCategory(Request $request, $id)
    {
        $category = \App\Models\JobCategory::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:job_categories,name,' . $id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.job-categories')->with('success', 'Job category updated successfully!');
    }

    /**
     * Delete job category
     */
    public function deleteJobCategory($id)
    {
        $category = \App\Models\JobCategory::findOrFail($id);
        
        // Check if category has associated jobs
        if ($category->jobVacancies()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with associated job vacancies');
        }

        $category->delete();
        return redirect()->route('admin.job-categories')->with('success', 'Job category deleted successfully!');
    }

    /**
     * Show locations management page
     */
    public function locations(Request $request)
    {
        $query = \App\Models\Location::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%")
                  ->orWhere('province', 'like', "%{$search}%");
        }

        $locations = $query->withCount('jobVacancies')->paginate(15);
        
        return view('admin.system-settings.locations', compact('locations'));
    }

    /**
     * Store new location
     */
    public function storeLocation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        \App\Models\Location::create([
            'name' => $request->name,
            'region' => $request->region,
            'province' => $request->province,
            'city' => $request->city,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.locations')->with('success', 'Location created successfully!');
    }

    /**
     * Update location
     */
    public function updateLocation(Request $request, $id)
    {
        $location = \App\Models\Location::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $location->update([
            'name' => $request->name,
            'region' => $request->region,
            'province' => $request->province,
            'city' => $request->city,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.locations')->with('success', 'Location updated successfully!');
    }

    /**
     * Delete location
     */
    public function deleteLocation($id)
    {
        $location = \App\Models\Location::findOrFail($id);
        
        // Check if location has associated jobs
        if ($location->jobVacancies()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete location with associated job vacancies');
        }

        $location->delete();
        return redirect()->route('admin.locations')->with('success', 'Location deleted successfully!');
    }

    /**
     * Show industries management page
     */
    public function industries(Request $request)
    {
        $query = \App\Models\Industry::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $industries = $query->withCount('jobVacancies')->paginate(15);
        
        return view('admin.system-settings.industries', compact('industries'));
    }

    /**
     * Store new industry
     */
    public function storeIndustry(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:industries',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        \App\Models\Industry::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.industries')->with('success', 'Industry created successfully!');
    }

    /**
     * Update industry
     */
    public function updateIndustry(Request $request, $id)
    {
        $industry = \App\Models\Industry::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:industries,name,' . $id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $industry->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.industries')->with('success', 'Industry updated successfully!');
    }

    /**
     * Delete industry
     */
    public function deleteIndustry($id)
    {
        $industry = \App\Models\Industry::findOrFail($id);
        
        // Check if industry has associated jobs
        if ($industry->jobVacancies()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete industry with associated job vacancies');
        }

        $industry->delete();
        return redirect()->route('admin.industries')->with('success', 'Industry deleted successfully!');
    }
} 