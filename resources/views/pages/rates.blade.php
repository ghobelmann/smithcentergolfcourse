@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 py-20">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1592919505780-303950717480?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80" 
             alt="Golf Course" 
             class="w-full h-full object-cover opacity-30">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl sm:text-6xl font-display text-white mb-6">Rates & Fees</h1>
        <p class="text-xl text-gray-200 max-w-3xl mx-auto">
            Affordable pricing for every golfer
        </p>
    </div>
</section>

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-emerald-50 border-l-4 border-emerald-600 p-6 rounded-lg mb-12">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-emerald-600 text-2xl mr-4 mt-1"></i>
                <p class="text-gray-700">
                    All rates subject to change. Please call ahead for current pricing and availability.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Weekday Rates -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-emerald-600 text-white p-6">
                    <h3 class="text-2xl font-display flex items-center">
                        <i class="fas fa-sun mr-3"></i>Weekday Rates
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">18 Holes with Cart</span>
                            <span class="text-2xl font-bold text-emerald-600">$40</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">18 Holes Walking</span>
                            <span class="text-2xl font-bold text-emerald-600">$25</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">9 Holes with Cart</span>
                            <span class="text-2xl font-bold text-emerald-600">$25</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-700">9 Holes Walking</span>
                            <span class="text-2xl font-bold text-emerald-600">$15</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weekend Rates -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-yellow-500 text-gray-900 p-6">
                    <h3 class="text-2xl font-display flex items-center">
                        <i class="fas fa-calendar-week mr-3"></i>Weekend Rates
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">18 Holes with Cart</span>
                            <span class="text-2xl font-bold text-yellow-600">$50</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">18 Holes Walking</span>
                            <span class="text-2xl font-bold text-yellow-600">$35</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">9 Holes with Cart</span>
                            <span class="text-2xl font-bold text-yellow-600">$30</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-700">9 Holes Walking</span>
                            <span class="text-2xl font-bold text-yellow-600">$20</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Season Passes -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-blue-600 text-white p-6">
                    <h3 class="text-2xl font-display flex items-center">
                        <i class="fas fa-id-card mr-3"></i>Season Passes
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4 mb-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Individual Annual Pass</span>
                            <span class="text-2xl font-bold text-blue-600">$800</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Senior Annual Pass (62+)</span>
                            <span class="text-2xl font-bold text-blue-600">$650</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Junior Annual Pass (Under 18)</span>
                            <span class="text-2xl font-bold text-blue-600">$400</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-700">Family Annual Pass</span>
                            <span class="text-2xl font-bold text-blue-600">$1,500</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 bg-gray-50 p-4 rounded-lg">
                        Season passes include unlimited golf and cart usage for the entire season (April - October)
                    </p>
                </div>
            </div>

            <!-- Additional Services -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gray-600 text-white p-6">
                    <h3 class="text-2xl font-display flex items-center">
                        <i class="fas fa-golf-ball mr-3"></i>Additional Services
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Cart Rental (9 holes)</span>
                            <span class="text-2xl font-bold text-gray-600">$10</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Cart Rental (18 holes)</span>
                            <span class="text-2xl font-bold text-gray-600">$15</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Club Rental</span>
                            <span class="text-2xl font-bold text-gray-600">$20</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Range Balls (small bucket)</span>
                            <span class="text-2xl font-bold text-gray-600">$5</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-700">Range Balls (large bucket)</span>
                            <span class="text-2xl font-bold text-gray-600">$8</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Group Rates Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
            <div class="flex items-start mb-6">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mr-6 flex-shrink-0">
                    <i class="fas fa-users text-3xl text-emerald-600"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-display mb-4">Group & Tournament Rates</h2>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        We offer special rates for groups of 12 or more and tournament hosting. 
                        Our facility can accommodate tournaments of various sizes with our comprehensive scoring system.
                    </p>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Contact us for custom pricing and availability for your group or tournament needs.
                    </p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                        Contact for Group Rates
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gray-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-display mb-6">Ready to Play?</h2>
        <p class="text-xl text-gray-300 mb-10">
            Book your tee time today and experience our course
        </p>
        <a href="{{ route('tee-times') }}" class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-all duration-300 text-lg">
            <i class="fas fa-calendar-check mr-3"></i>Book Your Tee Time
        </a>
    </div>
</section>
@endsection
