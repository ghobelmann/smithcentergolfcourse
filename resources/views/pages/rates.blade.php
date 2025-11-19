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
                            <span class="text-gray-700">18 Holes</span>
                            <span class="text-2xl font-bold text-emerald-600">$20</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-700">9 Holes</span>
                            <span class="text-2xl font-bold text-emerald-600">$10</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weekend & Holiday Rates -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-yellow-500 text-gray-900 p-6">
                    <h3 class="text-2xl font-display flex items-center">
                        <i class="fas fa-calendar-week mr-3"></i>Weekend & Holiday Rates
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">18 Holes</span>
                            <span class="text-2xl font-bold text-yellow-600">$30</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-700">9 Holes</span>
                            <span class="text-2xl font-bold text-yellow-600">$20</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Season Memberships -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-blue-600 text-white p-6">
                    <h3 class="text-2xl font-display flex items-center">
                        <i class="fas fa-id-card mr-3"></i>Season Memberships
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4 mb-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Individual First Time Membership</span>
                            <span class="text-2xl font-bold text-blue-600">$150</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Individual Membership</span>
                            <span class="text-2xl font-bold text-blue-600">$400</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Student Membership <span class="text-sm text-gray-500">(up to and including age 23)</span></span>
                            <span class="text-2xl font-bold text-blue-600">$150</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Family First Time Membership</span>
                            <span class="text-2xl font-bold text-blue-600">$200</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-700">Family Membership</span>
                            <span class="text-2xl font-bold text-blue-600">$475</span>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 bg-blue-50 p-4 rounded-lg space-y-2">
                        <p class="font-semibold text-blue-900">Payment Plan Available:</p>
                        <p>Pay in installments: $50 by March 15th, $50 by May 15th, $50 by July 15th (for $150 memberships). Other amounts vary by membership type.</p>
                    </div>
                </div>
            </div>

            <!-- Cart & Range Services -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gray-600 text-white p-6">
                    <h3 class="text-2xl font-display flex items-center">
                        <i class="fas fa-golf-ball mr-3"></i>Cart & Range Services
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Rental Cart (per round)</span>
                            <span class="text-2xl font-bold text-gray-600">$20</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Unlimited Annual Cart Rental</span>
                            <span class="text-2xl font-bold text-gray-600">$450</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Cart Shed Rental</span>
                            <span class="text-2xl font-bold text-gray-600">$140</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-700">Range Ball Member</span>
                            <span class="text-2xl font-bold text-gray-600">$50</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 bg-gray-50 p-4 rounded-lg mt-4">
                        Discount ticket books are available for purchase at the City Office. Ticket books are $100 for 10 tickets. Each ticket can be used for daily greens fees or cart rental.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Group Rates Section -->
<section class="py-20 bg-gray-50">
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gray-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-display mb-6">Ready to Play?</h2>
        <p class="text-xl text-gray-300 mb-10">
            Visit us today and experience our course
        </p>
        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-all duration-300 text-lg">
            <i class="fas fa-phone mr-3"></i>Contact Us
        </a>
    </div>
</section>
@endsection
