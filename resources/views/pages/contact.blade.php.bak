@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Contact Us</h1>
    
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Course Information</h4>
                </div>
                <div class="card-body">
                    <p class="mb-3">
                        <strong><i class="fas fa-map-marker-alt text-success me-2"></i>Address:</strong><br>
                        123 Golf Course Road<br>
                        Smith Center, KS 66967
                    </p>
                    <p class="mb-3">
                        <strong><i class="fas fa-phone text-success me-2"></i>Phone:</strong><br>
                        (555) 123-4567
                    </p>
                    <p class="mb-3">
                        <strong><i class="fas fa-envelope text-success me-2"></i>Email:</strong><br>
                        info@smithcentergolf.com
                    </p>
                    <p class="mb-3">
                        <strong><i class="fas fa-clock text-success me-2"></i>Hours:</strong><br>
                        Open year round, weather permitting<br>
                        Dawn to Dusk
                    </p>
                    <div class="mt-4">
                        <a href="#" class="btn btn-outline-success me-2">
                            <i class="fab fa-facebook me-1"></i>Facebook
                        </a>
                        <a href="#" class="btn btn-outline-success">
                            <i class="fab fa-instagram me-1"></i>Instagram
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-directions me-2"></i>Directions</h4>
                </div>
                <div class="card-body">
                    <p><strong>From US-36:</strong></p>
                    <p>Take Exit 12 toward Smith Center. Turn left onto Main Street. Continue for 2 miles. 
                    Turn right onto Golf Course Road. The course will be on your left.</p>
                    
                    <p><strong>From US-281:</strong></p>
                    <p>Head north on US-281. Turn right onto Highway 36. After 5 miles, take Exit 12 toward Smith Center. 
                    Follow signs to Golf Course Road.</p>
                    
                    <div class="mt-3">
                        <a href="https://maps.google.com" target="_blank" class="btn btn-primary">
                            <i class="fas fa-map-marked-alt me-2"></i>Open in Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Send Us a Message</h4>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject *</label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="">Select a topic</option>
                                <option value="tee-time">Tee Time Reservation</option>
                                <option value="tournament">Tournament Information</option>
                                <option value="instruction">Golf Lessons</option>
                                <option value="event">Event/Outing Inquiry</option>
                                <option value="membership">Membership Information</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </form>
                    <p class="text-muted small mt-3">
                        * Required fields. We'll respond to your inquiry within 24 hours.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section (Placeholder) -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-0">
                    <div style="height: 400px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center;">
                        <div class="text-center">
                            <i class="fas fa-map fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Map integration placeholder</p>
                            <a href="https://maps.google.com" target="_blank" class="btn btn-outline-secondary">
                                View on Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
