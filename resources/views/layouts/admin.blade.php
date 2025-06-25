<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Admin Layout -->
        <div class="flex h-screen bg-gray-100">
            <!-- Sidebar -->
            <div class="hidden lg:flex lg:flex-shrink-0">
                @include('admin.base.sidebar')
            </div>

            <!-- Main Content -->
            <div class="flex flex-col flex-1 overflow-hidden">
                <!-- Top Navigation -->
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <!-- Mobile menu button and page title -->
                        <div class="flex items-center">
                            @include('admin.base.sidebar')
                            <h1 class="ml-4 text-lg font-semibold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
                        </div>

                        <!-- Right side navigation -->
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <button class="p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 rounded-md">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M9 11h.01M9 8h.01M9 5h.01M9 2h.01M6 7h.01M6 4h.01M6 1h.01M3 7h.01M3 4h.01M3 1h.01"></path>
                                </svg>
                            </button>

                            <!-- Profile dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 rounded-md">
                                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin' }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     @click.away="open = false"
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                    <hr class="my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-gray-100">
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            @if (isset($header))
                                <div class="mb-6">
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $header }}</h2>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
</html> 