@extends('layouts.tournament')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                @if(auth()->user()->isAdmin())
                    <span class="badge bg-warning text-dark ms-2">Administrator</span>
                @endif
            </h1>
            <span class="text-muted">Welcome back, {{ auth()->user()->name }}!</span>
        </div>
    </div>
</div>

<div class="row">
    <!-- Quick Stats -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Active Tournaments</h6>
                        <h2 class="mb-0">{{ \App\Models\Tournament::where('status', 'active')->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-trophy fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">My Entries</h6>
                        <h2 class="mb-0">{{ auth()->user()->tournamentEntries()->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-check fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">My Teams</h6>
                        <h2 class="mb-0">{{ auth()->user()->teams()->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Handicap</h6>
                        <h2 class="mb-0">{{ auth()->user()->handicap ?? 'N/A' }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-golf-ball fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Tournament Entries -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-check me-2"></i>My Recent Tournament Entries
                </h5>
                <a href="{{ route('tournaments.index') }}" class="btn btn-outline-success btn-sm">
                    View All Tournaments
                </a>
            </div>
            <div class="card-body">
                @php
                    $recentEntries = auth()->user()->tournamentEntries()
                        ->with('tournament')
                        ->latest()
                        ->limit(5)
                        ->get();
                @endphp
                
                @if($recentEntries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tournament</th>
                                    <th>Date</th>
                                    <th>Format</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentEntries as $entry)
                                <tr>
                                    <td>
                                        <a href="{{ route('tournaments.show', $entry->tournament) }}" class="text-decoration-none">
                                            {{ $entry->tournament->name }}
                                        </a>
                                    </td>
                                    <td>{{ $entry->tournament->start_date->format('M j, Y') }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($entry->tournament->format) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $entry->tournament->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($entry->tournament->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-golf-ball fa-3x text-muted mb-3"></i>
                        <p class="text-muted">You haven't entered any tournaments yet.</p>
                        <a href="{{ route('tournaments.index') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Find Tournaments
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('tournaments.index') }}" class="btn btn-success">
                        <i class="fas fa-search me-2"></i>Browse Tournaments
                    </a>
                    <a href="{{ route('teams.create') }}" class="btn btn-primary">
                        <i class="fas fa-users me-2"></i>Create Team
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('tournaments.create') }}" class="btn btn-warning">
                            <i class="fas fa-plus me-2"></i>Create Tournament
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-user-edit me-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- User Info Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>Player Info
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Name:</strong> {{ auth()->user()->name }}
                </div>
                <div class="mb-2">
                    <strong>Email:</strong> {{ auth()->user()->email }}
                </div>
                <div class="mb-2">
                    <strong>Handicap:</strong> {{ auth()->user()->handicap ?? 'Not set' }}
                </div>
                <div class="mb-2">
                    <strong>Home Course:</strong> {{ auth()->user()->home_course ?? 'Not set' }}
                </div>
                <div class="mb-0">
                    <strong>Member Since:</strong> {{ auth()->user()->created_at->format('M Y') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
