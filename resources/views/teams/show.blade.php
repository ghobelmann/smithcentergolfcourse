@extends('layouts.tournament')

@section('title', $team->name)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-users me-2"></i>{{ $team->name }}
                    </h4>
                    <div>
                        @if($team->tournament->status === 'upcoming')
                            <span class="badge bg-primary">Upcoming</span>
                        @elseif($team->tournament->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Completed</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($team->description)
                    <p class="lead">{{ $team->description }}</p>
                @endif

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><i class="fas fa-trophy me-2"></i>Tournament</h6>
                        <p>
                            <a href="{{ route('tournaments.show', $team->tournament) }}" class="text-decoration-none">
                                {{ $team->tournament->name }}
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar me-2"></i>Tournament Date</h6>
                        <p>{{ $team->tournament->start_date->format('F j, Y') }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><i class="fas fa-user-crown me-2"></i>Team Captain</h6>
                        <p>{{ $team->captain->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-users me-2"></i>Team Size</h6>
                        <p>{{ $team->members->count() }}/{{ $team->tournament->team_size }} players</p>
                    </div>
                </div>

                @auth
                    @php
                        $isMember = $team->members->where('user_id', Auth::id())->isNotEmpty();
                        $isCaptain = $team->captain_id === Auth::id();
                    @endphp

                    @if($isMember)
                        <div class="alert alert-success">
                            <h6><i class="fas fa-check-circle me-2"></i>You're a team member!</h6>
                            <p class="mb-0">
                                @if($isCaptain)
                                    You are the team captain.
                                @else
                                    You are a member of this team.
                                @endif
                            </p>
                        </div>
                    @elseif($team->tournament->isUpcoming() && $team->members->count() < $team->tournament->team_size)
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Join This Team</h6>
                            <p class="mb-0">This team has space for {{ $team->tournament->team_size - $team->members->count() }} more player{{ ($team->tournament->team_size - $team->members->count()) > 1 ? 's' : '' }}.</p>
                        </div>
                    @endif
                @endauth

                @if($team->tournament->status !== 'upcoming')
                    <div class="mt-4">
                        <a href="{{ route('tournaments.leaderboard', $team->tournament) }}" class="btn btn-success">
                            <i class="fas fa-list-ol me-2"></i>View Tournament Leaderboard
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Team Members -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Team Members</h5>
            </div>
            <div class="card-body">
                @if($team->members->count() > 0)
                    <div class="row">
                        @foreach($team->members as $member)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="card-title mb-1">
                                                    {{ $member->user->name }}
                                                    @if($member->user_id === $team->captain_id)
                                                        <span class="badge bg-warning text-dark ms-1">Captain</span>
                                                    @endif
                                                </h6>
                                                @if($member->user->handicap)
                                                    <p class="card-text text-muted mb-1">
                                                        <small>Handicap: {{ $member->user->handicap }}</small>
                                                    </p>
                                                @endif
                                                @if($member->user->home_course)
                                                    <p class="card-text text-muted mb-0">
                                                        <small>Home Course: {{ $member->user->home_course }}</small>
                                                    </p>
                                                @endif
                                            </div>
                                            @auth
                                                @if($isCaptain && $member->user_id !== Auth::id() && $team->tournament->isUpcoming())
                                                    <form method="POST" action="{{ route('teams.removeMember', [$team, $member]) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                                onclick="return confirm('Remove {{ $member->user->name }} from the team?')"
                                                                title="Remove from team">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No team members yet.</p>
                @endif

                @if($team->members->count() < $team->tournament->team_size)
                    <div class="alert alert-warning mt-3">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Team Incomplete</h6>
                        <p class="mb-0">
                            This team needs {{ $team->tournament->team_size - $team->members->count() }} more player{{ ($team->tournament->team_size - $team->members->count()) > 1 ? 's' : '' }} 
                            to participate in the tournament.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @auth
            @if($isMember && $team->tournament->isUpcoming())
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Team Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($isCaptain)
                                <a href="{{ route('teams.edit', $team) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Team
                                </a>
                                
                                @if($team->members->count() < $team->tournament->team_size)
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inviteModal">
                                        <i class="fas fa-user-plus me-2"></i>Invite Players
                                    </button>
                                @endif
                            @endif
                            
                            <form method="POST" action="{{ route('teams.leave', $team) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" 
                                        onclick="return confirm('Are you sure you want to leave this team?')">
                                    <i class="fas fa-sign-out-alt me-2"></i>Leave Team
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @elseif(!$isMember && $team->tournament->isUpcoming() && $team->members->count() < $team->tournament->team_size)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Join Team</h5>
                    </div>
                    <div class="card-body">
                        <p>This team has space for {{ $team->tournament->team_size - $team->members->count() }} more player{{ ($team->tournament->team_size - $team->members->count()) > 1 ? 's' : '' }}.</p>
                        
                        <form method="POST" action="{{ route('teams.join', $team) }}">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-user-plus me-2"></i>Join Team
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        @endauth

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Tournament Info</h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Format:</strong> {{ ucfirst($team->tournament->format) }} ({{ $team->tournament->team_size }} players)
                </div>
                <div class="mb-2">
                    <strong>Date:</strong> {{ $team->tournament->start_date->format('M j, Y') }}
                </div>
                <div class="mb-2">
                    <strong>Holes:</strong> {{ $team->tournament->holes }}
                </div>
                @if($team->tournament->entry_fee > 0)
                    <div class="mb-2">
                        <strong>Entry Fee:</strong> ${{ number_format($team->tournament->entry_fee, 2) }} per team
                    </div>
                @endif
                <div class="mb-0">
                    <strong>Status:</strong> {{ ucfirst($team->tournament->status) }}
                </div>
            </div>
        </div>
    </div>
</div>

@auth
    @if($isCaptain && $team->members->count() < $team->tournament->team_size)
        <!-- Invite Modal -->
        <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inviteModalLabel">
                            <i class="fas fa-user-plus me-2"></i>Invite Players
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Share this team link with other players:</p>
                        <div class="input-group">
                            <input type="text" class="form-control" id="teamLink" 
                                   value="{{ route('teams.show', $team) }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyTeamLink()">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        <div class="form-text">Players can visit this link and click "Join Team" to join your team.</div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endauth

@push('scripts')
<script>
function copyTeamLink() {
    const linkInput = document.getElementById('teamLink');
    linkInput.select();
    linkInput.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(linkInput.value);
    
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    button.innerHTML = '<i class="fas fa-check"></i>';
    button.classList.remove('btn-outline-secondary');
    button.classList.add('btn-success');
    
    setTimeout(() => {
        button.innerHTML = originalHTML;
        button.classList.remove('btn-success');
        button.classList.add('btn-outline-secondary');
    }, 2000);
}
</script>
@endpush
@endsection