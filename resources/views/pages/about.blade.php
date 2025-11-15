@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">About Smith Center Golf Course</h1>
            
            <div class="row mb-5">
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1535131749006-b7f58c99034b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Golf Course" 
                         class="img-fluid rounded shadow mb-3">
                </div>
                <div class="col-md-6">
                    <h2>Our Story</h2>
                    <p class="lead">
                        Welcome to Smith Center Golf Course, a premier golfing destination that has been serving the community for decades.
                    </p>
                    <p>
                        Our 18-hole championship course offers a challenging yet enjoyable experience for golfers of all skill levels. 
                        Nestled in the heart of Kansas, our course features well-maintained greens, strategic bunkers, and beautiful natural landscapes.
                    </p>
                    <p>
                        Whether you're a seasoned pro or just starting out, our friendly staff and excellent facilities ensure 
                        an unforgettable golfing experience every time you visit.
                    </p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-12">
                    <h2 class="mb-4">Course Features</h2>
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <i class="fas fa-flag fa-3x text-success mb-3"></i>
                                    <h5>18 Holes</h5>
                                    <p>Championship course with varying difficulty</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <i class="fas fa-golf-ball fa-3x text-success mb-3"></i>
                                    <h5>Practice Facilities</h5>
                                    <p>Driving range and putting greens</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <i class="fas fa-store fa-3x text-success mb-3"></i>
                                    <h5>Pro Shop</h5>
                                    <p>Full-service shop with equipment and apparel</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <i class="fas fa-utensils fa-3x text-success mb-3"></i>
                                    <h5>Clubhouse</h5>
                                    <p>Snacks and beverages available</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-12">
                    <h2 class="mb-4">Course Details</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">Total Yardage</th>
                                    <td>6,500 yards (Championship Tees)</td>
                                </tr>
                                <tr>
                                    <th>Par</th>
                                    <td>72</td>
                                </tr>
                                <tr>
                                    <th>Course Rating</th>
                                    <td>71.5</td>
                                </tr>
                                <tr>
                                    <th>Slope Rating</th>
                                    <td>128</td>
                                </tr>
                                <tr>
                                    <th>Grass Type</th>
                                    <td>Bent Grass Greens, Bluegrass Fairways</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('tee-times') }}" class="btn btn-success btn-lg me-3">Book a Tee Time</a>
                <a href="{{ route('contact') }}" class="btn btn-outline-success btn-lg">Contact Us</a>
            </div>
        </div>
    </div>
</div>
@endsection
