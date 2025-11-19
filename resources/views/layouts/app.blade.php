<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Smith Center Golf Course') }}</title>
    
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm fixed top-0 left-0 right-0 z-50 border-b border-gray-200" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 text-gray-900 hover:text-emerald-600 transition">
                        <img src="{{ asset('SC_Logo.png') }}" alt="Smith Center Logo" class="h-10 w-auto">
                        <span class="font-display text-xl font-bold hidden sm:block">Smith Center</span>
                        <span class="font-display text-xl font-bold sm:hidden">SC Golf</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-700 hover:text-emerald-600 transition {{ request()->routeIs('home') ? 'text-emerald-600' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('about') }}" class="text-sm font-semibold text-gray-700 hover:text-emerald-600 transition {{ request()->routeIs('about') ? 'text-emerald-600' : '' }}">
                        About
                    </a>
                    <a href="{{ route('rates') }}" class="text-sm font-semibold text-gray-700 hover:text-emerald-600 transition {{ request()->routeIs('rates') ? 'text-emerald-600' : '' }}">
                        Rates
                    </a>
                    <a href="{{ route('tournaments.index') }}" class="text-sm font-semibold text-gray-700 hover:text-emerald-600 transition {{ request()->routeIs('tournaments.*') ? 'text-emerald-600' : '' }}">
                        Tournaments
                    </a>
                    <a href="{{ route('leagues') }}" class="text-sm font-semibold text-gray-700 hover:text-emerald-600 transition {{ request()->routeIs('leagues') ? 'text-emerald-600' : '' }}">
                        Leagues
                    </a>
                    <a href="{{ route('instruction') }}" class="text-sm font-semibold text-gray-700 hover:text-emerald-600 transition {{ request()->routeIs('instruction') ? 'text-emerald-600' : '' }}">
                        Instruction
                    </a>
                    <a href="{{ route('contact') }}" class="text-sm font-semibold text-gray-700 hover:text-emerald-600 transition {{ request()->routeIs('contact') ? 'text-emerald-600' : '' }}">
                        Contact
                    </a>

                    @auth
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="text-sm font-semibold text-gray-700 hover:text-emerald-600 transition flex items-center">
                                <i class="fas fa-user mr-2"></i>{{ Auth::user()->name }}
                            </button>
                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                                    @if(Auth::user()->isAdmin())
                                        <div class="border-t border-gray-100"></div>
                                        <a href="{{ route('tournaments.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Create Tournament</a>
                                        <a href="{{ route('courses.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Manage Courses</a>
                                    @endif
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-emerald-600 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="ml-4 px-6 py-2 rounded-lg text-sm font-semibold bg-emerald-600 text-white hover:bg-emerald-700 transition">
                            Join Now
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-gray-700 hover:text-emerald-600 focus:outline-none">
                        <i class="fas text-2xl" :class="open ? 'fa-times' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="open" x-transition class="md:hidden bg-white border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Home</a>
                <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-50">About</a>
                <a href="{{ route('rates') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Rates</a>
                <a href="{{ route('tournaments.index') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Tournaments</a>
                <a href="{{ route('leagues') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Leagues</a>
                <a href="{{ route('instruction') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Instruction</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Contact</a>
                
                @auth
                    <div class="border-t border-gray-200 pt-2">
                        <div class="px-3 py-2 text-sm text-gray-500">{{ Auth::user()->name }}</div>
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Profile</a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('tournaments.create') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Create Tournament</a>
                            <a href="{{ route('courses.index') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Manage Courses</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Logout</button>
                        </form>
                    </div>
                @else
                    <div class="border-t border-gray-200 pt-2 space-y-1">
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-50">Login</a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-semibold bg-emerald-600 text-white hover:bg-emerald-700">Join Now</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" x-data="{ show: true }" x-show="show">
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-md">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                        <p class="text-emerald-800">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" x-data="{ show: true }" x-show="show">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <p class="text-red-800">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Page Content -->
    <main class="min-h-screen pt-16">
        @if(isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-display font-bold mb-4">Smith Center Golf</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Where tradition meets excellence on every hole
                    </p>
                </div>
                
                <div>
                    <h4 class="text-sm font-semibold mb-4 text-gray-300">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm transition">Home</a></li>
                        <li><a href="{{ route('rates') }}" class="text-gray-400 hover:text-white text-sm transition">Rates</a></li>
                        <li><a href="{{ route('tournaments.index') }}" class="text-gray-400 hover:text-white text-sm transition">Tournaments</a></li>
                        <li><a href="{{ route('leagues') }}" class="text-gray-400 hover:text-white text-sm transition">Leagues</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-sm font-semibold mb-4 text-gray-300">About</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white text-sm transition">About Us</a></li>
                        <li><a href="{{ route('facilities') }}" class="text-gray-400 hover:text-white text-sm transition">Facilities</a></li>
                        <li><a href="{{ route('instruction') }}" class="text-gray-400 hover:text-white text-sm transition">Instruction</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white text-sm transition">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-sm font-semibold mb-4 text-gray-300">Contact</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>123 Golf Course Road</li>
                        <li>Smith Center, KS 66967</li>
                        <li class="mt-3">(555) 123-4567</li>
                        <li>info@smithcentergolf.com</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Smith Center Golf Course. All rights reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
