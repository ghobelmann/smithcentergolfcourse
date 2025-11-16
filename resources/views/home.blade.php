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
            <a href="{{ route('tee-times') }}" class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-all duration-300 text-lg">
                Book Tee Time
            </a>
            <a href="{{ route('rates') }}" class="inline-flex items-center justify-center px-10 py-4 bg-white text-gray-900 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 text-lg">
                View Rates
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Section -->
<section class="py-20 sm:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl sm:text-5xl font-display mb-6">Why Choose Smith Center Golf Course?</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                We're not just a golf course - we're a community dedicated to providing an exceptional golfing experience
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="text-center">
                <div class="w-20 h-20 mx-auto mb-6 bg-emerald-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-flag text-4xl text-emerald-600"></i>
                </div>
                <h3 class="text-2xl font-display mb-4">Championship Course</h3>
                <p class="text-gray-600 leading-relaxed">
                    Professionally designed 18-hole course with well-maintained greens and challenging fairways for all skill levels
                </p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 mx-auto mb-6 bg-emerald-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-users text-4xl text-emerald-600"></i>
                </div>
                <h3 class="text-2xl font-display mb-4">Expert Instruction</h3>
                <p class="text-gray-600 leading-relaxed">
                    Professional instructors who create personalized lesson plans and provide ongoing support for improvement
                </p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 mx-auto mb-6 bg-emerald-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-trophy text-4xl text-emerald-600"></i>
                </div>
                <h3 class="text-2xl font-display mb-4">Tournament Ready</h3>
                <p class="text-gray-600 leading-relaxed">
                    State-of-the-art tournament hosting and scoring system with a community that celebrates every achievement
                </p>
            </div>
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
                <img src="https://images.unsplash.com/photo-1535131749006-b7f58c99034b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                     alt="Championship Greens" 
                     class="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent flex items-end">
                    <div class="p-8 w-full">
                        <h3 class="text-3xl font-display text-white mb-3">Championship Greens</h3>
                        <p class="text-gray-200 mb-4">Meticulously maintained putting surfaces that provide true roll and consistent speed throughout the season.</p>
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
                        <p class="text-gray-200 mb-4">Complete practice range with target greens, putting green, and short game area to perfect every shot.</p>
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
                <img src="https://images.unsplash.com/photo-1530028828-25e8270e5afd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                     alt="Golf Instruction" 
                     class="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent flex items-end">
                    <div class="p-8 w-full">
                        <h3 class="text-3xl font-display text-white mb-3">Golf Instruction</h3>
                        <p class="text-gray-200 mb-4">Professional lessons and clinics for golfers of all ages and skill levels.</p>
                        <a href="{{ route('instruction') }}" class="inline-flex items-center text-white hover:text-emerald-400 transition font-semibold">
                            Book Lessons <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 bg-emerald-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-5xl sm:text-6xl font-display mb-2">18</div>
                <div class="text-emerald-100 text-lg">Championship Holes</div>
            </div>
            <div class="text-center">
                <div class="text-5xl sm:text-6xl font-display mb-2">1,000+</div>
                <div class="text-emerald-100 text-lg">Active Members</div>
            </div>
            <div class="text-center">
                <div class="text-5xl sm:text-6xl font-display mb-2">20+</div>
                <div class="text-emerald-100 text-lg">Tournaments Yearly</div>
            </div>
            <div class="text-center">
                <div class="text-5xl sm:text-6xl font-display mb-2">Year-Round</div>
                <div class="text-emerald-100 text-lg">Open Daily</div>
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

<!-- CTA Section -->
<section class="py-20 sm:py-24 bg-gray-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl sm:text-5xl font-display mb-6">Ready to Play?</h2>
        <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
            Book your tee time today and experience one of Kansas' premier golf courses
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('tee-times') }}" class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-all duration-300 text-lg">
                Book Tee Time
            </a>
            <a href="tel:555-123-4567" class="inline-flex items-center justify-center px-10 py-4 bg-white text-gray-900 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 text-lg">
                Call Us: (555) 123-4567
            </a>
        </div>
    </div>
</section>
@endsection
