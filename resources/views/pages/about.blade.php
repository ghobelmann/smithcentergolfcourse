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
        <h1 class="text-5xl sm:text-6xl font-display text-white mb-6">About Smith Center Golf Course</h1>
        <p class="text-xl text-gray-200 max-w-3xl mx-auto">
            A premier golfing destination serving the community for decades
        </p>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="flex justify-center items-center">
                <img src="{{ asset('SC-Map.png') }}" 
                     alt="Smith Center Municipal Golf Course Map" 
                     class="w-full rounded-2xl shadow-2xl">
            </div>
            <div>
                <h2 class="text-4xl font-display mb-6">About Our Course</h2>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    The Smith Center Municipal Golf Course is located 4.3 miles south of town along highway 281. This course is a beautifully maintained course with a driving range and practice green. Open from sunrise to sunset to accommodate everyone. Take a break between rounds at our clubhouse where you will find restrooms, a television, recent news, schedules, and more!
                </p>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Greens fees are $10/weekday for 9 holes; $20/weekday for 18 holes; or weekend and holiday rates of $20 for 9 holes and $30 for 18 holes. Rental golf carts are $20 per use. Discounted ticket books are available for purchase at the city office. Ticket books are $100 for 10 tickets. Ticket books also make a great gift!
                </p>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Debit/Credit cards are accepted (self-service) at the clubhouse for daily greens fees and rental carts; cash and check payments continue to be accepted as well, utilizing the pay envelopes and drop box at the clubhouse.
                </p>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Several tournaments are held throughout the season and will be posted each Spring. Additional information can also be found on the <a href="https://www.facebook.com/smithcentergolf/?checkpoint_src=any" target="_blank" rel="noopener noreferrer" class="text-emerald-600 hover:text-emerald-700 font-semibold">Facebook page</a>.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Interested in becoming a member? Check out our membership and payment options on included on this page. If you are unable to view the membership options and tournament schedules, please contact the city offices at <a href="tel:785-282-3812" class="text-emerald-600 hover:text-emerald-700 font-semibold">(785) 282-3812</a>.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Course Details Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-display text-center mb-12">Course Details</h2>
        <div class="bg-gray-50 rounded-2xl overflow-hidden shadow-lg">
            <div class="divide-y divide-gray-200">
                <div class="grid grid-cols-2 p-6 hover:bg-gray-100 transition">
                    <div class="font-semibold text-gray-900">Total Yardage</div>
                    <div class="text-gray-600">6,500 yards (Championship Tees)</div>
                </div>
                <div class="grid grid-cols-2 p-6 hover:bg-gray-100 transition">
                    <div class="font-semibold text-gray-900">Par</div>
                    <div class="text-gray-600">72</div>
                </div>
                <div class="grid grid-cols-2 p-6 hover:bg-gray-100 transition">
                    <div class="font-semibold text-gray-900">Course Rating</div>
                    <div class="text-gray-600">71.5</div>
                </div>
                <div class="grid grid-cols-2 p-6 hover:bg-gray-100 transition">
                    <div class="font-semibold text-gray-900">Slope Rating</div>
                    <div class="text-gray-600">128</div>
                </div>
                <div class="grid grid-cols-2 p-6 hover:bg-gray-100 transition">
                    <div class="font-semibold text-gray-900">Grass Type</div>
                    <div class="text-gray-600">Bent Grass Greens, Bluegrass Fairways</div>
                </div>
            </div>
        </div>

        <!-- Scorecards Section -->
        <div class="mt-16">
            <h3 class="text-3xl font-display text-center mb-8">Scorecards</h3>
            <div class="space-y-8">
                <div class="text-center">
                    <h4 class="text-xl font-semibold text-gray-900 mb-4">Red Tees</h4>
                    <img src="{{ asset('sc_red.png') }}" 
                         alt="Smith Center Golf Course - Red Tees Scorecard" 
                         class="w-full max-w-4xl mx-auto rounded-xl shadow-lg">
                </div>
                
                <div class="text-center">
                    <h4 class="text-xl font-semibold text-gray-900 mb-4">White Tees</h4>
                    <img src="{{ asset('sc_white.png') }}" 
                         alt="Smith Center Golf Course - White Tees Scorecard" 
                         class="w-full max-w-4xl mx-auto rounded-xl shadow-lg">
                </div>
                
                <div class="text-center">
                    <h4 class="text-xl font-semibold text-gray-900 mb-4">Blue Tees</h4>
                    <img src="{{ asset('sc_blue.png') }}" 
                         alt="Smith Center Golf Course - Blue Tees Scorecard" 
                         class="w-full max-w-4xl mx-auto rounded-xl shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gray-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-display mb-6">Ready to Experience Our Course?</h2>
        <p class="text-xl text-gray-300 mb-10">
            Join us for an unforgettable round of golf
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('tournaments.index') }}" class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-all duration-300 text-lg">
                View Tournaments
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-10 py-4 bg-white text-gray-900 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 text-lg">
                Contact Us
            </a>
        </div>
    </div>
</section>
@endsection
