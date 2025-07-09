<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Job Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- XSS Protection Meta Tags -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' https://www.google.com/recaptcha/ https://www.gstatic.com/recaptcha/; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; frame-src https://www.google.com/recaptcha/ https://www.gstatic.com/recaptcha/;">
    <style>
    /* .custom-bg-logo::before {
        content: "";
        position: absolute;
        top: 35%;
        left: 50%;
        width: 500px;
        height: 500px;
        background: url('/assets/images/image.png') no-repeat center center;
        background-size: contain;
        opacity: 0.80;
        transform: translate(-50%, -50%);
        z-index: 0;
        pointer-events: none;
    }
    .custom-bg-logo > * {
        position: relative;
        z-index: 1;
    } */
    .animated-gradient {
      background: linear-gradient(to right, #2563eb,rgb(214, 214, 214));
      background-size: 200% 100%;
      background-position: left;
      transition: background-position 0.4s ease-in-out;
    }
    .animated-gradient:hover {
      background-position: right;
    }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Left Side (Logo & Title) -->
    <div class="hidden md:flex md:w-1/3 bg-gradient-to-b from-blue-700 to-yellow-300 flex-col items-center justify-start p-8 text-white relative">
        <img src="{{ asset('assets/images/image2.png') }}" alt="" class="w-44 h-44 object-contain" />
        <h1 class="text-3xl font-extrabold  select-none tracking-wide">JOB PORTAL</h1>
        <img src="{{ asset('assets/images/image3.png') }}" alt="" class="w-90 h-90 object-contain mb-1" />
    </div>
    <!-- Right Side (Form) -->
    <div class="w-full md:w-2/3 flex flex-col justify-center p-4 md:p-12 bg-white relative">
        <form method="POST" action="{{ route('register') }}" class="w-full max-w-4xl mx-auto bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 md:p-12" id="registerForm">
            @csrf

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ htmlspecialchars(session('success'), ENT_QUOTES, 'UTF-8') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ htmlspecialchars(session('error'), ENT_QUOTES, 'UTF-8') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">ayay ka!</strong>
                    <span class="block sm:inline">There were some problems with your input.</span>
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ htmlspecialchars($error, ENT_QUOTES, 'UTF-8') }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex justify-center mb-4 md:hidden">
                <img src="{{ asset('assets/images/image.png') }}" alt="Logo" class="h-20 w-auto" style="max-width: 120px;">
            </div>
            <h2 class="text-4xl font-extrabold text-center mb-10 mt-2 tracking-wide text-indigo-800 select-none">Registration Form</h2>
            <div class="space-y-7">
                <!-- Name Row -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div>
                    <x-input-label for="first_name" class="font-semibold text-gray-800">{{ __('First Name') }} <span class="text-red-600">*</span></x-input-label>
                    <x-text-input id="first_name" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" type="text" name="first_name" :value="htmlspecialchars(old('first_name'), ENT_QUOTES, 'UTF-8')" required autofocus placeholder="First Name" maxlength="50" pattern="[A-Za-z\s]+" oninput="sanitizeInput(this)" />
                </div>


                <!-- sa midlle initial pag want center and place holder "text-center" -->
                    <div>
                        <x-input-label for="middle_name" :value="__('Middle Name')" class="font-semibold text-gray-800" />
                        <x-text-input id="middle_name" class="block mt-1 w-full  bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" type="text" name="middle_name" :value="htmlspecialchars(old('middle_name'), ENT_QUOTES, 'UTF-8')" maxlength="50" placeholder="Middle Name" pattern="[A-Za-z\s]+" oninput="sanitizeInput(this)" />
                    </div>
                    <div>
                        <x-input-label for="last_name"  class="font-semibold text-gray-800">{{ __('Last Name') }} <span class="text-red-600">*</span></x-input-label>
                        <x-text-input id="last_name" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" type="text" name="last_name" :value="htmlspecialchars(old('last_name'), ENT_QUOTES, 'UTF-8')" required placeholder="Last Name" maxlength="50" pattern="[A-Za-z\s]+" oninput="sanitizeInput(this)" />
                    </div>
                    <div>
                        <x-input-label for="suffix" :value="__('Suffix')" class="font-semibold text-gray-800" />
                        <select id="suffix" name="suffix" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3">
                            <option value="">-- None --</option>
                            <option value="Jr." {{ old('suffix') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                            <option value="Sr." {{ old('suffix') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                            <option value="I" {{ old('suffix') == 'I' ? 'selected' : '' }}>I</option>
                            <option value="II" {{ old('suffix') == 'II' ? 'selected' : '' }}>II</option>
                            <option value="III" {{ old('suffix') == 'III' ? 'selected' : '' }}>III</option>
                            <option value="IV" {{ old('suffix') == 'IV' ? 'selected' : '' }}>IV</option>
                            <option value="V" {{ old('suffix') == 'V' ? 'selected' : '' }}>V</option>
                        </select>
                    </div>
                    
                </div>
                <!-- Birth/Sex/Phone Number Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <x-input-label for="birth_date"  class="font-semibold text-gray-800">{{ __('Birth Date') }} <span class="text-red-600">*</span></x-input-label>
                        <x-text-input id="birth_date" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" type="date" name="birth_date" :value="htmlspecialchars(old('birth_date'), ENT_QUOTES, 'UTF-8')" required onchange="validateAge()" />
                        <div id="ageWarning" class="hidden text-red-600 text-sm mt-1">You must be at least 18 years old to register.</div>
                    </div>
                    <div>
                        <x-input-label for="sex"  class="font-semibold text-gray-800">{{ __('Sex') }} <span class="text-red-600">*</span></x-input-label>
                        <select id="sex" name="sex" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" required>
                            <option value="">-- Select Gender --</option>
                            <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="phone_number"  class="font-semibold text-gray-800">{{ __('Phone Number') }} <span class="text-red-600">*</span></x-input-label>
                        <x-text-input id="phone_number" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" type="tel" name="phone_number" :value="htmlspecialchars(old('phone_number'), ENT_QUOTES, 'UTF-8')" required placeholder="09XXXXXXXXX" pattern="09[0-9]{9}" maxlength="11" oninput="sanitizePhone(this)" />
                        <p class="text-xs text-gray-500 mt-1"></p>
                    </div>
                </div>
                <!-- Place of Birth / Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="place_of_birth"  class="font-semibold text-gray-800">{{ __('Place of Birth') }} <span class="text-red-600">*</span></x-input-label>
                        <x-text-input id="place_of_birth" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" type="text" name="place_of_birth" :value="htmlspecialchars(old('place_of_birth'), ENT_QUOTES, 'UTF-8')" required placeholder="Place of Birth" maxlength="100" pattern="[A-Za-z\s,.-]+" oninput="sanitizeInput(this)" />
                    </div>
                    <div>
                        <x-input-label for="email"  class="font-semibold text-gray-800">{{ __('Email Address') }} <span class="text-red-600">*</span></x-input-label>
                        <x-text-input id="email" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" type="email" name="email" :value="htmlspecialchars(old('email'), ENT_QUOTES, 'UTF-8')" required placeholder="Email Address" maxlength="255" oninput="sanitizeEmail(this)" />
                    </div>
                </div>
                <!-- Address Label -->
                <div>
                    <x-input-label :value="__('Address')" class="font-bold text-xl text-gray-800" />
                </div>
                <!-- Address Row 1 (Region, Province, City) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <x-input-label for="region"  class="font-semibold text-gray-800">{{ __('Region') }} <span class="text-red-600">*</span></x-input-label>
                        <select id="region" name="region" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" required>
                            <option value="">Select Region</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="province"  class="font-semibold text-gray-800">{{ __('Province') }} <span class="text-red-600">*</span></x-input-label>
                        <select id="province" name="province" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" required>
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="city"  class="font-semibold text-gray-800">{{ __('City/Municipality') }} <span class="text-red-600">*</span></x-input-label>
                        <select id="city" name="city" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" required>
                            <option value="">Select City/Municipality</option>
                        </select>
                    </div>
                </div>
                <!-- Address Row 2 (Barangay, Street/Building/Unit, Zipcode) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <x-input-label for="barangay" class="font-semibold text-gray-800">{{ __('Barangay') }} <span class="text-red-600">*</span></x-input-label>
                        <select id="barangay" name="barangay" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" required>
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="street_building_unit"  class="font-semibold text-gray-800">{{ __('Street/Building/Unit') }} <span class="text-red-600">*</span></x-input-label>
                        <x-text-input id="street_building_unit" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" type="text" name="street_building_unit" :value="htmlspecialchars(old('street_building_unit'), ENT_QUOTES, 'UTF-8')" required placeholder="Street/Building/Unit" maxlength="200" pattern="[A-Za-z0-9\s,.-#]+" oninput="sanitizeInput(this)" />
                    </div>
                    <div>
                        <x-input-label for="zipcode"  class="font-semibold text-gray-800">{{ __('Zipcode') }} <span class="text-red-600">*</span></x-input-label>
                        <x-text-input id="zipcode" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" type="text" name="zipcode" :value="htmlspecialchars(old('zipcode'), ENT_QUOTES, 'UTF-8')" required placeholder="Zipcode" maxlength="10" pattern="[0-9]+" oninput="sanitizeZipcode(this)" />
                    </div>
                </div>
                <!-- Password Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="password"  class="font-semibold text-gray-800">{{ __('Password') }} <span class="text-red-600">*</span></x-input-label>
                        <x-text-input id="password" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" type="password" name="password" required autocomplete="new-password" placeholder="Password" minlength="8" maxlength="255" oninput="validatePassword(this)" onfocus="showPasswordRequirements()" onblur="hidePasswordRequirements()" />
                        <div id="password-requirements" class="text-xs mt-1 space-y-1 hidden">
                            <div id="length-check" class="text-gray-500">• At least 8 characters</div>
                            <div id="uppercase-check" class="text-gray-500">• One uppercase letter</div>
                            <div id="number-check" class="text-gray-500">• One number</div>
                            <div id="special-check" class="text-gray-500">• One Special character (.@$!%*?&)</div>
                        </div>
                        <div id="password-strength" class="text-xs mt-1 font-medium"></div>
                    </div>
                    <div class="relative">
                        <x-input-label for="password_confirmation"  class="font-semibold text-gray-800">{{ __('Confirm Password') }} <span class="text-red-600">*</span></x-input-label>
                        <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3 pr-10" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" minlength="8" maxlength="255" oninput="validateConfirmPassword(this)" onfocus="showPasswordMatch()" onblur="hidePasswordMatch()" />
                        <button type="button" id="toggle-confirm-password" class="absolute top-8 right-3 text-gray-500 focus:outline-none" tabindex="-1" onclick="toggleConfirmPasswordVisibility()">
                            <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95m3.671-2.634A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.306M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" /></svg>
                        </button>
                        <div id="confirm-password-match" class="text-xs mt-1 font-medium hidden"></div>
                    </div>
                </div>
                <!-- Terms and Button -->
                <div class="flex flex-col items-start gap-4 mt-4">
                    <div class="flex items-center">
                        <input
                          id="terms"
                          name="terms"
                          type="checkbox"
                          class="h-4 w-4 accent-blue-600 rounded border-gray-300"
                          required
                        />
                        <label for="terms" class="ml-2 block text-sm text-gray-900 select-none">
                          <span class="text-blue-600"></span><span> Terms and condition</span>
                        </label>
                        <!-- Make the label text clickable for modal -->
                        <span
                          id="terms-link"
                          class="ml-2 text-blue-600 cursor-pointer underline select-none"
                          >Read the Terms & Conditions</span
                        >
                      </div>

                       <!-- Google reCAPTCHA widget (NoCaptcha) -->
<div class="w-full flex justify-start">
    {!! NoCaptcha::display() !!}
</div>
@if ($errors->has('g-recaptcha-response'))
    <span class="text-red-600 text-sm">{{ $errors->first('g-recaptcha-response') }}</span>
@endif



                      <div class="w-full flex justify-center">


                       
                        <button
                          type="submit"
                          id="signup-button"
                          class="w-full md:w-1/2 bg-gray-400 text-white font-bold py-3 px-10 rounded-lg shadow-lg text-2xl transition-all duration-200 ease-in-out tracking-wide disabled:cursor-not-allowed"
                          disabled
                        >
                          Sign Up
                        </button>
                      </div>
                    </div>
                    <!-- Login Link -->
                    <div class="text-center mt-6">
                        <span>Already have an account?</span>
                        <a href="{{ route('login') }}" class="text-blue-700 font-semibold hover:underline ml-1">Login Here</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div
  id="terms-modal"
  class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50"
>
  <div class="bg-white rounded-lg p-6 max-w-4xl w-full max-h-96 overflow-y-auto">
    <h2 class="text-xl font-bold mb-4 text-center">Terms and Conditions</h2>
    <div class="text-sm space-y-3">
      <p class="font-semibold">1. ACCEPTANCE OF TERMS</p>
      <p>By accessing and using this Job Portal, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>
      
      <p class="font-semibold">2. ELIGIBILITY</p>
      <p>You must be at least 18 years old to register and use this Job Portal. By registering, you represent and warrant that you are at least 18 years of age and have the legal capacity to enter into this agreement.</p>
      
      <p class="font-semibold">3. USER ACCOUNT</p>
      <p>You are responsible for maintaining the confidentiality of your account and password. You agree to accept responsibility for all activities that occur under your account or password.</p>
      
      <p class="font-semibold">4. PRIVACY POLICY</p>
      <p>Your privacy is important to us. Please review our Privacy Policy, which also governs your use of the Job Portal, to understand our practices. Your personal information will be collected, used, and disclosed in accordance with the Data Privacy Act of 2012 (Republic Act No. 10173).</p>
      
      <p class="font-semibold">5. ACCURATE INFORMATION</p>
      <p>You agree to provide accurate, current, and complete information during the registration process and to update such information to keep it accurate, current, and complete. The Job Portal reserves the right to suspend or terminate your account if any information provided during the registration process or thereafter proves to be inaccurate, not current, or incomplete.</p>
      
      <p class="font-semibold">6. PROHIBITED USES</p>
      <p>You may not use the Job Portal for any unlawful purpose or to solicit others to perform unlawful acts. You may not violate any international, federal, provincial, or state regulations, rules, laws, or local ordinances.</p>
      
      <p class="font-semibold">7. INTELLECTUAL PROPERTY</p>
      <p>The Job Portal and its original content, features, and functionality are and will remain the exclusive property of the Job Portal and its licensors. The Job Portal is protected by copyright, trademark, and other laws of the Philippines.</p>
      
      <p class="font-semibold">8. TERMINATION</p>
      <p>We may terminate or suspend your account and bar access to the Job Portal immediately, without prior notice or liability, under our sole discretion, for any reason whatsoever and without limitation, including but not limited to a breach of the Terms.</p>
      
      <p class="font-semibold">9. GOVERNING LAW</p>
      <p>These Terms shall be interpreted and governed by the laws of the Republic of the Philippines, without regard to its conflict of law provisions.</p>
      
      <p class="font-semibold">10. CHANGES TO TERMS</p>
      <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material, we will try to provide at least 30 days notice prior to any new terms taking effect.</p>
      
      <p class="font-semibold">11. CONTACT INFORMATION</p>
      <p>If you have any questions about these Terms and Conditions, please contact us at support@jobportal.ph</p>
      
      <p class="text-xs text-gray-600 mt-4">Last updated: {{ date('F d, Y') }}</p>
    </div>
    <div class="mt-6 text-center">
      <button
        id="close-modal"
        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors"
      >
        I Agree
      </button>
    </div>
  </div>
</div>

<script>
  // Password Requirements Show/Hide Functions
  function showPasswordRequirements() {
    const requirements = document.getElementById('password-requirements');
    requirements.classList.remove('hidden');
  }

  function hidePasswordRequirements() {
    const requirements = document.getElementById('password-requirements');
    const passwordInput = document.getElementById('password');
    
    // Only hide if password field is empty or if user clicks outside
    if (passwordInput.value.length === 0) {
      requirements.classList.add('hidden');
    }
  }

  // XSS Protection Functions
  function sanitizeInput(input) {
    // Remove any HTML tags and dangerous characters
    let value = input.value;
    value = value.replace(/<[^>]*>/g, ''); // Remove HTML tags
    value = value.replace(/[<>\"'&]/g, ''); // Remove dangerous characters
    value = value.replace(/javascript:/gi, ''); // Remove javascript: protocol
    value = value.replace(/on\w+=/gi, ''); // Remove event handlers
    input.value = value;
  }

  function sanitizeEmail(input) {
    let value = input.value;
    // Only allow valid email characters
    value = value.replace(/[^a-zA-Z0-9@._-]/g, '');
    input.value = value;
  }

  function sanitizePhone(input) {
    let value = input.value;
    
    // Remove any non-numeric characters
    value = value.replace(/[^0-9]/g, '');
    
    // If user starts typing and doesn't have "09" at the beginning, add it
    if (value.length > 0 && !value.startsWith('09')) {
      // If the first digit is 9, add 0 at the beginning
      if (value.startsWith('9')) {
        value = '0' + value;
      } else {
        // If it doesn't start with 9, replace with 09
        value = '09' + value;
      }
    }
    
    // Limit to 11 digits maximum
    if (value.length > 11) {
      value = value.substring(0, 11);
    }
    
    // Ensure it always starts with "09" for Philippine format
    if (value.length >= 2 && value.substring(0, 2) !== '09') {
      // If it doesn't start with "09", show error
      if (value.length > 0) {
        input.style.borderColor = '#ef4444'; // Red border for error
        input.title = 'Phone number must start with 09 (Philippine mobile format)';
      }
    } else {
      // Valid format, remove error styling
      input.style.borderColor = '';
      input.title = '';
    }
    
    input.value = value;
  }

  function sanitizeZipcode(input) {
    let value = input.value;
    // Only allow numbers
    value = value.replace(/[^0-9]/g, '');
    input.value = value;
  }

  function validatePassword(input) {
    let value = input.value;
    
    // Remove any HTML tags and dangerous characters
    value = value.replace(/<[^>]*>/g, '');
    value = value.replace(/[<>\"'&]/g, '');
    
    // Check for password requirements
    const hasUpperCase = /[A-Z]/.test(value);
    const hasNumber = /[0-9]/.test(value);
    const hasMinLength = value.length >= 8;
    const hasSpecialChar = /[.@$!%*?&]/.test(value);

    
    // Update requirement indicators in real-time
    const lengthCheck = document.getElementById('length-check');
    const uppercaseCheck = document.getElementById('uppercase-check');
    const numberCheck = document.getElementById('number-check');
    const specialCheck = document.getElementById('special-check');
    const strengthIndicator = document.getElementById('password-strength');
    
    // Update length requirement
    if (hasMinLength) {
      lengthCheck.innerHTML = '✅ At least 8 characters';
      lengthCheck.className = 'text-green-600 font-medium';
    } else {
      lengthCheck.innerHTML = '• At least 8 characters';
      lengthCheck.className = 'text-gray-500';
    }
    
    // Update uppercase requirement
    if (hasUpperCase) {
      uppercaseCheck.innerHTML = '✅ One uppercase letter';
      uppercaseCheck.className = 'text-green-600 font-medium';
    } else {
      uppercaseCheck.innerHTML = '• One uppercase letter';
      uppercaseCheck.className = 'text-gray-500';
    }
    
    // Update number requirement
    if (hasNumber) {
      numberCheck.innerHTML = '✅ One number';
      numberCheck.className = 'text-green-600 font-medium';
    } else {
      numberCheck.innerHTML = '• One number';
      numberCheck.className = 'text-gray-500';
    }
    
    // Update special character requirement
    if (hasSpecialChar) {
      specialCheck.innerHTML = '✅ One Special character (.@$!%*?&)';
      specialCheck.className = 'text-green-600 font-medium';
    } else {
      specialCheck.innerHTML = '• One Special character (.@$!%*?&)';
      specialCheck.className = 'text-gray-500';
    }

    // Calculate password strength
    let strength = 0;
    if (hasMinLength) strength++;
    if (hasUpperCase) strength++;
    if (hasNumber) strength++;
    if (hasSpecialChar) strength++;
    
    // Update strength indicator
    if (value.length === 0) {
      strengthIndicator.innerHTML = '';
      strengthIndicator.className = 'text-xs mt-1 font-medium';
    } else if (strength === 4) {
      strengthIndicator.innerHTML = '🔒 Strong Password';
      strengthIndicator.className = 'text-xs mt-1 font-medium text-green-600';
    } else if (strength >= 2) {
      strengthIndicator.innerHTML = '⚠️ Medium Password';
      strengthIndicator.className = 'text-xs mt-1 font-medium text-yellow-600';
    } else {
      strengthIndicator.innerHTML = '❌ Weak Password';
      strengthIndicator.className = 'text-xs mt-1 font-medium text-red-600';
    }
    
    // Update input styling based on validation
    if (value.length > 0) {
      if (hasUpperCase && hasNumber && hasMinLength && hasSpecialChar) {
        // All requirements met
        input.style.borderColor = '#10b981'; // Green border
        input.title = 'Password meets all requirements';
      } else {
        // Missing requirements
        input.style.borderColor = '#f59e0b'; // Orange border
        let missingRequirements = [];
        if (!hasMinLength) missingRequirements.push('at least 8 characters');
        if (!hasUpperCase) missingRequirements.push('one uppercase letter');
        if (!hasNumber) missingRequirements.push('one number');
        if (!hasSpecialChar) missingRequirements.push('one special character (.@$!%*?&)');
        input.title = 'Missing: ' + missingRequirements.join(', ');
      }
    } else {
      // Empty field, remove styling
      input.style.borderColor = '';
      input.title = '';
    }
    
    input.value = value;
  }

  function validateConfirmPassword(input) {
    const passwordInput = document.getElementById('password');
    const confirmPasswordMatch = document.getElementById('confirm-password-match');
    let value = input.value;

    // Remove any HTML tags and dangerous characters
    value = value.replace(/<[^>]*>/g, '');
    value = value.replace(/[<>\"'&]/g, '');
    input.value = value;

    if (passwordInput.value === value) {
      confirmPasswordMatch.innerHTML = '✅ Passwords match';
      confirmPasswordMatch.className = 'text-xs mt-1 font-medium text-green-600';
      input.style.borderColor = '#10b981'; // Green border
    } else if (value.length > 0) {
      confirmPasswordMatch.innerHTML = '❌ Passwords do not match';
      confirmPasswordMatch.className = 'text-xs mt-1 font-medium text-red-600';
      input.style.borderColor = '#ef4444'; // Red border
    } else {
      confirmPasswordMatch.innerHTML = '';
      confirmPasswordMatch.className = 'text-xs mt-1 font-medium';
      input.style.borderColor = '';
    }
  }

  function validateAge() {
    const birthDateInput = document.getElementById("birth_date");
    const birthDate = new Date(birthDateInput.value);
    const warning = document.getElementById("ageWarning");
    
    if (isNaN(birthDate.getTime())) { // Invalid or empty date
        warning.classList.add("hidden");
        return;
    }

    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const m = today.getMonth() - birthDate.getMonth();

    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    if (age < 18) {
        warning.classList.remove("hidden");
    } else {
        warning.classList.add("hidden");
    }
  }

  // Form submission protection
  document.getElementById('registerForm').addEventListener('submit', function(e) {
    const inputs = this.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"]');
    inputs.forEach(input => {
      if (input.value) {
        // Double-check for XSS attempts
        if (input.value.includes('<script>') || 
            input.value.includes('javascript:') || 
            input.value.includes('onerror=') ||
            input.value.includes('onload=')) {
          e.preventDefault();
          alert('Invalid input detected. Please check your input and try again.');
          return false;
        }
      }
    });
    
    // Validate Age on submit
    const birthDateInput = document.getElementById('birth_date');
    if (birthDateInput.value) {
        const birthDate = new Date(birthDateInput.value);
        if (!isNaN(birthDate.getTime())) {
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            if (age < 18) {
                e.preventDefault();
                alert('You must be at least 18 years old to register.');
                birthDateInput.focus();
                return false;
            }
        }
    }

    // Validate Philippine phone number format
    const phoneInput = document.getElementById('phone_number');
    if (phoneInput.value) {
      const phoneRegex = /^09[0-9]{9}$/;
      if (!phoneRegex.test(phoneInput.value)) {
        e.preventDefault();
        alert('Please enter a valid Philippine mobile number starting with 09 followed by 9 digits (e.g., 09123456789)');
        phoneInput.focus();
        return false;
      }
    }
    
    // Validate password requirements
    const passwordInput = document.getElementById('password');
    if (passwordInput.value) {
      const hasUpperCase = /[A-Z]/.test(passwordInput.value);
      const hasNumber = /[0-9]/.test(passwordInput.value);
      const hasMinLength = passwordInput.value.length >= 8;
      const hasSpecialChar = /[.@$!%*?&]/.test(passwordInput.value);
      
      if (!hasUpperCase || !hasNumber || !hasMinLength || !hasSpecialChar) {
        e.preventDefault();
        let missingRequirements = [];
        if (!hasMinLength) missingRequirements.push('at least 8 characters');
        if (!hasUpperCase) missingRequirements.push('one uppercase letter');
        if (!hasNumber) missingRequirements.push('one number');
        if (!hasSpecialChar) missingRequirements.push('one special character (.@$!%*?&)');
        alert('Password must contain: ' + missingRequirements.join(', '));
        passwordInput.focus();
        return false;
      }
    }

    // Validate confirm password match
    const confirmPasswordInput = document.getElementById('password_confirmation');
    if (passwordInput.value !== confirmPasswordInput.value) {
      e.preventDefault();
      alert('Password and Confirm Password do not match.');
      confirmPasswordInput.focus();
      return false;
    }
  });

  // Existing modal and checkbox functionality
  const termsCheckbox = document.getElementById('terms');
  const signupButton = document.getElementById('signup-button');
  const termsLink = document.getElementById('terms-link');
  const termsModal = document.getElementById('terms-modal');
  const closeModal = document.getElementById('close-modal');

  // Enable button and style on checkbox change
  termsCheckbox.addEventListener('change', () => {
    if (termsCheckbox.checked) {
      signupButton.disabled = false;
      signupButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
      signupButton.classList.add('animated-gradient', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded-lg', 'shadow-md', 'text-lg', 'transition-all', 'duration-500', 'ease-in-out', 'w-full');
    } else {
      signupButton.disabled = true;
      signupButton.classList.remove('animated-gradient');
      signupButton.classList.add('bg-gray-400', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded-lg', 'shadow-md', 'text-lg', 'transition-all', 'duration-500', 'ease-in-out', 'w-full', 'cursor-not-allowed');
    }
  });

  // Open modal on clicking the "Read Terms" text
  termsLink.addEventListener('click', () => {
    termsModal.classList.remove('hidden');
  });

  // Close modal on clicking the close button
  closeModal.addEventListener('click', () => {
    termsModal.classList.add('hidden');
    termsCheckbox.checked = true;
    termsCheckbox.dispatchEvent(new Event('change'));
  });

  // Optional: close modal when clicking outside modal content
  termsModal.addEventListener('click', (e) => {
    if (e.target === termsModal) {
      termsModal.classList.add('hidden');
    }
  });

  // Show/hide confirm password match message
  function showPasswordMatch() {
    document.getElementById('confirm-password-match').classList.remove('hidden');
  }
  function hidePasswordMatch() {
    document.getElementById('confirm-password-match').classList.add('hidden');
  }

  function toggleConfirmPasswordVisibility() {
    const passwordInput = document.getElementById('password_confirmation');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      eyeOpen.classList.add('hidden');
      eyeClosed.classList.remove('hidden');
    } else {
      passwordInput.type = 'password';
      eyeOpen.classList.remove('hidden');
      eyeClosed.classList.add('hidden');
    }
  }
</script>

<!-- PSGC API Integration -->
<script src="{{ asset('js/components/AddressDropdowns.js') }}"></script>
<script>
// Initialize PSGC API address dropdowns
document.addEventListener('DOMContentLoaded', function() {
    const addressDropdowns = new AddressDropdowns({
        regionSelect: '#region',
        provinceSelect: '#province',
        citySelect: '#city',
        barangaySelect: '#barangay',
        loadingText: 'Loading...',
        placeholderText: 'Select...'
    });

    // Store the instance globally for form submission
    window.addressDropdowns = addressDropdowns;
});

// Update form validation to use PSGC codes
document.getElementById('registerForm').addEventListener('submit', function(e) {
    // ... existing validation code ...
    
    // Validate address selections
    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const barangaySelect = document.getElementById('barangay');
    
    if (!regionSelect.value) {
        e.preventDefault();
        alert('Please select a region.');
        regionSelect.focus();
        return false;
    }
    
    if (!provinceSelect.value) {
        e.preventDefault();
        alert('Please select a province.');
        provinceSelect.focus();
        return false;
    }
    
    if (!citySelect.value) {
        e.preventDefault();
        alert('Please select a city/municipality.');
        citySelect.focus();
        return false;
    }
    
    if (!barangaySelect.value) {
        e.preventDefault();
        alert('Please select a barangay.');
        barangaySelect.focus();
        return false;
    }
});
</script>

<!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script>
{!! NoCaptcha::renderJs() !!} -->
</body>
</html>

