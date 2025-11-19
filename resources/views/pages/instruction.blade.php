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
                Professional golf instruction is available at Smith Center Golf Course. Contact us for more information about lessons and pricing.
            </p>
        </div>

        <!-- Contact CTA -->
        <div class="bg-gradient-to-br from-emerald-50 to-blue-50 rounded-2xl p-8 md:p-12 text-center">
            <i class="fas fa-golf-ball text-5xl text-emerald-600 mb-6"></i>
            <h3 class="text-3xl font-display text-gray-900 mb-4">Interested in Golf Lessons?</h3>
            <p class="text-lg text-gray-700 mb-8 max-w-2xl mx-auto">
                We offer personalized instruction for players of all skill levels. Get in touch to discuss your goals and schedule a lesson.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:785-282-3812" class="inline-flex items-center justify-center px-8 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition text-lg">
                    <i class="fas fa-phone mr-3"></i>Call (785) 282-3812
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-emerald-700 border-2 border-emerald-600 rounded-lg font-semibold hover:bg-emerald-50 transition text-lg">
                    <i class="fas fa-envelope mr-3"></i>Contact Us
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
