@extends('layouts.app')@extends('layouts.app')



@section('content')@section('content')

<!-- Hero Section --><div class="container my-5">

<section class="relative bg-gray-900 py-20">    <h1 class="mb-4">Contact Us</h1>

    <div class="absolute inset-0">    

        <img src="https://images.unsplash.com/photo-1535131749006-b7f58c99034b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80"     <div class="row mb-5">

             alt="Golf Course"         <div class="col-md-6">

             class="w-full h-full object-cover opacity-30">            <div class="card mb-4">

    </div>                <div class="card-header bg-success text-white">

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">                    <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Course Information</h4>

        <h1 class="text-5xl sm:text-6xl font-display text-white mb-6">Contact Us</h1>                </div>

        <p class="text-xl text-gray-200 max-w-3xl mx-auto">                <div class="card-body">

            Get in touch with Smith Center Golf Course                    <p class="mb-3">

        </p>                        <strong><i class="fas fa-map-marker-alt text-success me-2"></i>Address:</strong><br>

    </div>                        123 Golf Course Road<br>

</section>                        Smith Center, KS 66967

                    </p>

<section class="py-20 bg-white">                    <p class="mb-3">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">                        <strong><i class="fas fa-phone text-success me-2"></i>Phone:</strong><br>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">                        (555) 123-4567

            <!-- Contact Form -->                    </p>

            <div>                    <p class="mb-3">

                <h2 class="text-3xl font-display mb-6">Send Us a Message</h2>                        <strong><i class="fas fa-envelope text-success me-2"></i>Email:</strong><br>

                <p class="text-gray-600 mb-8">                        info@smithcentergolf.com

                    Have a question or want to book a tee time? Fill out the form below and we'll get back to you as soon as possible.                    </p>

                </p>                    <p class="mb-3">

                        <strong><i class="fas fa-clock text-success me-2"></i>Hours:</strong><br>

                <form action="#" method="POST" class="space-y-6">                        Open year round, weather permitting<br>

                    @csrf                        Dawn to Dusk

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">                    </p>

                        <div>                    <div class="mt-4">

                            <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">First Name</label>                        <a href="#" class="btn btn-outline-success me-2">

                            <input type="text"                             <i class="fab fa-facebook me-1"></i>Facebook

                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"                         </a>

                                   id="first_name"                         <a href="#" class="btn btn-outline-success">

                                   name="first_name"                             <i class="fab fa-instagram me-1"></i>Instagram

                                   required>                        </a>

                        </div>                    </div>

                                        </div>

                        <div>            </div>

                            <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">Last Name</label>

                            <input type="text"             <div class="card">

                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"                 <div class="card-header bg-primary text-white">

                                   id="last_name"                     <h4 class="mb-0"><i class="fas fa-directions me-2"></i>Directions</h4>

                                   name="last_name"                 </div>

                                   required>                <div class="card-body">

                        </div>                    <p><strong>From US-36:</strong></p>

                    </div>                    <p>Take Exit 12 toward Smith Center. Turn left onto Main Street. Continue for 2 miles. 

                    Turn right onto Golf Course Road. The course will be on your left.</p>

                    <div>                    

                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>                    <p><strong>From US-281:</strong></p>

                        <input type="email"                     <p>Head north on US-281. Turn right onto Highway 36. After 5 miles, take Exit 12 toward Smith Center. 

                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"                     Follow signs to Golf Course Road.</p>

                               id="email"                     

                               name="email"                     <div class="mt-3">

                               required>                        <a href="https://maps.google.com" target="_blank" class="btn btn-primary">

                    </div>                            <i class="fas fa-map-marked-alt me-2"></i>Open in Google Maps

                        </a>

                    <div>                    </div>

                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone</label>                </div>

                        <input type="tel"             </div>

                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"         </div>

                               id="phone" 

                               name="phone">        <div class="col-md-6">

                    </div>            <div class="card">

                <div class="card-header bg-info text-white">

                    <div>                    <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Send Us a Message</h4>

                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>                </div>

                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"                 <div class="card-body">

                                id="subject"                     <form action="#" method="POST">

                                name="subject"                         @csrf

                                required>                        <div class="mb-3">

                            <option value="">Select a subject</option>                            <label for="name" class="form-label">Name *</label>

                            <option value="tee-time">Tee Time Booking</option>                            <input type="text" class="form-control" id="name" name="name" required>

                            <option value="instruction">Golf Instruction</option>                        </div>

                            <option value="tournament">Tournament Information</option>                        <div class="mb-3">

                            <option value="membership">Membership Inquiry</option>                            <label for="email" class="form-label">Email *</label>

                            <option value="general">General Question</option>                            <input type="email" class="form-control" id="email" name="email" required>

                            <option value="other">Other</option>                        </div>

                        </select>                        <div class="mb-3">

                    </div>                            <label for="phone" class="form-label">Phone</label>

                            <input type="tel" class="form-control" id="phone" name="phone">

                    <div>                        </div>

                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>                        <div class="mb-3">

                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"                             <label for="subject" class="form-label">Subject *</label>

                                  id="message"                             <select class="form-select" id="subject" name="subject" required>

                                  name="message"                                 <option value="">Select a topic</option>

                                  rows="6"                                 <option value="tee-time">Tee Time Reservation</option>

                                  required></textarea>                                <option value="tournament">Tournament Information</option>

                    </div>                                <option value="instruction">Golf Lessons</option>

                                <option value="event">Event/Outing Inquiry</option>

                    <button type="submit" class="w-full px-8 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition text-lg">                                <option value="membership">Membership Information</option>

                        <i class="fas fa-paper-plane mr-2"></i>Send Message                                <option value="other">Other</option>

                    </button>                            </select>

                </form>                        </div>

            </div>                        <div class="mb-3">

                            <label for="message" class="form-label">Message *</label>

            <!-- Contact Information -->                            <textarea class="form-control" id="message" name="message" rows="6" required></textarea>

            <div class="space-y-8">                        </div>

                <div>                        <button type="submit" class="btn btn-success w-100">

                    <h2 class="text-3xl font-display mb-6">Get In Touch</h2>                            <i class="fas fa-paper-plane me-2"></i>Send Message

                    <p class="text-gray-600 mb-8">                        </button>

                        We'd love to hear from you! Whether you have questions about our course, want to book a tee time,                     </form>

                        or are interested in hosting an event, we're here to help.                    <p class="text-muted small mt-3">

                    </p>                        * Required fields. We'll respond to your inquiry within 24 hours.

                </div>                    </p>

                </div>

                <!-- Contact Cards -->            </div>

                <div class="space-y-4">        </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition">    </div>

                        <div class="flex items-start">

                            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">    <!-- Map Section (Placeholder) -->

                                <i class="fas fa-map-marker-alt text-emerald-600 text-xl"></i>    <div class="row">

                            </div>        <div class="col-md-12">

                            <div>            <div class="card">

                                <h3 class="font-display text-lg mb-2">Address</h3>                <div class="card-body p-0">

                                <p class="text-gray-600">123 Golf Course Road</p>                    <div style="height: 400px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center;">

                                <p class="text-gray-600">Smith Center, KS 66967</p>                        <div class="text-center">

                            </div>                            <i class="fas fa-map fa-3x text-muted mb-3"></i>

                        </div>                            <p class="text-muted">Map integration placeholder</p>

                    </div>                            <a href="https://maps.google.com" target="_blank" class="btn btn-outline-secondary">

                                View on Google Maps

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition">                            </a>

                        <div class="flex items-start">                        </div>

                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">                    </div>

                                <i class="fas fa-phone text-blue-600 text-xl"></i>                </div>

                            </div>            </div>

                            <div>        </div>

                                <h3 class="font-display text-lg mb-2">Phone</h3>    </div>

                                <p class="text-gray-600">(555) 123-4567</p></div>

                                <p class="text-sm text-gray-500 mt-1">Available 7 days a week</p>@endsection

                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-envelope text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-display text-lg mb-2">Email</h3>
                                <p class="text-gray-600">info@smithcentergolf.com</p>
                                <p class="text-sm text-gray-500 mt-1">We'll respond within 24 hours</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-clock text-yellow-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-display text-lg mb-2">Hours</h3>
                                <p class="text-gray-600 mb-2">
                                    <span class="font-semibold">Open year round</span><br>
                                    Weather permitting<br>
                                    Dawn to Dusk
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Placeholder -->
                <div class="bg-gray-200 rounded-2xl overflow-hidden shadow-lg h-64">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.2219901290355!2d-74.00369368400567!3d40.71312937933185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a23e28c1191%3A0x49f75d3281df052a!2s150%20Park%20Row%2C%20New%20York%2C%20NY%2010007!5e0!3m2!1sen!2sus!4v1629814071196!5m2!1sen!2sus" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
