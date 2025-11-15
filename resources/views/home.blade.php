<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smith Center Golf Course</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('https://images.unsplash.com/photo-1535131749006-b7f58c99034b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .card-icon {
            font-size: 3rem;
            color: #2d5f2e;
            margin-bottom: 1rem;
        }
        .quick-link-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            height: 100%;
        }
        .quick-link-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .tournament-card {
            border-left: 4px solid #2d5f2e;
        }
        .info-section {
            background-color: #f8f9fa;
            padding: 3rem 0;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-golf-ball me-2"></i>
                Smith Center Golf Course
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown">
                            About
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('about') }}">About Us</a></li>
                            <li><a class="dropdown-item" href="{{ route('facilities') }}">Facilities</a></li>
                            <li><a class="dropdown-item" href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rates') }}">Rates</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tee-times') }}">Tee Times</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tournaments.index') }}">Tournaments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('instruction') }}">Instruction</a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                @if(Auth::user()->isAdmin())
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('tournaments.create') }}">Create Tournament</a></li>
                                    <li><a class="dropdown-item" href="{{ route('courses.index') }}">Manage Courses</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-3 fw-bold mb-3">Welcome to Smith Center Golf Course</h1>
            <p class="lead mb-4">Experience the perfect blend of challenge and beauty</p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ route('tee-times') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-calendar-alt me-2"></i>Book Tee Time
                </a>
                <a href="{{ route('rates') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-dollar-sign me-2"></i>View Rates
                </a>
            </div>
        </div>
    </section>

    <!-- Quick Links Section -->
    <section class="container my-5">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card quick-link-card text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-clock card-icon"></i>
                        <h5 class="card-title">Tee Times</h5>
                        <p class="card-text">Reserve your spot on the course</p>
                        <a href="{{ route('tee-times') }}" class="btn btn-success">Book Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card quick-link-card text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-trophy card-icon"></i>
                        <h5 class="card-title">Tournaments</h5>
                        <p class="card-text">View and register for events</p>
                        <a href="{{ route('tournaments.index') }}" class="btn btn-success">View Events</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card quick-link-card text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-graduation-cap card-icon"></i>
                        <h5 class="card-title">Instruction</h5>
                        <p class="card-text">Improve your game with lessons</p>
                        <a href="{{ route('instruction') }}" class="btn btn-success">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card quick-link-card text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-info-circle card-icon"></i>
                        <h5 class="card-title">About Us</h5>
                        <p class="card-text">Learn about our course</p>
                        <a href="{{ route('about') }}" class="btn btn-success">Discover</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Info Section -->
    <section class="info-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="mb-4">A Premier Golf Experience</h2>
                    <p class="lead mb-3">
                        Smith Center Golf Course offers an exceptional golfing experience for players of all skill levels.
                    </p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>18-hole championship course</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Well-maintained greens and fairways</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pro shop and practice facilities</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Professional instruction available</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Tournament hosting and scoring</li>
                    </ul>
                    <a href="{{ route('about') }}" class="btn btn-success mt-3">Learn More About Us</a>
                </div>
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Golf Course" 
                         class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Tournaments Section -->
    @if($upcomingTournaments->count() > 0)
    <section class="container my-5">
        <h2 class="text-center mb-4">Upcoming Tournaments</h2>
        <div class="row g-4">
            @foreach($upcomingTournaments as $tournament)
            <div class="col-md-4">
                <div class="card tournament-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $tournament->name }}</h5>
                        <p class="card-text">
                            <i class="fas fa-calendar me-2"></i>{{ \Carbon\Carbon::parse($tournament->start_date)->format('F j, Y') }}<br>
                            <i class="fas fa-map-marker-alt me-2"></i>{{ $tournament->course->name ?? 'TBD' }}<br>
                            <i class="fas fa-users me-2"></i>{{ $tournament->format ?? 'Stroke Play' }}
                        </p>
                        <a href="{{ route('tournaments.show', $tournament) }}" class="btn btn-outline-success">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('tournaments.index') }}" class="btn btn-success">View All Tournaments</a>
        </div>
    </section>
    @endif

    <!-- Hours & Contact Section -->
    <section class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="mb-3"><i class="fas fa-clock me-2"></i>Hours</h4>
                    <p>
                        <strong>Open year round</strong><br>
                        Weather permitting<br>
                        Dawn to Dusk
                    </p>
                </div>
                <div class="col-md-4">
                    <h4 class="mb-3"><i class="fas fa-phone me-2"></i>Contact</h4>
                    <p>
                        Phone: (555) 123-4567<br>
                        Email: info@smithcentergolf.com
                    </p>
                </div>
                <div class="col-md-4">
                    <h4 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Location</h4>
                    <p>
                        123 Golf Course Road<br>
                        Smith Center, KS 66967
                    </p>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light">Get Directions</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-success text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} Smith Center Golf Course. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
