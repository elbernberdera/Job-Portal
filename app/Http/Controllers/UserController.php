<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();
        $openJobs = \App\Models\JobVacancy::where('status', 'open')->whereNotNull('hr_id')->count();
        $appliedJobs = $user->jobApplications()->count();
        return view('user.dashboard', compact('openJobs', 'appliedJobs'));
    }

    public function editProfile(Request $request)
    {
        return view('user.update_profile');
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->middle_name = $request->middle_name;
        $user->email = $request->email;
        // Hash the password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('update_profile_user')->with('success', 'Profile updated successfully!');
    }

    //create the user profile
} 