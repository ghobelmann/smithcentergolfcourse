@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 h-screen min-h-[600px] flex items-center">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80" 
             alt="Golf Course" 
             class="w-full h-full object-cover opacity-40">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-display text-white mb-6 leading-tight">
            Experience Golf at<br> Smith Center
        </h1>
        <p class="text-xl sm:text-2xl text-gray-200 mb-12 font-light max-w-2xl mx-auto">
            Where tradition meets excellence on every hole
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('rates') }}" class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-all duration-300 text-lg">
                View Rates
            </a>
            <a href="{{ route('tournaments.index') }}" class="inline-flex items-center justify-center px-10 py-4 bg-white text-gray-900 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 text-lg">
                Tournaments
            </a>
        </div>
    </div>
</section>

<!-- Course Features Section -->
<section class="py-20 sm:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl sm:text-5xl font-display mb-6">Our Course Features</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Specialized facilities designed for every aspect of your game
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1532508583690-538a1436f423?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTh8fGdvbGZ8ZW58MHx8MHx8fDA%3D" 
                     alt="Championship Greens" 
                     class="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent flex items-end">
                    <div class="p-8 w-full">
                        <h3 class="text-3xl font-display text-white mb-3">Well Maintained Greens and Fairways</h3>
                        <p class="text-gray-200 mb-4">Constantly working to provide the best course conditions possible.</p>
                        <a href="{{ route('about') }}" class="inline-flex items-center text-white hover:text-emerald-400 transition font-semibold">
                            Learn More <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1592919505780-303950717480?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                     alt="Practice Facilities" 
                     class="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent flex items-end">
                    <div class="p-8 w-full">
                        <h3 class="text-3xl font-display text-white mb-3">Practice Facilities</h3>
                        <p class="text-gray-200 mb-4">Complete practice range with targets, putting green, and short game area to perfect every shot.</p>
                        <a href="{{ route('facilities') }}" class="inline-flex items-center text-white hover:text-emerald-400 transition font-semibold">
                            View Facilities <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                     alt="Tournament Events" 
                     class="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent flex items-end">
                    <div class="p-8 w-full">
                        <h3 class="text-3xl font-display text-white mb-3">Tournament Events</h3>
                        <p class="text-gray-200 mb-4">Host and participate in competitive tournaments with our advanced digital scoring system.</p>
                        <a href="{{ route('tournaments.index') }}" class="inline-flex items-center text-white hover:text-emerald-400 transition font-semibold">
                            View Events <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1593111774240-d529f12cf4bb?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                     alt="Tournament Events" 
                     class="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent flex items-end">
                    <div class="p-8 w-full">
                        <h3 class="text-3xl font-display text-white mb-3">Golf Instruction</h3>
                        <p class="text-gray-200 mb-4">Lessons and clinics for golfers of all ages and skill levels.</p>
                        <a href="{{ route('instruction') }}" class="inline-flex items-center text-white hover:text-emerald-400 transition font-semibold">
                            Book Lessons <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Tournaments Section -->
@if(isset($upcomingTournaments) && $upcomingTournaments->count() > 0)
<section class="py-20 sm:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl sm:text-5xl font-display mb-6">Upcoming Tournaments</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Join us for exciting competitive events throughout the season
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($upcomingTournaments as $tournament)
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="h-48 bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center">
                    <i class="fas fa-trophy text-6xl text-white opacity-80"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-display mb-4">{{ $tournament->name }}</h3>
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-calendar w-6"></i>
                            <span>{{ \Carbon\Carbon::parse($tournament->start_date)->format('F j, Y') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-golf-ball w-6"></i>
                            <span>{{ $tournament->format ?? 'Stroke Play' }}</span>
                        </div>
                    </div>
                    <a href="{{ route('tournaments.show', $tournament) }}" class="block w-full text-center px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-semibold">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('tournaments.index') }}" class="inline-flex items-center px-10 py-4 bg-gray-900 text-white rounded-lg font-semibold hover:bg-gray-800 transition-all duration-300">
                View All Tournaments
                <i class="fas fa-arrow-right ml-3"></i>
            </a>
        </div>
    </div>
</section>
@endif

@endsection
