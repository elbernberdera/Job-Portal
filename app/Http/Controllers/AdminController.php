<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
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

        return redirect()->route('update.profile')->with('success', 'Profile updated successfully!');
    }






    // create here for the for the logs that display the times stamp what time they login and logout  
} 