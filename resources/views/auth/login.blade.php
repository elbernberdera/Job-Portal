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
            <img src="{{ asset('assets\images\login_logo.png') }}" alt="DICT Logo" class="w-33 h-10 mb-4 mx-auto" />
            <!-- <h2 class="text-2xl font-extrabold text-center mb-1 mt-2 tracking-wide">WELCOME TO DICT JOB PORTAL</h2> -->
            <!-- <p class="text-gray-600 text-center mb-6">Please log in using the form below.</p> -->

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
                <div class="mb-2 relative">
                    <label for="password" class="form-label">Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required autocomplete="current-password" class="form-control pr-10" style="padding-right: 2.5rem;" />
                        <button type="button" id="togglePassword" tabindex="-1"
                            class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-600 focus:outline-none"
                            style="top: 50%; transform: translateY(-50%); background: transparent; border: none;">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.787C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zm0 1a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3z"/>
                            </svg>
                        </button>
                    </div>
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
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-400 hover:from-blue-700 hover:to-blue-500 text-white font-bold py-2 px-4 rounded-lg shadow-md text-lg transition-all duration-200 ease-in-out mb-4">Log in</button>
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
                <a href="{{ route('register') }}" class="text-blue-700 font-semibold hover:underline ml-1">Sign up</a>
            </div>
        </div>
    </div>
</body>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('togglePassword');
        let eyeIcon = document.getElementById('eyeIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            // Replace with eye-slash SVG
            eyeIcon.outerHTML = `<svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                <path d="M13.359 11.238l2.122 2.122a.75.75 0 1 1-1.06 1.06l-2.122-2.121A7.967 7.967 0 0 1 8 13.5c-5 0-8-5.5-8-5.5a15.634 15.634 0 0 1 3.279-3.978L1.646 3.646a.75.75 0 1 1 1.06-1.06l12 12a.75.75 0 0 1-1.06 1.06zm-2.122-2.122l-1.06-1.06A2.5 2.5 0 0 1 5.5 8c0-.638.237-1.223.627-1.673l-1.06-1.06A3.5 3.5 0 0 0 4.5 8a3.5 3.5 0 0 0 5.737 2.116zm-2.116-2.116l-2-2A1.5 1.5 0 0 1 8 6.5c.638 0 1.223.237 1.673.627zm6.08 2.288C14.879 11.332 13.12 12.5 11 12.5c-1.02 0-1.98-.195-2.828-.547l-1.06-1.06A7.967 7.967 0 0 1 8 13.5c5 0 8-5.5 8-5.5a15.634 15.634 0 0 0-3.279-3.978l-1.06 1.06A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288z"/>
                <path d="M11.354 8.354a3.5 3.5 0 0 0-4.708-4.708l1.06 1.06A2.5 2.5 0 0 1 10.5 8c0 .638-.237 1.223-.627 1.673l1.06 1.06A3.5 3.5 0 0 0 11.354 8.354z"/>
            </svg>`;
        } else {
            passwordInput.type = 'password';
            // Replace with eye SVG
            eyeIcon.outerHTML = `<svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.787C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zm0 1a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3z"/>
            </svg>`;
        }
        // Re-attach the event listener to the new SVG
        document.getElementById('eyeIcon').parentElement.addEventListener('click', arguments.callee);
    });
</script>
</html>
