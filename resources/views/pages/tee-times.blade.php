@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 py-20">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80" 
             alt="Golf Course" 
             class="w-full h-full object-cover opacity-30">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl sm:text-6xl font-display text-white mb-6">Book a Tee Time</h1>
        <p class="text-xl text-gray-200 max-w-3xl mx-auto">
            Reserve your spot on our championship course
        </p>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-3xl font-display mb-6">Reserve Your Spot</h2>
                    <p class="text-gray-600 mb-8">
                        Book your tee time online or call us directly. We recommend booking at least 24 hours in advance.
                    </p>
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Date</label>
                                <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Time</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                                    <option value="">Select a time</option>
                                    <option>7:00 AM</option>
                                    <option>8:00 AM</option>
                                    <option>9:00 AM</option>
                                    <option>10:00 AM</option>
                                    <option>11:00 AM</option>
                                    <option>12:00 PM</option>
                                    <option>1:00 PM</option>
                                    <option>2:00 PM</option>
                                    <option>3:00 PM</option>
                                    <option>4:00 PM</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Players</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                                    <option value="">Select number</option>
                                    <option>1 Player</option>
                                    <option>2 Players</option>
                                    <option>3 Players</option>
                                    <option>4 Players</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Holes</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                                    <option value="">Select holes</option>
                                    <option>9 Holes</option>
                                    <option>18 Holes</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" class="w-5 h-5 text-emerald-600">
                            <label class="ml-3 text-gray-700">Include Golf Cart</label>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone</label>
                                <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                        </div>
                        <button type="submit" class="w-full px-8 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                            Request Tee Time
                        </button>
                    </form>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-emerald-600 text-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-display mb-4">Call to Book</h3>
                    <p class="text-3xl font-bold text-center">(785) 282-3812</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-blue-600 text-white p-4">
                        <h3 class="text-xl font-display">Hours</h3>
                    </div>
                    <div class="p-6 text-gray-600">
                        <p class="text-lg">Sunrise to Sunset</p>
                        <p class="text-sm text-gray-500 mt-2">(Weather permitting)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
