<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('user.user_profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:1',
            'suffix' => 'nullable|string|max:10',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_initial' => $request->middle_initial,
            'suffix' => $request->suffix,
        ]);

        // Log activity
        ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->first_name . ' ' . $user->last_name,
            'email' => $user->email,
            'ip_address' => $request->ip(),
            'device' => $request->header('User-Agent'),
            'activity' => 'Updated Profile',
            'role' => $user->role,
        ]);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete('profile_images/' . $user->profile_image);
        }

        $imageName = time() . '.' . $request->profile_image->extension();
        $request->profile_image->storeAs('profile_images', $imageName, 'public');

        $user->profile_image = $imageName;
        $user->save();

        return back()->with('success', 'Profile image updated!');
    }
} 