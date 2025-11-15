<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smith Center Golf Course</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            line-height: 1.6;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            line-height: 1.2;
        }
        .navbar {
            padding: 0.5rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 600;
        }
        .nav-link {
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            font-weight: 500;
        }
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('https://images.unsplash.com/photo-1535131749006-b7f58c99034b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            height: 70vh;
            min-height: 500px;
            max-height: 700px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .hero-section .lead {
            font-size: 1.5rem;
            font-weight: 300;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
        .btn-lg {
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            font-weight: 500;
        }
        .card-icon {
            font-size: 2.5rem;
            color: #2d5f2e;
            margin-bottom: 0.75rem;
        }
        .quick-link-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .quick-link-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .quick-link-card .card-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }
        .quick-link-card .card-text {
            font-size: 0.95rem;
            color: #6c757d;
        }
        .tournament-card {
            border-left: 4px solid #2d5f2e;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .info-section {
            background-color: #f8f9fa;
            padding: 4rem 0;
        }
        .info-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }
        .info-section .lead {
            font-size: 1.15rem;
            color: #6c757d;
        }
        section h2 {
            font-size: 2.25rem;
            margin-bottom: 2rem;
        }
        footer {
            font-size: 0.9rem;
        }
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }
            .hero-section .lead {
                font-size: 1.15rem;
            }
            .hero-section {
                height: 60vh;
                min-height: 400px;
            }
            .info-section h2 {
                font-size: 2rem;
            }
            section h2 {
                font-size: 1.75rem;
            }
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
            <h1 class="fw-bold mb-4">Welcome to Smith Center Golf Course</h1>
            <p class="lead mb-5">Experience the perfect blend of challenge and beauty</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('tee-times') }}" class="btn btn-light btn-lg px-4">
                    <i class="fas fa-calendar-alt me-2"></i>Book Tee Time
                </a>
                <a href="{{ route('rates') }}" class="btn btn-outline-light btn-lg px-4">
                    <i class="fas fa-dollar-sign me-2"></i>View Rates
                </a>
            </div>
        </div>
    </section>

    <!-- Quick Links Section -->
    <section class="container my-5 py-4">
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="card quick-link-card text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-clock card-icon"></i>
                        <h5 class="card-title">Tee Times</h5>
                        <p class="card-text mb-3">Reserve your spot on the course</p>
                        <a href="{{ route('tee-times') }}" class="btn btn-success">Book Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card quick-link-card text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-trophy card-icon"></i>
                        <h5 class="card-title">Tournaments</h5>
                        <p class="card-text mb-3">View and register for events</p>
                        <a href="{{ route('tournaments.index') }}" class="btn btn-success">View Events</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card quick-link-card text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-graduation-cap card-icon"></i>
                        <h5 class="card-title">Instruction</h5>
                        <p class="card-text mb-3">Improve your game with lessons</p>
                        <a href="{{ route('instruction') }}" class="btn btn-success">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card quick-link-card text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-info-circle card-icon"></i>
                        <h5 class="card-title">About Us</h5>
                        <p class="card-text mb-3">Learn about our course</p>
                        <a href="{{ route('about') }}" class="btn btn-success">Discover</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Info Section -->
    <section class="info-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h2 class="mb-4">A Premier Golf Experience</h2>
                    <p class="lead mb-4">
                        Smith Center Golf Course offers an exceptional golfing experience for players of all skill levels.
                    </p>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>18-hole championship course</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Well-maintained greens and fairways</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Pro shop and practice facilities</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Professional instruction available</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Tournament hosting and scoring</li>
                    </ul>
                    <a href="{{ route('about') }}" class="btn btn-success btn-lg">Learn More About Us</a>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Golf Course" 
                         class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Tournaments Section -->
    @if($upcomingTournaments->count() > 0)
    <section class="container my-5 py-4">
        <h2 class="text-center mb-5">Upcoming Tournaments</h2>
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
            <div class="row g-4">
                <div class="col-md-4 text-center text-md-start">
                    <h5 class="mb-3"><i class="fas fa-clock me-2"></i>Hours</h5>
                    <p class="mb-0">
                        <strong>Open year round</strong><br>
                        Weather permitting<br>
                        Dawn to Dusk
                    </p>
                </div>
                <div class="col-md-4 text-center text-md-start">
                    <h5 class="mb-3"><i class="fas fa-phone me-2"></i>Contact</h5>
                    <p class="mb-0">
                        Phone: (555) 123-4567<br>
                        Email: info@smithcentergolf.com
                    </p>
                </div>
                <div class="col-md-4 text-center text-md-start">
                    <h5 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Location</h5>
                    <p class="mb-3">
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
