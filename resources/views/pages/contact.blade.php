@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 py-20">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?auto=format&fit=crop&q=80&w=2000" 
             alt="Contact Us" 
             class="w-full h-full object-cover opacity-40">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl sm:text-6xl font-display text-white mb-6">Contact Us</h1>
        <p class="text-xl text-gray-200 max-w-3xl mx-auto">
            Get in touch with Smith Center Golf Course
        </p>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="text-3xl font-display mb-6">Send Us a Message</h2>
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                        <input type="text" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 
                               id="name" 
                               name="name"
                               value="{{ old('name') }}" 
                               required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 
                               id="email" 
                               name="email"
                               value="{{ old('email') }}" 
                               required>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone (Optional)</label>
                        <input type="tel" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 
                               id="phone" 
                               name="phone"
                               value="{{ old('phone') }}">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 
                                id="subject" 
                                name="subject" 
                                required>
                            <option value="">Select a subject</option>
                            <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="Golf Instruction" {{ old('subject') == 'Golf Instruction' ? 'selected' : '' }}>Golf Instruction</option>
                            <option value="Tournament Information" {{ old('subject') == 'Tournament Information' ? 'selected' : '' }}>Tournament Information</option>
                            <option value="League Information" {{ old('subject') == 'League Information' ? 'selected' : '' }}>League Information</option>
                            <option value="Membership" {{ old('subject') == 'Membership' ? 'selected' : '' }}>Membership</option>
                            <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 
                                  id="message" 
                                  name="message" 
                                  rows="6" 
                                  required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="w-full px-8 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition text-lg">
                        <i class="fas fa-paper-plane mr-2"></i>Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-6">
                <!-- Membership Info -->
                <div class="bg-emerald-600 text-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-start mb-4">
                        <i class="fas fa-info-circle text-3xl mr-4"></i>
                        <div>
                            <h3 class="text-xl font-display mb-3">Interested in Becoming a Member?</h3>
                            <p class="text-emerald-100 mb-4">
                                Check out our membership and payment options included on the <a href="{{ route('rates') }}" class="underline hover:text-white font-semibold">Rates page</a>.
                            </p>
                            <p class="text-emerald-100 text-sm">
                                If you are unable to view the membership options and tournament schedules, please contact the city offices at <a href="tel:785-282-3812" class="underline hover:text-white font-semibold">(785) 282-3812</a>.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-start mb-4">
                        <i class="fas fa-map-marker-alt text-3xl text-emerald-600 mr-4"></i>
                        <div>
                            <h3 class="text-xl font-display mb-2">Address</h3>
                            <p class="text-gray-600">20082 US-281</p>
                            <p class="text-gray-600">Smith Center, KS 66967</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-start mb-4">
                        <i class="fas fa-phone text-3xl text-emerald-600 mr-4"></i>
                        <div>
                            <h3 class="text-xl font-display mb-2">Phone</h3>
                            <p class="text-gray-600">City Offices: <a href="tel:785-282-3812" class="text-emerald-600 hover:text-emerald-700 font-semibold">(785) 282-3812</a></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-start mb-4">
                        <i class="fas fa-envelope text-3xl text-emerald-600 mr-4"></i>
                        <div>
                            <h3 class="text-xl font-display mb-2">Email</h3>
                            <p class="text-gray-600"><a href="mailto:smithcentergolfcourse@gmail.com" class="text-emerald-600 hover:text-emerald-700">smithcentergolfcourse@gmail.com</a></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-start mb-4">
                        <i class="fas fa-clock text-3xl text-emerald-600 mr-4"></i>
                        <div>
                            <h3 class="text-xl font-display mb-2">Hours</h3>
                            <p class="text-gray-600">Sunrise to Sunset</p>
                            <p class="text-sm text-gray-500 mt-2">(Weather permitting)</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-xl font-display mb-4">Find Us</h3>
                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3040.5469982891943!2d-98.78333492414948!3d39.78040857944613!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87a3c5e6f7c8f8f7%3A0x1234567890abcdef!2sSmith%20Center%2C%20KS%2066967!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus" 
                                width="100%" 
                                height="300" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                class="rounded-lg"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
