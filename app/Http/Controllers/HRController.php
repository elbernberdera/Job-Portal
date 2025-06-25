<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HRController extends Controller
{
    /**
     * Show the HR dashboard.
     */
    public function dashboard()
    {
        return view('hr.dashboard');
    }

    public function editProfile(Request $request)
    {
        return view('hr.update_profile');
    }


    //here is the update profile hr
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

        return redirect()->route('update_profile_hr')->with('success', 'Profile updated successfully!');
    }

    //create here the controller to create job vacancies can display data and add job vacancies
} 