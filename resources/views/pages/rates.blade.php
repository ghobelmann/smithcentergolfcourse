@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Rates & Fees</h1>
    
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                All rates subject to change. Please call ahead for current pricing and availability.
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-sun me-2"></i>Weekday Rates</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>18 Holes with Cart</td>
                                <td class="text-end"><strong>$40</strong></td>
                            </tr>
                            <tr>
                                <td>18 Holes Walking</td>
                                <td class="text-end"><strong>$25</strong></td>
                            </tr>
                            <tr>
                                <td>9 Holes with Cart</td>
                                <td class="text-end"><strong>$25</strong></td>
                            </tr>
                            <tr>
                                <td>9 Holes Walking</td>
                                <td class="text-end"><strong>$15</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-calendar-week me-2"></i>Weekend Rates</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>18 Holes with Cart</td>
                                <td class="text-end"><strong>$50</strong></td>
                            </tr>
                            <tr>
                                <td>18 Holes Walking</td>
                                <td class="text-end"><strong>$35</strong></td>
                            </tr>
                            <tr>
                                <td>9 Holes with Cart</td>
                                <td class="text-end"><strong>$30</strong></td>
                            </tr>
                            <tr>
                                <td>9 Holes Walking</td>
                                <td class="text-end"><strong>$20</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-id-card me-2"></i>Season Passes</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Individual Annual Pass</td>
                                <td class="text-end"><strong>$800</strong></td>
                            </tr>
                            <tr>
                                <td>Senior Annual Pass (62+)</td>
                                <td class="text-end"><strong>$650</strong></td>
                            </tr>
                            <tr>
                                <td>Junior Annual Pass (Under 18)</td>
                                <td class="text-end"><strong>$400</strong></td>
                            </tr>
                            <tr>
                                <td>Family Annual Pass</td>
                                <td class="text-end"><strong>$1,500</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="text-muted mt-3">
                        <small>Season passes include unlimited golf and cart usage for the entire season (April - October)</small>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0"><i class="fas fa-golf-ball me-2"></i>Additional Services</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Cart Rental (9 holes)</td>
                                <td class="text-end"><strong>$10</strong></td>
                            </tr>
                            <tr>
                                <td>Cart Rental (18 holes)</td>
                                <td class="text-end"><strong>$15</strong></td>
                            </tr>
                            <tr>
                                <td>Club Rental</td>
                                <td class="text-end"><strong>$20</strong></td>
                            </tr>
                            <tr>
                                <td>Range Balls (small bucket)</td>
                                <td class="text-end"><strong>$5</strong></td>
                            </tr>
                            <tr>
                                <td>Range Balls (large bucket)</td>
                                <td class="text-end"><strong>$8</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-users me-2"></i>Group & Tournament Rates</h4>
                    <p class="card-text">
                        We offer special rates for groups of 12 or more and tournament hosting. 
                        Our facility can accommodate tournaments of various sizes with our comprehensive scoring system.
                    </p>
                    <p class="card-text">
                        Contact us for custom pricing and availability for your group or tournament needs.
                    </p>
                    <a href="{{ route('contact') }}" class="btn btn-success">Contact for Group Rates</a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('tee-times') }}" class="btn btn-success btn-lg">
            <i class="fas fa-calendar-check me-2"></i>Book Your Tee Time
        </a>
    </div>
</div>
@endsection
