@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Facilities</h1>
    
    <div class="row mb-5">
        <div class="col-md-12">
            <p class="lead">
                Smith Center Golf Course offers a complete range of facilities to enhance your golfing experience.
            </p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card h-100">
                <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     class="card-img-top" alt="Clubhouse">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-home text-success me-2"></i>Clubhouse</h4>
                    <p class="card-text">
                        Our modern clubhouse features a comfortable lounge area, snack bar, and full-service pro shop. 
                        Relax before or after your round with refreshments and enjoy the scenic views of the course.
                    </p>
                    <ul>
                        <li>Climate-controlled comfort</li>
                        <li>Snacks and beverages</li>
                        <li>Restrooms and lockers</li>
                        <li>WiFi available</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <img src="https://images.unsplash.com/photo-1593111774240-d529f12cf4bb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     class="card-img-top" alt="Pro Shop">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-store text-success me-2"></i>Pro Shop</h4>
                    <p class="card-text">
                        Stock up on equipment, apparel, and accessories in our well-stocked pro shop. 
                        Our knowledgeable staff can help you find the right gear for your game.
                    </p>
                    <ul>
                        <li>Top brand equipment</li>
                        <li>Golf apparel and shoes</li>
                        <li>Accessories and gifts</li>
                        <li>Club fitting services</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     class="card-img-top" alt="Practice Range">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-golf-ball text-success me-2"></i>Practice Facilities</h4>
                    <p class="card-text">
                        Warm up or work on your game at our practice facilities featuring a driving range, 
                        putting greens, and chipping area.
                    </p>
                    <ul>
                        <li>Full-length driving range</li>
                        <li>Practice putting greens</li>
                        <li>Short game practice area</li>
                        <li>Range balls available</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <img src="https://images.unsplash.com/photo-1535131749006-b7f58c99034b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     class="card-img-top" alt="Golf Carts">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-shuttle-van text-success me-2"></i>Golf Carts & Rentals</h4>
                    <p class="card-text">
                        Well-maintained fleet of golf carts and rental equipment available for your convenience.
                    </p>
                    <ul>
                        <li>Modern golf cart fleet</li>
                        <li>Club rentals available</li>
                        <li>Pull cart rentals</li>
                        <li>GPS-equipped carts</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Tournament & Event Hosting</h4>
                </div>
                <div class="card-body">
                    <p class="lead">
                        Host your next golf tournament or corporate outing at Smith Center Golf Course.
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Tournament Features:</h5>
                            <ul>
                                <li>Online tournament registration</li>
                                <li>Live scoring system</li>
                                <li>Customizable tournament formats</li>
                                <li>Leaderboard displays</li>
                                <li>Flight assignments</li>
                                <li>Tie-breaking rules</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Event Services:</h5>
                            <ul>
                                <li>Dedicated event coordinator</li>
                                <li>Custom tee signs available</li>
                                <li>Scoring assistance</li>
                                <li>Group rates and packages</li>
                                <li>Catering options available</li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('contact') }}" class="btn btn-success">Plan Your Event</a>
                        <a href="{{ route('tournaments.index') }}" class="btn btn-outline-success">View Upcoming Tournaments</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('tee-times') }}" class="btn btn-success btn-lg">
            <i class="fas fa-calendar-check me-2"></i>Book Your Tee Time
        </a>
    </div>
</div>
@endsection
