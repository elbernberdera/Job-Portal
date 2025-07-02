<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>JobPortal - Find Your Dream Job</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- AOS Animation Library -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        
        <!-- Typed.js for Typewriter Effect -->
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
        
        <!-- Custom Styles -->
        <style>
            .gradient-bg {
                background: linear-gradient(-45deg, #3b82f6, #fbbf24, rgb(59, 140, 246));
                background-size: 200% 200%;
                animation: gradient-move 8s ease-in-out infinite;
                position: relative;
                overflow: hidden;
            }
            @keyframes gradient-move {
                0% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
                100% {
                    background-position: 0% 50%;
                }
            }
            .gradient-button, .register-gradient-button {
                background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
                color: white;
                transition: all 0.3s ease;
            }
            .gradient-button:hover, .register-gradient-button:hover {
                background: linear-gradient(135deg, #3b82f6 0%, #93c5fd 100%);
                transform: translateY(-2px);
            }
            .hero-logo-bg {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 700px;
                max-width: 80vw;
                opacity: 0.15;
                z-index: 1;
                pointer-events: none;
                user-select: none;
            }
            .card-hover:hover {
                transform: translateY(-5px);
                transition: all 0.3s ease;
            }
            .search-shadow {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            .typed-sub {
                display: block;
                font-size: 1.25rem;
                font-weight: 400;
                color: rgb(255 255 255 / 0.9);
                margin-top: 1rem;
            }
            .fade-out {
                animation: fadeOut 1s forwards;
            }
            .text-shadow {
                text-shadow: 0 2px 8px rgba(30, 41, 59, 0.25), 0 1px 2px rgba(0,0,0,0.15);
            }
            .gradient-blue-text {
                color: #2563eb;
                text-shadow: 0 0 12px #2563eb, 0 0 24px #60a5fa;
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.25);
                border-radius: 1rem;
                box-shadow: 0 4px 24px rgba(30, 41, 59, 0.08), 0 1.5px 6px rgba(0,0,0,0.04);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255,255,255,0.18);
            }
            
            /* Predictive Search Styles */
            .suggestion-item {
                transition: background-color 0.15s ease;
            }
            
            .suggestion-item:hover {
                background-color: #f3f4f6 !important;
            }
            
            .suggestion-item.bg-blue-100 {
                background-color: #dbeafe !important;
            }
            
            #job_title_suggestions,
            #location_suggestions {
                top: 100%;
                left: 0;
                right: 0;
                margin-top: 2px;
            }
            
            /* Loading animation */
            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }
            
            .animate-spin {
                animation: spin 1s linear infinite;
            }
        </style>
    </head>
    <body class="antialiased bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="text-2xl font-bold text-blue-600">JobPortal</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="register-gradient-button px-4 py-2 rounded-md font-semibold">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="gradient-bg">
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col justify-center items-center min-h-[570px]">
                <img src="/assets/images/dict logo.png" alt="Logo" class="hero-logo-bg" aria-hidden="true">
                <div class="text-center relative z-10" data-aos="fade-up">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 text-shadow">
                        <span id="typed-title"></span>
                    </h1>
                    <form method="GET" action="/" class="bg-white p-4 rounded-lg search-shadow max-w-3xl mx-auto flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input type="text" name="job_title" id="job_title_input" placeholder="Job title or keyword" value="{{ request('job_title') }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <div id="job_title_suggestions" class="absolute z-50 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto"></div>
                        </div>
                        <div class="flex-1 relative">
                            <input type="text" name="location" id="location_input" placeholder="Location" value="{{ request('location') }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <div id="location_suggestions" class="absolute z-50 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto"></div>
                        </div>
                        <button type="submit" class="gradient-button px-8 py-2 rounded-md">
                            Search Jobs
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Latest Job Listings -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-12">
                    <h2 class="text-3xl font-bold" data-aos="fade-up">
                        @if(request('job_title') || request('location'))
                            Search Results
                        @else
                            Latest Job Opportunities
                        @endif
                    </h2>
                    @if(request('job_title') || request('location'))
                        <a href="/" class="text-indigo-600 hover:text-indigo-700">Clear Search</a>
                    @endif
                </div>
                
                @if($jobs->isEmpty())
                    <div class="text-center text-gray-500 py-8">
                        <p class="text-xl">
                            @if(request('job_title') || request('location'))
                                No jobs found matching your search criteria.
                            @else
                                No job vacancies available at the moment.
                            @endif
                        </p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($jobs as $job)
                            <div class="glass-card bg-white rounded-lg shadow-md p-6 card-hover" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-xl font-semibold text-gray-900 truncate" title="{{ $job->job_title }}">
                                        {{ $job->job_title }}
                                    </h3>
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </div>
                                
                                <div class="space-y-2 mb-4">
                                    <p class="text-gray-600 flex items-center">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        {{ $job->division }}
                                    </p>
                                    <p class="text-gray-600 flex items-center">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $job->region }}
                                    </p>
                                    @if($job->monthly_salary)
                                        <p class="text-gray-600 flex items-center">
                                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            ₱{{ number_format($job->monthly_salary, 2) }}
                                        </p>
                                    @endif
                                    <p class="text-gray-500 text-sm flex items-center">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Posted {{ $job->date_posted ? $job->date_posted->diffForHumans() : 'Recently' }}
                                    </p>
                                </div>

                                <div class="flex justify-end space-x-2">
                                    @auth
                                        <a href="{{ route('user.profile') }}" class="gradient-button px-4 py-2 rounded">
                                            Apply Now
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="gradient-button px-4 py-2 rounded">
                                            Login to Apply
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if(count($jobs) >= 8)
                        <div class="text-center mt-12">
                            <a href="{{ route('login') }}" class="gradient-button inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md">
                                View All Jobs
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Call to Action -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-2xl p-8 md:p-12 text-center" data-aos="fade-up" style="background: linear-gradient(135deg, #3b82f6 0%, #fbbf24 100%);">
                    <h2 class="text-3xl font-bold text-white mb-4 text-shadow">Ready to Start Your Career Journey?</h2>
                    <p class="text-white/90 mb-8 text-lg">Join thousands of people who've found their dream jobs through our platform</p>
                    <div class="flex flex-col md:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="register-gradient-button px-8 py-3 rounded-md font-semibold">
                            Create an Account
                        </a>
                        <a href="{{ route('login') }}" class="gradient-button px-8 py-3 rounded-md font-semibold">
                            Sign In
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">JobPortal</h3>
                        <p class="text-gray-400">Find your dream job with us. We connect talented professionals with amazing companies.</p>
                    </div>


                    <div>
                        <h4 class="font-semibold mb-4">Contact</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li>Email: support@jobportal.com</li>
                            <li>Phone: (123) 456-7890</li>
                            <li>Address: 123 Job Street</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} JobPortal. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <script>
            // Initialize AOS animations
            AOS.init({
                duration: 1000,
                once: true
            });

            // Single Typed.js instance for the full sequence
            new Typed('#typed-title', {
                strings: [
                    'Welcome to <span class="gradient-blue-text">DICT</span> Job Portal',
                    'Find Your Dream Job Today<span class="typed-sub">Discover thousands of job opportunities with top companies</span>'
                ],
                typeSpeed: 40,
                backSpeed: 70,
                backDelay: 900,
                showCursor: false,
                loop: true,
                smartBackspace: false,
            });

            // Predictive Search Functionality
            class PredictiveSearch {
                constructor(inputId, suggestionsId, type) {
                    this.input = document.getElementById(inputId);
                    this.suggestionsContainer = document.getElementById(suggestionsId);
                    this.type = type;
                    this.debounceTimer = null;
                    this.isLoading = false;
                    
                    this.init();
                }
                
                init() {
                    // Input event listener
                    this.input.addEventListener('input', (e) => {
                        this.handleInput(e.target.value);
                    });
                    
                    // Focus event listener
                    this.input.addEventListener('focus', () => {
                        if (this.input.value.length >= 3) {
                            this.showSuggestions();
                        }
                    });
                    
                    // Blur event listener (hide suggestions after a delay)
                    this.input.addEventListener('blur', () => {
                        setTimeout(() => {
                            this.hideSuggestions();
                        }, 200);
                    });
                    
                    // Keyboard navigation
                    this.input.addEventListener('keydown', (e) => {
                        this.handleKeydown(e);
                    });
                }
                
                handleInput(value) {
                    clearTimeout(this.debounceTimer);
                    
                    if (value.length < 3) {
                        this.hideSuggestions();
                        return;
                    }
                    
                    this.debounceTimer = setTimeout(() => {
                        this.fetchSuggestions(value);
                    }, 300);
                }
                
                async fetchSuggestions(query) {
                    if (this.isLoading) return;
                    
                    this.isLoading = true;
                    // Show spinner only if fetch takes longer than 150ms
                    const spinnerTimeout = setTimeout(() => {
                        if (this.isLoading) {
                            this.suggestionsContainer.innerHTML = `
                                <div class=\"p-3 text-gray-500 text-center\">
                                    <div class=\"inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600\"></div>
                                    <span class=\"ml-2\">Searching...</span>
                                </div>
                            `;
                            this.showSuggestions();
                        }
                    }, 150);
                    
                    try {
                        const response = await fetch(`/api/search/suggestions?q=${encodeURIComponent(query)}&type=${this.type}`);
                        const suggestions = await response.json();
                        clearTimeout(spinnerTimeout);
                        this.displaySuggestions(suggestions);
                    } catch (error) {
                        clearTimeout(spinnerTimeout);
                        console.error('Error fetching suggestions:', error);
                        this.hideSuggestions();
                    } finally {
                        this.isLoading = false;
                    }
                }
                
                displaySuggestions(suggestions) {
                    if (suggestions.length === 0) {
                        this.suggestionsContainer.innerHTML = `
                            <div class="p-3 text-gray-500 text-center">
                                No suggestions found
                            </div>
                        `;
                    } else {
                        this.suggestionsContainer.innerHTML = suggestions
                            .map(suggestion => `
                                <div class="suggestion-item px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0" 
                                     data-value="${suggestion}">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        <span class="text-gray-700">${suggestion}</span>
                                    </div>
                                </div>
                            `)
                            .join('');
                        
                        // Add click event listeners to suggestion items
                        this.suggestionsContainer.querySelectorAll('.suggestion-item').forEach(item => {
                            item.addEventListener('click', () => {
                                this.selectSuggestion(item.dataset.value);
                            });
                        });
                    }
                    
                    this.showSuggestions();
                }
                
                selectSuggestion(value) {
                    this.input.value = value;
                    this.hideSuggestions();
                    this.input.focus();
                    
                    // Trigger form submission after selection
                    setTimeout(() => {
                        this.input.closest('form').submit();
                    }, 100);
                }
                
                handleKeydown(e) {
                    const items = this.suggestionsContainer.querySelectorAll('.suggestion-item');
                    const currentIndex = Array.from(items).findIndex(item => item.classList.contains('bg-blue-100'));
                    
                    switch (e.key) {
                        case 'ArrowDown':
                            e.preventDefault();
                            this.navigateSuggestions(items, currentIndex, 1);
                            break;
                        case 'ArrowUp':
                            e.preventDefault();
                            this.navigateSuggestions(items, currentIndex, -1);
                            break;
                        case 'Enter':
                            if (currentIndex >= 0 && items[currentIndex]) {
                                e.preventDefault();
                                this.selectSuggestion(items[currentIndex].dataset.value);
                            }
                            break;
                        case 'Escape':
                            this.hideSuggestions();
                            break;
                    }
                }
                
                navigateSuggestions(items, currentIndex, direction) {
                    items.forEach(item => item.classList.remove('bg-blue-100'));
                    
                    let newIndex = currentIndex + direction;
                    if (newIndex < 0) newIndex = items.length - 1;
                    if (newIndex >= items.length) newIndex = 0;
                    
                    if (items[newIndex]) {
                        items[newIndex].classList.add('bg-blue-100');
                        items[newIndex].scrollIntoView({ block: 'nearest' });
                    }
                }
                
                showSuggestions() {
                    this.suggestionsContainer.classList.remove('hidden');
                }
                
                hideSuggestions() {
                    this.suggestionsContainer.classList.add('hidden');
                }
            }
            
            // Initialize predictive search for both inputs
            document.addEventListener('DOMContentLoaded', function() {
                new PredictiveSearch('job_title_input', 'job_title_suggestions', 'job_title');
                new PredictiveSearch('location_input', 'location_suggestions', 'location');
            });
        </script>
    </body>
</html>
