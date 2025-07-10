<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'birth_date' => ['required', 'date'],
            'sex' => ['required', 'in:male,female'],
            'phone_number' => ['required', 'string', 'max:20'],
            'place_of_birth' => ['required', 'string', 'max:255'],
            'region' => ['required', 'string', 'max:255'],
            'province' => [
                function ($attribute, $value, $fail) use ($request) {
                    if (!in_array($request->region, ['NCR', '130000000']) && empty($value)) {
                        $fail('The province field is required.');
                    }
                },
                'nullable',
                'string',
                'max:255'
            ],
            'city' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'street_building_unit' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'g-recaptcha-response' => ['required', 'captcha'], // captcha temporarily disabled
        ]);

        // Set province to null if region is NCR
        $province = $request->province;
        if (in_array($request->region, ['NCR', '130000000'])) {
            $province = null;
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'suffix' => $request->suffix,
            'birth_date' => $request->birth_date,
            'sex' => $request->sex,
            'phone_number' => $request->phone_number,
            'place_of_birth' => $request->place_of_birth,
            'region' => $request->region,
            'province' => $province,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'street_building_unit' => $request->street_building_unit,
            'zipcode' => $request->zipcode,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => 'assets/images/image7.png', // Set default profile image
        ]);

        event(new Registered($user));

        // Don't automatically log in the user
        // Auth::login($user);

        // Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Account created successfully! Please log in with your email and password.');
    }
}
