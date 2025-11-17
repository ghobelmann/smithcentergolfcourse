@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 py-20">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80" 
             alt="Contact Us" 
             class="w-full h-full object-cover opacity-30">
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
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">First Name</label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 
                                   id="first_name" 
                                   name="first_name" 
                                   required>
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">Last Name</label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 
                                   id="last_name" 
                                   name="last_name" 
                                   required>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 
                               id="email" 
                               name="email" 
                               required>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone</label>
                        <input type="tel" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 
                               id="phone" 
                               name="phone">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 
                                id="subject" 
                                name="subject" 
                                required>
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="tee-time">Tee Time</option>
                            <option value="instruction">Golf Instruction</option>
                            <option value="tournament">Tournament</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 
                                  id="message" 
                                  name="message" 
                                  rows="6" 
                                  required></textarea>
                    </div>

                    <button type="submit" class="w-full px-8 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition text-lg">
                        <i class="fas fa-paper-plane mr-2"></i>Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-6">
                <div class="bg-emerald-600 text-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-start mb-4">
                        <i class="fas fa-map-marker-alt text-3xl mr-4"></i>
                        <div>
                            <h3 class="text-xl font-display mb-2">Address</h3>
                            <p class="text-emerald-100">123 Golf Course Road</p>
                            <p class="text-emerald-100">Smith Center, KS 66967</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-start mb-4">
                        <i class="fas fa-phone text-3xl text-emerald-600 mr-4"></i>
                        <div>
                            <h3 class="text-xl font-display mb-2">Phone</h3>
                            <p class="text-gray-600">(555) 123-4567</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-start mb-4">
                        <i class="fas fa-envelope text-3xl text-emerald-600 mr-4"></i>
                        <div>
                            <h3 class="text-xl font-display mb-2">Email</h3>
                            <p class="text-gray-600">info@smithcentergolf.com</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-start mb-4">
                        <i class="fas fa-clock text-3xl text-emerald-600 mr-4"></i>
                        <div>
                            <h3 class="text-xl font-display mb-2">Hours</h3>
                            <p class="text-gray-600 mb-2"><strong>Spring-Fall:</strong></p>
                            <p class="text-gray-600 mb-3">7:00 AM - 6:00 PM Daily</p>
                            <p class="text-gray-600 mb-2"><strong>Winter:</strong></p>
                            <p class="text-gray-600">8:00 AM - 5:00 PM Daily</p>
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
