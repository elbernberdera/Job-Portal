<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DICT Job Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="flex flex-col items-center justify-center w-full min-h-screen">
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 w-full max-w-md flex flex-col items-center">
            <img src="{{ asset('assets/images/image.png') }}" alt="DICT Logo" class="w-20 h-20 mb-4 mx-auto" />
            <h2 class="text-2xl font-extrabold text-center mb-1 mt-2 tracking-wide">Welcome TO DICT JOB PORTAL</h2>
            <p class="text-gray-600 text-center mb-6">Please log in using the form below.</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="w-full">
                @csrf
                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" type="email" required autofocus autocomplete="username" value="{{ old('email') }}" class="form-control" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- Password -->
                <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" class="form-control" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Forgot password?</a>
                    @endif
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md text-lg transition-all duration-200 ease-in-out mb-4">Log in</button>
            </form>
            <div class="flex items-center w-full my-2">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="mx-2 text-gray-400">Or</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>
            <button class="w-full flex items-center justify-center border border-gray-300 rounded-lg py-2 px-4 bg-white hover:bg-gray-50 mb-2">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 mr-2">
                <span class="text-gray-700 font-medium">Continue with Google</span>
            </button>
            <div class="text-center mt-2">
                <span class="text-gray-600">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-indigo-700 font-semibold hover:underline ml-1">Sign up</a>
            </div>
        </div>
    </div>
</body>
</html>
