@extends('layouts.app')@extends('layouts.app')



@section('content')@section('content')

<!-- Hero Section --><div class="container my-5">

<section class="relative bg-gray-900 py-20">    <h1 class="mb-4">Golf Instruction</h1>

    <div class="absolute inset-0">    

        <img src="https://images.unsplash.com/photo-1530028828-25e8270e5afd?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80"     <div class="row mb-5">

             alt="Golf Instruction"         <div class="col-md-6">

             class="w-full h-full object-cover opacity-30">            <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 

    </div>                 alt="Golf Instruction" 

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">                 class="img-fluid rounded shadow">

        <h1 class="text-5xl sm:text-6xl font-display text-white mb-6">Golf Instruction</h1>        </div>

        <p class="text-xl text-gray-200 max-w-3xl mx-auto">        <div class="col-md-6">

            Improve your game with professional instruction            <h2>Improve Your Game</h2>

        </p>            <p class="lead">

    </div>                Whether you're a beginner or looking to refine your skills, our professional instructors 

</section>                can help you reach your golfing goals.

            </p>

<!-- Intro Section -->            <p>

<section class="py-20 bg-white">                We offer personalized instruction tailored to your skill level and learning style. 

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">                From basic fundamentals to advanced techniques, we cover all aspects of the game including:

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">            </p>

            <div>            <ul>

                <img src="https://images.unsplash.com/photo-1530028828-25e8270e5afd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"                 <li>Full swing mechanics</li>

                     alt="Golf Instruction"                 <li>Short game and chipping</li>

                     class="w-full rounded-2xl shadow-2xl">                <li>Putting techniques</li>

            </div>                <li>Course management</li>

            <div>                <li>Mental game strategies</li>

                <h2 class="text-4xl font-display mb-6">Improve Your Game</h2>            </ul>

                <p class="text-xl text-gray-600 mb-6 leading-relaxed">        </div>

                    Whether you're a beginner or looking to refine your skills, our professional instructors     </div>

                    can help you reach your golfing goals.

                </p>    <div class="row g-4 mb-5">

                <p class="text-gray-600 mb-6 leading-relaxed">        <div class="col-md-4">

                    We offer personalized instruction tailored to your skill level and learning style.             <div class="card h-100">

                    From basic fundamentals to advanced techniques, we cover all aspects of the game:                <div class="card-header bg-success text-white">

                </p>                    <h4 class="mb-0">Private Lessons</h4>

                <ul class="space-y-3">                </div>

                    <li class="flex items-start">                <div class="card-body">

                        <i class="fas fa-check-circle text-emerald-600 text-xl mr-3 mt-1"></i>                    <p><strong>One-on-One Instruction</strong></p>

                        <span class="text-gray-700">Full swing mechanics</span>                    <ul>

                    </li>                        <li>Personalized attention</li>

                    <li class="flex items-start">                        <li>Video analysis available</li>

                        <i class="fas fa-check-circle text-emerald-600 text-xl mr-3 mt-1"></i>                        <li>Custom practice plans</li>

                        <span class="text-gray-700">Short game and chipping</span>                    </ul>

                    </li>                    <hr>

                    <li class="flex items-start">                    <p class="mb-1"><strong>Pricing:</strong></p>

                        <i class="fas fa-check-circle text-emerald-600 text-xl mr-3 mt-1"></i>                    <p>Single Lesson (1 hour): <strong>$75</strong></p>

                        <span class="text-gray-700">Putting techniques</span>                    <p>5-Lesson Package: <strong>$350</strong></p>

                    </li>                    <p>10-Lesson Package: <strong>$650</strong></p>

                    <li class="flex items-start">                </div>

                        <i class="fas fa-check-circle text-emerald-600 text-xl mr-3 mt-1"></i>                <div class="card-footer">

                        <span class="text-gray-700">Course management</span>                    <a href="{{ route('contact') }}" class="btn btn-success w-100">Schedule Now</a>

                    </li>                </div>

                    <li class="flex items-start">            </div>

                        <i class="fas fa-check-circle text-emerald-600 text-xl mr-3 mt-1"></i>        </div>

                        <span class="text-gray-700">Mental game strategies</span>

                    </li>        <div class="col-md-4">

                </ul>            <div class="card h-100">

            </div>                <div class="card-header bg-primary text-white">

        </div>                    <h4 class="mb-0">Group Clinics</h4>

    </div>                </div>

</section>                <div class="card-body">

                    <p><strong>Small Group Sessions (4-6 players)</strong></p>

<!-- Lesson Types Section -->                    <ul>

