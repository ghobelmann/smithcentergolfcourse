@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 py-20">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?auto=format&fit=crop&q=80&w=2000" 
             alt="Golf Instruction" 
             class="w-full h-full object-cover opacity-40">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl sm:text-6xl font-display text-white mb-6">Golf Instruction</h1>
        <p class="text-xl text-gray-200 max-w-3xl mx-auto">
            Professional lessons for golfers of all skill levels
        </p>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-display mb-6">Improve Your Game</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Our PGA-certified instructors offer personalized lessons designed to help you reach your golfing goals.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-emerald-600 text-white p-6">
                    <h3 class="text-2xl font-display">Private Lessons</h3>
                </div>
                <div class="p-8">
                    <p class="text-gray-600 mb-6">One-on-one instruction tailored to your specific needs and goals.</p>
                    <ul class="space-y-3 mb-6 text-gray-600">
                        <li class="flex items-start">
                            <span class="text-emerald-600 mr-2">✓</span>
                            <span>Personalized attention</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-600 mr-2">✓</span>
                            <span>Video analysis</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-600 mr-2">✓</span>
                            <span>Custom practice plan</span>
                        </li>
                    </ul>
                    <p class="text-3xl font-bold text-gray-900 mb-2">$75</p>
                    <p class="text-gray-600 mb-6">per hour</p>
                    <a href="#" class="block w-full text-center px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                        Book Now
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-blue-600 text-white p-6">
                    <h3 class="text-2xl font-display">Group Lessons</h3>
                </div>
                <div class="p-8">
                    <p class="text-gray-600 mb-6">Learn with friends in a fun, social environment with groups of 4-6 players.</p>
                    <ul class="space-y-3 mb-6 text-gray-600">
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2">✓</span>
                            <span>Social learning</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2">✓</span>
                            <span>Group drills</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2">✓</span>
                            <span>Cost effective</span>
                        </li>
                    </ul>
                    <p class="text-3xl font-bold text-gray-900 mb-2">$40</p>
                    <p class="text-gray-600 mb-6">per person</p>
                    <a href="#" class="block w-full text-center px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                        Book Now
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-purple-600 text-white p-6">
                    <h3 class="text-2xl font-display">Junior Lessons</h3>
                </div>
                <div class="p-8">
                    <p class="text-gray-600 mb-6">Fun, engaging lessons for young golfers ages 8-17 to build skills and confidence.</p>
                    <ul class="space-y-3 mb-6 text-gray-600">
                        <li class="flex items-start">
                            <span class="text-purple-600 mr-2">✓</span>
                            <span>Age-appropriate</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-purple-600 mr-2">✓</span>
                            <span>Fun activities</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-purple-600 mr-2">✓</span>
                            <span>Character building</span>
                        </li>
                    </ul>
                    <p class="text-3xl font-bold text-gray-900 mb-2">$50</p>
                    <p class="text-gray-600 mb-6">per hour</p>
                    <a href="#" class="block w-full text-center px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
