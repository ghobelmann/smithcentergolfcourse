@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 py-20">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?auto=format&fit=crop&q=80&w=2000" 
             alt="Golf Course" 
             class="w-full h-full object-cover opacity-40">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl sm:text-6xl font-display text-white mb-6">Golf Leagues</h1>
        <p class="text-xl text-gray-200 max-w-3xl mx-auto">
            Join our competitive and social golf leagues for friendly competition throughout the season
        </p>
    </div>
</section>

<!-- Leagues Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Men's League Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-200 hover:border-emerald-600 transition">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-3xl font-display text-white">Men's League</h2>
                        <i class="fas fa-male text-4xl text-white opacity-75"></i>
                    </div>
                    <p class="text-blue-100">Competitive weekly play for men of all skill levels</p>
                </div>
                
                <div class="p-8">
                    <div class="space-y-6">
                        <!-- Schedule -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-calendar-alt text-emerald-600 mr-3"></i>
                                Schedule
                            </h3>
                            <div class="text-gray-700 space-y-2 ml-9">
                                <p><span class="font-semibold">Day:</span> Wednesday Evenings</p>
                                <p><span class="font-semibold">Time:</span> 6:00 PM Tee Time</p>
                                <p><span class="font-semibold">Season:</span> May through August</p>
                            </div>
                        </div>

                        <!-- Format -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-trophy text-emerald-600 mr-3"></i>
                                Format
                            </h3>
                            <div class="text-gray-700 space-y-2 ml-9">
                                <p>9 Holes Weekly</p>
                                <p>2 Man Teams - Four Ball</p>
                                <p>Handicap System Used</p>
                            </div>
                        </div>

                        <!-- Fees -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-dollar-sign text-emerald-600 mr-3"></i>
                                Fees
                            </h3>
                            <div class="text-gray-700 space-y-2 ml-9">
                                <p><span class="font-semibold">Registration:</span> $50 per season</p>
                                <p><span class="font-semibold">Pin Prizes:</span> $20</p>
                            </div>
                        </div>

                        <!-- Benefits -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-star text-emerald-600 mr-3"></i>
                                What's Included
                            </h3>
                            <ul class="text-gray-700 space-y-2 ml-9 list-disc">
                                <li>Weekly prizes</li>
                                <li>Season-long competition</li>
                                <li>End-of-season tournament</li>
                                <li>Social events & gatherings</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('contact') }}" class="block w-full text-center px-8 py-4 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition text-lg">
                            <i class="fas fa-user-plus mr-2"></i>Join Men's League
                        </a>
                    </div>
                </div>
            </div>

            <!-- Women's League Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-200 hover:border-emerald-600 transition">
                <div class="bg-gradient-to-r from-pink-600 to-pink-700 p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-3xl font-display text-white">Women's League</h2>
                        <i class="fas fa-female text-4xl text-white opacity-75"></i>
                    </div>
                    <p class="text-pink-100">Fun and friendly golf for women golfers</p>
                </div>
                
                <div class="p-8">
                    <div class="space-y-6">
                        <!-- Schedule -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-calendar-alt text-emerald-600 mr-3"></i>
                                Schedule
                            </h3>
                            <div class="text-gray-700 space-y-2 ml-9">
                                <p><span class="font-semibold">Day:</span> Tuesday Evenings</p>
                                <p><span class="font-semibold">Time:</span> 6:00 PM Tee Time</p>
                                <p><span class="font-semibold">Season:</span> May through August</p>
                            </div>
                        </div>

                        <!-- Format -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-trophy text-emerald-600 mr-3"></i>
                                Format
                            </h3>
                            <div class="text-gray-700 space-y-2 ml-9">
                                <p>9 Holes Weekly</p>
                                <p>Various Formats (Scramble, Best Ball, etc.)</p>
                                <p>All Skill Levels Welcome</p>
                            </div>
                        </div>

                        <!-- Fees -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-dollar-sign text-emerald-600 mr-3"></i>
                                Fees
                            </h3>
                            <div class="text-gray-700 space-y-2 ml-9">
                                <p><span class="font-semibold">Registration:</span> TBD</p>
                            </div>
                        </div>

                        <!-- Benefits -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-star text-emerald-600 mr-3"></i>
                                What's Included
                            </h3>
                            <ul class="text-gray-700 space-y-2 ml-9 list-disc">
                                <li>Weekly prizes & games</li>
                                <li>Social atmosphere</li>
                                <li>End-of-season celebration</li>
                                <li>Lunch & social events</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('contact') }}" class="block w-full text-center px-8 py-4 bg-pink-600 text-white rounded-lg font-semibold hover:bg-pink-700 transition text-lg">
                            <i class="fas fa-user-plus mr-2"></i>Join Women's League
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Additional Info Section -->
        <div class="mt-16 bg-emerald-50 rounded-2xl p-8 md:p-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-display text-gray-900 mb-4">Ready to Join?</h2>
                <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                    Both leagues offer a great way to improve your game, meet new people, and enjoy competitive golf in a friendly environment.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-white rounded-xl shadow">
                    <i class="fas fa-users text-4xl text-emerald-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Community</h3>
                    <p class="text-gray-600">Meet fellow golfers and build lasting friendships</p>
                </div>
                
                <div class="text-center p-6 bg-white rounded-xl shadow">
                    <i class="fas fa-chart-line text-4xl text-emerald-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Improve Your Game</h3>
                    <p class="text-gray-600">Regular play helps develop your skills</p>
                </div>
                
                <div class="text-center p-6 bg-white rounded-xl shadow">
                    <i class="fas fa-award text-4xl text-emerald-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Win Prizes</h3>
                    <p class="text-gray-600">Weekly and season-long prizes available</p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('contact') }}" class="inline-block px-10 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition text-lg">
                    <i class="fas fa-envelope mr-2"></i>Contact Us for More Info
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