<section class="py-20 bg-gray-50">                        <li>Learn with friends</li>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">                        <li>Focused topic sessions</li>

        <h2 class="text-4xl sm:text-5xl font-display text-center mb-16">Lesson Options</h2>                        <li>Weekly clinics available</li>

                            </ul>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">                    <hr>

            <!-- Private Lessons -->                    <p class="mb-1"><strong>Pricing:</strong></p>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition">                    <p>Per Person (1.5 hours): <strong>$40</strong></p>

                <div class="bg-emerald-600 text-white p-6">                    <p class="text-muted"><small>Minimum 4 participants</small></p>

                    <h3 class="text-2xl font-display">Private Lessons</h3>                </div>

                </div>                <div class="card-footer">

                <div class="p-8">                    <a href="{{ route('contact') }}" class="btn btn-primary w-100">Sign Up</a>

                    <p class="font-semibold text-gray-900 mb-4">One-on-One Instruction</p>                </div>

                    <ul class="space-y-3 mb-6">            </div>

                        <li class="flex items-start">        </div>

                            <i class="fas fa-star text-emerald-600 mr-2 mt-1"></i>

                            <span class="text-gray-600">Personalized attention</span>        <div class="col-md-4">

                        </li>            <div class="card h-100">

                        <li class="flex items-start">                <div class="card-header bg-warning">

                            <i class="fas fa-star text-emerald-600 mr-2 mt-1"></i>                    <h4 class="mb-0">Junior Programs</h4>

                            <span class="text-gray-600">Video analysis available</span>                </div>

                        </li>                <div class="card-body">

                        <li class="flex items-start">                    <p><strong>Ages 8-17</strong></p>

                            <i class="fas fa-star text-emerald-600 mr-2 mt-1"></i>                    <ul>

                            <span class="text-gray-600">Custom practice plans</span>                        <li>Introduction to golf</li>

                        </li>                        <li>Age-appropriate instruction</li>

                    </ul>                        <li>Summer camps available</li>

                    <div class="border-t border-gray-200 pt-6 space-y-3">                    </ul>

                        <p class="font-semibold text-gray-900">Pricing:</p>                    <hr>

                        <div class="flex justify-between items-center">                    <p class="mb-1"><strong>Pricing:</strong></p>

                            <span class="text-gray-600">Single Lesson (1 hour)</span>                    <p>6-Week Program: <strong>$150</strong></p>

                            <span class="text-xl font-bold text-emerald-600">$75</span>                    <p>Summer Camp (1 week): <strong>$200</strong></p>

                        </div>                </div>

                        <div class="flex justify-between items-center">                <div class="card-footer">

                            <span class="text-gray-600">5-Lesson Package</span>                    <a href="{{ route('contact') }}" class="btn btn-warning w-100">Learn More</a>

                            <span class="text-xl font-bold text-emerald-600">$350</span>                </div>

                        </div>            </div>

                        <div class="flex justify-between items-center">        </div>

                            <span class="text-gray-600">10-Lesson Package</span>    </div>

                            <span class="text-xl font-bold text-emerald-600">$650</span>

                        </div>    <div class="row mb-5">

                    </div>        <div class="col-md-12">

                </div>            <div class="card">

            </div>                <div class="card-body">

                    <h3 class="card-title">Our Instructors</h3>

            <!-- Group Lessons -->                    <p class="lead">

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition">                        Learn from experienced PGA-certified professionals dedicated to helping you improve.

                <div class="bg-blue-600 text-white p-6">                    </p>

                    <h3 class="text-2xl font-display">Group Lessons</h3>                    

                </div>                    <div class="row mt-4">

                <div class="p-8">                        <div class="col-md-6">

                    <p class="font-semibold text-gray-900 mb-4">Small Group Sessions</p>                            <div class="d-flex align-items-start mb-4">

                    <ul class="space-y-3 mb-6">                                <div class="flex-shrink-0">

                        <li class="flex items-start">                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" 

                            <i class="fas fa-star text-blue-600 mr-2 mt-1"></i>                                         style="width: 80px; height: 80px;">

                            <span class="text-gray-600">Maximum 4 students</span>                                        <i class="fas fa-user fa-2x"></i>

                        </li>                                    </div>

                        <li class="flex items-start">                                </div>

                            <i class="fas fa-star text-blue-600 mr-2 mt-1"></i>                                <div class="flex-grow-1 ms-3">

                            <span class="text-gray-600">Learn with friends</span>                                    <h5>Head Professional</h5>

                        </li>                                    <p class="text-muted mb-1">PGA Certified</p>

                        <li class="flex items-start">                                    <p class="small">

                            <i class="fas fa-star text-blue-600 mr-2 mt-1"></i>                                        20+ years of teaching experience. Specializes in swing mechanics and 

                            <span class="text-gray-600">Fun, social environment</span>                                        course management for players of all levels.

                        </li>                                    </p>

                    </ul>                                </div>

                    <div class="border-t border-gray-200 pt-6 space-y-3">                            </div>

                        <p class="font-semibold text-gray-900">Pricing:</p>                        </div>

                        <div class="flex justify-between items-center">                        <div class="col-md-6">

                            <span class="text-gray-600">Per Person (1 hour)</span>                            <div class="d-flex align-items-start mb-4">

                            <span class="text-xl font-bold text-blue-600">$40</span>                                <div class="flex-shrink-0">

                        </div>                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" 

                        <div class="flex justify-between items-center">                                         style="width: 80px; height: 80px;">

                            <span class="text-gray-600">4-Week Series</span>                                        <i class="fas fa-user fa-2x"></i>

                            <span class="text-xl font-bold text-blue-600">$150</span>                                    </div>

                        </div>                                </div>

                        <div class="flex justify-between items-center">                                <div class="flex-grow-1 ms-3">

                            <span class="text-gray-600 text-sm">per person</span>                                    <h5>Assistant Professional</h5>

                        </div>                                    <p class="text-muted mb-1">PGA Certified</p>

                    </div>                                    <p class="small">

                </div>                                        Former collegiate player with expertise in short game and putting. 

            </div>                                        Passionate about junior development programs.

                                    </p>

            <!-- Junior Programs -->                                </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition">                            </div>

                <div class="bg-yellow-500 text-gray-900 p-6">                        </div>

                    <h3 class="text-2xl font-display">Junior Programs</h3>                    </div>

                </div>                </div>

                <div class="p-8">            </div>

                    <p class="font-semibold text-gray-900 mb-4">For Young Golfers (Ages 8-17)</p>        </div>

                    <ul class="space-y-3 mb-6">    </div>

                        <li class="flex items-start">

                            <i class="fas fa-star text-yellow-600 mr-2 mt-1"></i>    <div class="text-center">

                            <span class="text-gray-600">Age-appropriate instruction</span>        <h3 class="mb-3">Ready to Get Started?</h3>

                        </li>        <p class="lead mb-4">Contact us to schedule your first lesson or learn more about our programs.</p>

                        <li class="flex items-start">        <a href="{{ route('contact') }}" class="btn btn-success btn-lg">

                            <i class="fas fa-star text-yellow-600 mr-2 mt-1"></i>            <i class="fas fa-envelope me-2"></i>Contact Us

                            <span class="text-gray-600">Focus on fundamentals</span>        </a>

                        </li>    </div>

                        <li class="flex items-start"></div>

                            <i class="fas fa-star text-yellow-600 mr-2 mt-1"></i>@endsection

                            <span class="text-gray-600">Equipment provided</span>
                        </li>
                    </ul>
                    <div class="border-t border-gray-200 pt-6 space-y-3">
                        <p class="font-semibold text-gray-900">Pricing:</p>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Single Session</span>
                            <span class="text-xl font-bold text-yellow-600">$35</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Summer Camp (Week)</span>
                            <span class="text-xl font-bold text-yellow-600">$200</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Mon-Fri, 9am-12pm</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Instructors Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-display text-center mb-12">Our Instructors</h2>
        <div class="bg-gray-50 rounded-2xl p-8 md:p-12">
            <div class="flex items-start">
                <div class="w-20 h-20 bg-emerald-100 rounded-2xl flex items-center justify-center mr-6 flex-shrink-0">
                    <i class="fas fa-graduation-cap text-4xl text-emerald-600"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-display mb-4">PGA Certified Professionals</h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        All of our instructors are PGA certified professionals with years of teaching experience. 
                        They are passionate about the game and dedicated to helping you improve.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Each instructor brings their own teaching style and expertise, ensuring we can match you 
                        with the perfect coach for your needs and goals.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gray-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-display mb-6">Ready to Improve Your Game?</h2>
        <p class="text-xl text-gray-300 mb-10">
            Contact us to schedule your first lesson today
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-all duration-300 text-lg">
                Schedule a Lesson
            </a>
            <a href="tel:555-123-4567" class="inline-flex items-center justify-center px-10 py-4 bg-white text-gray-900 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 text-lg">
                Call: (555) 123-4567
            </a>
        </div>
    </div>
</section>
@endsection
