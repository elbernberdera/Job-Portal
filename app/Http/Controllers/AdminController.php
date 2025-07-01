<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $userCount = User::count();
        $jobCount = JobVacancy::count();
        $applicationCount = JobApplication::count();
        $logCount = ActivityLog::count();

        // Enhanced statistics
        $activeUsers = User::where('created_at', '>=', now()->subDays(30))->count();
        $activeUsersPercentage = $userCount > 0 ? round(($activeUsers / $userCount) * 100, 1) : 0;
        
        // Qualified applicants are those with status 'shortlisted', 'interviewed', 'offered', or 'hired'
        $qualifiedApplicants = JobApplication::whereIn('status', ['shortlisted', 'interviewed', 'offered', 'hired'])->count();
        $qualifiedPercentage = $applicationCount > 0 ? round(($qualifiedApplicants / $applicationCount) * 100, 1) : 0;
        
        // Pending reviews are those with status 'applied' or 'under_review'
        $pendingReviews = JobApplication::whereIn('status', ['applied', 'under_review'])->count();
        $pendingPercentage = $applicationCount > 0 ? round(($pendingReviews / $applicationCount) * 100, 1) : 0;
        
        $thisMonthApplications = JobApplication::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $lastMonthApplications = JobApplication::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        $monthlyGrowth = $lastMonthApplications > 0 ? round((($thisMonthApplications - $lastMonthApplications) / $lastMonthApplications) * 100, 1) : 0;

        // Recent applications (last 5)
        $recentApplications = JobApplication::with(['user', 'jobVacancy'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // System health metrics
        $storageUsage = 75; // Mock data - in real app, calculate actual storage usage
        $activeSessions = 12; // Mock data - in real app, get actual session count
        $sessionPercentage = 60; // Mock data
        $uptime = '99.9%'; // Mock data

        // Recent activity (last 5 actions: login or logout)
        $recentActivities = ActivityLog::orderByDesc('login_at')
            ->orderByDesc('logout_at')
            ->limit(10)
            ->get()
            ->flatMap(function($log) {
                $actions = collect();
                if ($log->login_at) {
                    $actions->push([
                        'user' => $log->user_name,
                        'action' => 'logged in',
                        'time' => $log->login_at,
                    ]);
                }
                if ($log->logout_at) {
                    $actions->push([
                        'user' => $log->user_name,
                        'action' => 'logged out',
                        'time' => $log->logout_at,
                    ]);
                }
                return $actions;
            })
            ->sortByDesc('time')
            ->take(5)
            ->map(function($item) {
                return $item['user'] . ' ' . $item['action'] . ' at ' . $item['time'];
            });

        // Chart data: Applications per month (last 6 months)
        $chartLabels = [];
        $chartData = [];
        $usersChartData = [];
        $months = collect(range(0, 5))->map(function($i) {
            return now()->subMonths($i)->format('Y-m');
        })->reverse();
        foreach ($months as $month) {
            $chartLabels[] = date('M Y', strtotime($month.'-01'));
            $chartData[] = JobApplication::whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count();
            $usersChartData[] = User::whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count();
        }

        // Donut chart data: Male/Female + Passer/Not Passer
        $malePasser = JobApplication::whereHas('user', function($q){ $q->where('sex', 'male'); })
            ->where('status', 'shortlisted')->count();
        $maleNotPasser = JobApplication::whereHas('user', function($q){ $q->where('sex', 'male'); })
            ->where('status', '!=', 'shortlisted')->count();
        $femalePasser = JobApplication::whereHas('user', function($q){ $q->where('sex', 'female'); })
            ->where('status', 'shortlisted')->count();
        $femaleNotPasser = JobApplication::whereHas('user', function($q){ $q->where('sex', 'female'); })
            ->where('status', '!=', 'shortlisted')->count();
        $donutChartData = [
            'Male Passer' => $malePasser,
            'Male Not Passer' => $maleNotPasser,
            'Female Passer' => $femalePasser,
            'Female Not Passer' => $femaleNotPasser,
        ];

        return view('admin.dashboard', compact(
            'userCount',
            'jobCount',
            'applicationCount',
            'logCount',
            'activeUsers',
            'activeUsersPercentage',
            'qualifiedApplicants',
            'qualifiedPercentage',
            'pendingReviews',
            'pendingPercentage',
            'thisMonthApplications',
            'monthlyGrowth',
            'recentApplications',
            'storageUsage',
            'activeSessions',
            'sessionPercentage',
            'uptime',
            'recentActivities',
            'chartLabels',
            'chartData',
            'usersChartData',
            'donutChartData',
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

    // create here for the for the logs that display the times stamp what time they login and logout  
} 