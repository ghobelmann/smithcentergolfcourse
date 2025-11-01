@extends('layouts.tournament')

@section('title', 'Tournaments')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-trophy me-2"></i>Tournaments</h1>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('tournaments.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Create Tournament
                    </a>
                @endif
            @endauth
        </div>

        @if($tournaments->count() > 0)
            <div class="row">
                @foreach($tournaments as $tournament)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ $tournament->name }}</h5>
                                <small class="text-muted">
                                    @if($tournament->status === 'upcoming')
                                        <span class="badge bg-primary">Upcoming</span>
                                    @elseif($tournament->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Completed</span>
                                    @endif
                                </small>
                            </div>
                            <div class="card-body">
                                @if($tournament->description)
                                    <p class="card-text">{{ Str::limit($tournament->description, 100) }}</p>
                                @endif
                                
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $tournament->start_date->format('M j, Y') }} - 
                                        {{ $tournament->end_date->format('M j, Y') }}
                                    </small>
                                </div>
                                
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i>
                                        {{ $tournament->entries_count }} 
                                        @if($tournament->max_participants)
                                            / {{ $tournament->max_participants }}
                                        @endif
                                        participants
                                    </small>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-golf-ball me-1"></i>
                                        {{ $tournament->holes }} holes - {{ $tournament->getFormatDescription() }}
                                    </small>
                                </div>

                                @if($tournament->entry_fee > 0)
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-dollar-sign me-1"></i>
                                            Entry Fee: ${{ number_format($tournament->entry_fee, 2) }}
                                        </small>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('tournaments.show', $tournament) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                    @if($tournament->status !== 'upcoming')
                                        <a href="{{ route('tournaments.leaderboard', $tournament) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-list-ol me-1"></i>Leaderboard
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                {{ $tournaments->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                <h3 class="text-muted">No tournaments yet</h3>
                <p class="text-muted">Be the first to create a tournament!</p>
                @auth
                    <a href="{{ route('tournaments.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Create Tournament
                    </a>
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection