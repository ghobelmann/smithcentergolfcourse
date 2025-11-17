@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 py-20">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1535131749006-b7f58c99034b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80" 
             alt="Golf Course" 
             class="w-full h-full object-cover opacity-30">
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
            <div>
                <img src="https://images.unsplash.com/photo-1535131749006-b7f58c99034b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                     alt="Golf Course" 
                     class="w-full rounded-2xl shadow-2xl">
            </div>
            <div>
                <h2 class="text-4xl font-display mb-6">Our Story</h2>
                <p class="text-xl text-gray-600 mb-6 leading-relaxed">
                    Welcome to Smith Center Golf Course, a premier golfing destination that has been serving the community for decades.
                </p>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Our 18-hole championship course offers a challenging yet enjoyable experience for golfers of all skill levels. 
                    Nestled in the heart of Kansas, our course features well-maintained greens, strategic bunkers, and beautiful natural landscapes.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Whether you're a seasoned pro or just starting out, our friendly staff and excellent facilities ensure 
                    an unforgettable golfing experience every time you visit.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Course Features Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl sm:text-5xl font-display text-center mb-16">Course Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition">
                <div class="w-20 h-20 mx-auto mb-6 bg-emerald-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-flag text-4xl text-emerald-600"></i>
                </div>
                <h3 class="text-xl font-display mb-3">18 Holes</h3>
                <p class="text-gray-600">Championship course with varying difficulty</p>
            </div>

            <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition">
                <div class="w-20 h-20 mx-auto mb-6 bg-emerald-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-golf-ball text-4xl text-emerald-600"></i>
                </div>
                <h3 class="text-xl font-display mb-3">Practice Facilities</h3>
                <p class="text-gray-600">Driving range and putting greens</p>
            </div>

            <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition">
                <div class="w-20 h-20 mx-auto mb-6 bg-emerald-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-store text-4xl text-emerald-600"></i>
                </div>
                <h3 class="text-xl font-display mb-3">Pro Shop</h3>
                <p class="text-gray-600">Full-service shop with equipment and apparel</p>
            </div>

            <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition">
                <div class="w-20 h-20 mx-auto mb-6 bg-emerald-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-utensils text-4xl text-emerald-600"></i>
                </div>
                <h3 class="text-xl font-display mb-3">Clubhouse</h3>
                <p class="text-gray-600">Snacks and beverages available</p>
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
            <a href="{{ route('tee-times') }}" class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-all duration-300 text-lg">
                Book a Tee Time
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-10 py-4 bg-white text-gray-900 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 text-lg">
                Contact Us
            </a>
        </div>
    </div>
</section>
@endsection
