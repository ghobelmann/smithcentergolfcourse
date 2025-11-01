@extends('layouts.tournament')

@section('title', $course->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $course->name }}</h4>
                    <div>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('courses.setup', $course) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-cogs me-2"></i>Setup Course
                                </a>
                                <a href="{{ route('courses.edit', $course) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit me-2"></i>Edit
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($course->description)
                    <p class="lead">{{ $course->description }}</p>
                @endif

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><i class="fas fa-map-marker-alt me-2"></i>Location</h6>
                        @if($course->address || $course->city || $course->state)
                            <p>
                                @if($course->address){{ $course->address }}<br>@endif
                                @if($course->city || $course->state)
                                    {{ $course->city }}@if($course->city && $course->state), @endif{{ $course->state }} {{ $course->zip_code }}
                                @endif
                            </p>
                        @else
                            <p class="text-muted">Location not specified</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-golf-ball me-2"></i>Course Details</h6>
                        <p>
                            <span class="badge bg-secondary">{{ $course->hole_count }} holes</span>
                            @if($course->par)
                                <span class="badge bg-primary">Par {{ $course->par }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($course->phone || $course->website)
                    <div class="row mb-4">
                        @if($course->phone)
                            <div class="col-md-6">
                                <h6><i class="fas fa-phone me-2"></i>Contact</h6>
                                <p>{{ $course->phone }}</p>
                            </div>
                        @endif
                        @if($course->website)
                            <div class="col-md-6">
                                <h6><i class="fas fa-globe me-2"></i>Website</h6>
                                <p><a href="{{ $course->website }}" target="_blank">{{ $course->website }}</a></p>
                            </div>
                        @endif
                    </div>
                @endif

                @if($course->holes()->count() > 0)
                    <div class="row">
                        <div class="col-12">
                            <h6><i class="fas fa-list me-2"></i>Course Layout</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Hole</th>
                                            <th>Par</th>
                                            <th>Handicap</th>
                                            @if($course->tees->count() > 0)
                                                @foreach($course->tees as $tee)
                                                    <th class="text-center">{{ $tee->getFormattedName() }}</th>
                                                @endforeach
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($course->holes as $hole)
                                            <tr>
                                                <td><strong>{{ $hole->hole_number }}</strong></td>
                                                <td>{{ $hole->par }}</td>
                                                <td>{{ $hole->handicap }}</td>
                                                @foreach($course->tees as $tee)
                                                    <td class="text-center">
                                                        {{ $hole->getYardageForTee($tee) ?? '-' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        <tr class="table-success">
                                            <th>Total</th>
                                            <th>{{ $course->holes()->sum('par') }}</th>
                                            <th>-</th>
                                            @foreach($course->tees as $tee)
                                                <th class="text-center">{{ $course->getYardageForTee($tee) }}</th>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Course Setup Needed</h6>
                        <p class="mb-0">This course needs hole and tee information to be configured.</p>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('courses.setup', $course) }}" class="btn btn-success btn-sm mt-2">
                                    <i class="fas fa-cogs me-2"></i>Setup Course Now
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($course->tees->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tee me-2"></i>Tee Information
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($course->tees as $tee)
                        <div class="border rounded p-3 mb-3">
                            <h6 class="mb-2">
                                {{ $tee->getFormattedName() }}
                                <small class="text-muted">({{ $tee->gender }})</small>
                            </h6>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Rating:</small><br>
                                    <strong>{{ $tee->rating }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Slope:</small><br>
                                    <strong>{{ $tee->slope }}</strong>
                                </div>
                            </div>
                            @if($tee->total_yardage)
                                <div class="mt-2">
                                    <small class="text-muted">Total Yardage:</small><br>
                                    <strong>{{ number_format($tee->total_yardage) }} yards</strong>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-trophy me-2"></i>Tournaments
                </h5>
            </div>
            <div class="card-body">
                @if($course->tournaments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($course->tournaments()->latest()->take(5)->get() as $tournament)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <a href="{{ route('tournaments.show', $tournament) }}" class="text-decoration-none">
                                            <strong>{{ $tournament->name }}</strong>
                                        </a>
                                        <br>
                                        <small class="text-muted">{{ $tournament->start_date->format('M j, Y') }}</small>
                                    </div>
                                    <span class="badge bg-{{ $tournament->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($tournament->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No tournaments have been held at this course yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Courses
        </a>
    </div>
</div>
@endsection