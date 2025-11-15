@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Book a Tee Time</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Reserve Your Spot</h4>
                    <p class="lead">
                        Book your tee time online or call us directly. We recommend booking at least 24 hours in advance, 
                        especially for weekend play.
                    </p>

                    <form action="#" method="POST" class="mt-4">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required 
                                       min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="time" class="form-label">Preferred Time</label>
                                <select class="form-select" id="time" name="time" required>
                                    <option value="">Select a time</option>
                                    <option value="07:00">7:00 AM</option>
                                    <option value="07:30">7:30 AM</option>
                                    <option value="08:00">8:00 AM</option>
                                    <option value="08:30">8:30 AM</option>
                                    <option value="09:00">9:00 AM</option>
                                    <option value="09:30">9:30 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="10:30">10:30 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="11:30">11:30 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="12:30">12:30 PM</option>
                                    <option value="13:00">1:00 PM</option>
                                    <option value="13:30">1:30 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="14:30">2:30 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="15:30">3:30 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="players" class="form-label">Number of Players</label>
                                <select class="form-select" id="players" name="players" required>
                                    <option value="">Select number</option>
                                    <option value="1">1 Player</option>
                                    <option value="2">2 Players</option>
                                    <option value="3">3 Players</option>
                                    <option value="4">4 Players</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="holes" class="form-label">Holes</label>
                                <select class="form-select" id="holes" name="holes" required>
                                    <option value="">Select holes</option>
                                    <option value="9">9 Holes</option>
                                    <option value="18">18 Holes</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="cart" name="cart">
                                    <label class="form-check-label" for="cart">
                                        Include Golf Cart
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-12">
                                <label for="notes" class="form-label">Special Requests (Optional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check me-2"></i>Request Tee Time
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Call to Book</h5>
                </div>
                <div class="card-body">
                    <p class="fs-4 fw-bold text-center mb-0">(555) 123-4567</p>
                    <p class="text-center text-muted">Available 7 days a week</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Tee Time Hours</h5>
                </div>
                <div class="card-body">
                    <p><strong>Spring/Summer/Fall:</strong><br>
                    7:00 AM - 5:00 PM</p>
                    <p><strong>Winter:</strong><br>
                    8:00 AM - 4:00 PM<br>
                    <small class="text-muted">(Weather permitting)</small></p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Cancellation Policy</h5>
                </div>
                <div class="card-body">
                    <p class="small">
                        Please provide at least 24 hours notice for cancellations. 
                        Late cancellations may be subject to a fee.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
