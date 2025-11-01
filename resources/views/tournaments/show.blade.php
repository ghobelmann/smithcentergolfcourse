@extends('layouts.tournament')

@section('title', $tournament->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $tournament->name }}</h4>
                    <div>
                        @if($tournament->status === 'upcoming')
                            <span class="badge bg-primary">Upcoming</span>
                        @elseif($tournament->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Completed</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($tournament->description)
                    <p class="lead">{{ $tournament->description }}</p>
                @endif

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar me-2"></i>Tournament Dates</h6>
                        <p>{{ $tournament->start_date->format('F j, Y') }} - {{ $tournament->end_date->format('F j, Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-golf-ball me-2"></i>Course Details</h6>
                        <p>{{ $tournament->holes }} holes</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><i class="fas fa-trophy me-2"></i>Format</h6>
                        <p>
                            <span class="badge bg-primary">{{ ucfirst($tournament->format) }}</span>
                            @if($tournament->format === 'scramble')
                                ({{ $tournament->team_size }} Player{{ $tournament->team_size > 1 ? 's' : '' }})
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-users me-2"></i>Participants</h6>
                        <p>
                            @if($tournament->format === 'scramble')
                                {{ $tournament->teams->count() }} teams
                                ({{ $tournament->teams->sum(function($team) { return $team->members->count(); }) }} players)
                            @else
                                {{ $tournament->entries->count() }}
                            @endif
                            @if($tournament->max_participants)
                                / {{ $tournament->max_participants }}
                            @endif
                            {{ $tournament->format === 'scramble' ? 'teams' : 'players' }}
                        </p>
                    </div>
                </div>

                @if($tournament->entry_fee > 0)
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6><i class="fas fa-dollar-sign me-2"></i>Entry Fee</h6>
                            <p>${{ number_format($tournament->entry_fee, 2) }}{{ $tournament->format === 'scramble' ? ' per team' : ' per player' }}</p>
                        </div>
                    </div>
                @endif

                @auth
                    @php
                        if ($tournament->format === 'scramble') {
                            $userTeam = $tournament->teams()
                                ->whereHas('members', function($query) {
                                    $query->where('user_id', Auth::id());
                                })
                                ->first();
                        } else {
                            $userEntry = $tournament->entries->where('user_id', Auth::id())->first();
                        }
                    @endphp

                    @if($tournament->format === 'scramble')
                        @if(!$userTeam && $tournament->isUpcoming() && $tournament->hasSpaceAvailable())
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle me-2"></i>Team Registration Open</h6>
                                <p class="mb-0">You can create a team or join an existing team for this {{ $tournament->team_size }}-player scramble tournament.</p>
                            </div>
                        @elseif($userTeam)
                            <div class="alert alert-success">
                                <h6><i class="fas fa-check-circle me-2"></i>You're on Team {{ $userTeam->name }}!</h6>
                                <p class="mb-2">
                                    Team created on {{ $userTeam->created_at->format('M j, Y') }}
                                    <br>Team Members: {{ $userTeam->members->pluck('name')->join(', ') }}
                                </p>
                                @if($tournament->status !== 'upcoming')
                                    <a href="{{ route('teams.show', $userTeam) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-users me-1"></i>View Team
                                    </a>
                                    @if($tournament->status === 'active')
                                        <a href="{{ route('scores.team', $userTeam) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-edit me-1"></i>Enter Team Scores
                                        </a>
                                    @endif
                                @endif
                            </div>
                        @elseif(!$tournament->hasSpaceAvailable())
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Tournament Full</h6>
                                <p class="mb-0">This tournament has reached its maximum capacity.</p>
                            </div>
                        @elseif(!$tournament->isUpcoming())
                            <div class="alert alert-secondary">
                                <h6><i class="fas fa-lock me-2"></i>Registration Closed</h6>
                                <p class="mb-0">Registration for this tournament is no longer available.</p>
                            </div>
                        @endif
                    @else
                        @if(!$userEntry && $tournament->isUpcoming() && $tournament->hasSpaceAvailable())
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle me-2"></i>Registration Open</h6>
                                <p class="mb-0">You can register for this individual tournament.</p>
                            </div>
                        @elseif($userEntry)
                            <div class="alert alert-success">
                                <h6><i class="fas fa-check-circle me-2"></i>You're Registered!</h6>
                                <p class="mb-2">
                                    Registered on {{ $userEntry->registered_at->format('M j, Y') }}
                                    @if($userEntry->handicap)
                                        with handicap {{ $userEntry->handicap }}
                                    @endif
                                </p>
                                @if($tournament->status !== 'upcoming')
                                    <a href="{{ route('scores.show', $userEntry) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-clipboard-list me-1"></i>View Scorecard
                                    </a>
                                    @if($tournament->status === 'active')
                                        <a href="{{ route('scores.edit', $userEntry) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-edit me-1"></i>Enter Scores
                                        </a>
                                    @endif
                                @endif
                            </div>
                        @elseif(!$tournament->hasSpaceAvailable())
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Tournament Full</h6>
                                <p class="mb-0">This tournament has reached its maximum capacity.</p>
                            </div>
                        @elseif(!$tournament->isUpcoming())
                            <div class="alert alert-secondary">
                                <h6><i class="fas fa-lock me-2"></i>Registration Closed</h6>
                                <p class="mb-0">Registration for this tournament is no longer available.</p>
                            </div>
                        @endif
                    @endif
                @else
                    <div class="alert alert-info">
                        <h6><i class="fas fa-sign-in-alt me-2"></i>Login Required</h6>
                        <p class="mb-0">
                            <a href="{{ route('login') }}">Login</a> or 
                            <a href="{{ route('register') }}">register</a> to participate in this tournament.
                        </p>
                    </div>
                @endauth

                @if($tournament->status !== 'upcoming')
                    <div class="mt-4">
                        {{-- Leaderboard Buttons --}}
                        <div class="mb-3">
                            @if($tournament->format === 'scramble')
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tournaments.team-leaderboard', $tournament) }}" class="btn btn-success">
                                        <i class="fas fa-users me-2"></i>Team Leaderboard
                                    </a>
                                    <a href="{{ route('tournaments.leaderboard', $tournament) }}" class="btn btn-outline-success">
                                        <i class="fas fa-user me-2"></i>Individual
                                    </a>
                                </div>
                            @else
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tournaments.leaderboard', $tournament) }}" class="btn btn-success">
                                        <i class="fas fa-list-ol me-2"></i>View Leaderboard
                                    </a>
                                    <a href="{{ route('tournaments.team-leaderboard', $tournament) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-table me-2"></i>Hole by Hole
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Print & Utility Buttons --}}
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-info" 
                                    data-bs-toggle="modal" data-bs-target="#setupCardsModal">
                                <i class="fas fa-cogs me-2"></i>Setup Cards
                            </button>
                        @if($tournament->entries->count() > 0 || $tournament->teams->count() > 0)
                                <a href="{{ route('tournaments.combined-scorecard', $tournament) }}" 
                                   target="_blank" class="btn btn-outline-success">
                                    <i class="fas fa-table me-2"></i>Combined Scorecard
                                </a>
                                <a href="{{ route('tournaments.print-all-scorecards', $tournament) }}?print=1" 
                                   target="_blank" class="btn btn-outline-primary">
                                    <i class="fas fa-print me-2"></i>Print Individual Cards
                                </a>
                                <button type="button" class="btn btn-outline-secondary" 
                                        data-bs-toggle="modal" data-bs-target="#qrCodesModal">
                                    <i class="fas fa-qrcode me-2"></i>Show QR Codes
                                </button>
                            </div>
                        @endif
                    </div>
                @endif

                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="mt-4">
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-user-shield me-2"></i>Administrator Controls</h6>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tournaments.edit', $tournament) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit Tournament
                                    </a>
                                    <form method="POST" action="{{ route('tournaments.destroy', $tournament) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Are you sure you want to delete this tournament? This action cannot be undone.')">
                                            <i class="fas fa-trash me-1"></i>Delete Tournament
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @auth
            @if($tournament->format === 'scramble')
                @if(!$userTeam && $tournament->isUpcoming() && $tournament->hasSpaceAvailable())
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Team Registration</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">This is a {{ $tournament->team_size }}-player scramble tournament.</p>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('tournaments.teams.create', $tournament) }}" class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i>Create New Team
                                </a>
                                
                                @php
                                    $availableTeams = $tournament->teams()
                                        ->whereHas('members', function($query) use ($tournament) {
                                            $query->havingRaw('COUNT(*) < ?', [$tournament->team_size]);
                                        })
                                        ->get();
                                @endphp
                                
                                @if($availableTeams->count() > 0)
                                    <hr class="my-3">
                                    <h6 class="mb-2">Join Existing Team</h6>
                                    @foreach($availableTeams as $team)
                                        <div class="border rounded p-2 mb-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $team->name }}</strong>
                                                    <br><small class="text-muted">{{ $team->members->count() }}/{{ $tournament->team_size }} players</small>
                                                </div>
                                                <form method="POST" action="{{ route('teams.join', $team) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                                        <i class="fas fa-user-plus me-1"></i>Join
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($userTeam && $tournament->isUpcoming())
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Team Management</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Team:</strong> {{ $userTeam->name }}</p>
                            <p><strong>Members:</strong> {{ $userTeam->members->count() }}/{{ $tournament->team_size }}</p>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('teams.show', $userTeam) }}" class="btn btn-primary">
                                    <i class="fas fa-eye me-2"></i>View Team
                                </a>
                                
                                @if($userTeam->captain_id === Auth::id())
                                    <a href="{{ route('teams.edit', $userTeam) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit me-2"></i>Manage Team
                                    </a>
                                @endif
                                
                                <form method="POST" action="{{ route('teams.leave', $userTeam) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" 
                                            onclick="return confirm('Are you sure you want to leave this team?')">
                                        <i class="fas fa-times me-2"></i>Leave Team
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                @if(!$userEntry && $tournament->isUpcoming() && $tournament->hasSpaceAvailable())
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Register</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tournaments.register', $tournament) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="handicap" class="form-label">Handicap (optional)</label>
                                    <input type="number" class="form-control" id="handicap" name="handicap" 
                                           value="{{ Auth::user()->handicap }}" min="0" max="54">
                                    <div class="form-text">Your current handicap</div>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-golf-ball me-2"></i>Register for Tournament
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif($userEntry && $tournament->isUpcoming())
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-user-minus me-2"></i>Withdraw</h5>
                        </div>
                        <div class="card-body">
                            <p>You are registered for this tournament.</p>
                            <form method="POST" action="{{ route('tournaments.withdraw', $tournament) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100" 
                                        onclick="return confirm('Are you sure you want to withdraw from this tournament?')">
                                    <i class="fas fa-times me-2"></i>Withdraw
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endif
        @endauth

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    {{ $tournament->format === 'scramble' ? 'Teams' : 'Participants' }}
                </h5>
            </div>
            <div class="card-body">
                @if($tournament->format === 'scramble')
                    @if($tournament->teams->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($tournament->teams as $team)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $team->name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                Captain: {{ $team->captain->name }}
                                            </small>
                                            <br>
                                            <small class="text-muted">
                                                Members: {{ $team->members->pluck('name')->join(', ') }}
                                            </small>
                                        </div>
                                        <span class="badge bg-primary">
                                            {{ $team->members->count() }}/{{ $tournament->team_size }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No teams registered yet.</p>
                    @endif
                @else
                    @if($tournament->entries->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($tournament->entries as $entry)
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <strong>{{ $entry->user->name }}</strong>
                                        @if($entry->handicap)
                                            <br><small class="text-muted">Handicap: {{ $entry->handicap }}</small>
                                        @endif
                                        @if($entry->starting_hole)
                                            <br><small class="text-info">
                                                <i class="fas fa-flag me-1"></i>Hole {{ $entry->starting_hole }}{{ $entry->group_letter }}
                                                @if($entry->card_order)
                                                    (Card {{ $entry->card_order }})
                                                @endif
                                            </small>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($entry->starting_hole)
                                            <span class="badge bg-info">{{ $entry->starting_hole }}{{ $entry->group_letter }}</span>
                                        @endif
                                        @if($entry->checked_in)
                                            <span class="badge bg-success">Checked In</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No participants yet.</p>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Setup Cards Modal --}}
<div class="modal fade" id="setupCardsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-cogs me-2"></i>Setup Card Assignments
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tournaments.assign-cards', $tournament) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Assign teams/players to starting holes and groups. Use A/B groups to send multiple teams from the same hole.
                            </p>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Player/Team</th>
                                    <th>Starting Hole</th>
                                    <th>Group</th>
                                    <th>Card Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tournament->entries as $entry)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="assignments[{{ $loop->index }}][entry_id]" value="{{ $entry->id }}">
                                            <strong>{{ $entry->user->name }}</strong>
                                            @if($entry->team)
                                                <br><small class="text-muted">Team: {{ $entry->team->name }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <select name="assignments[{{ $loop->index }}][starting_hole]" 
                                                    class="form-select form-select-sm" required>
                                                <option value="">Select Hole</option>
                                                @for($hole = 1; $hole <= 18; $hole++)
                                                    <option value="{{ $hole }}" 
                                                        {{ $entry->starting_hole == $hole ? 'selected' : '' }}>
                                                        Hole {{ $hole }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td>
                                            <select name="assignments[{{ $loop->index }}][group_letter]" 
                                                    class="form-select form-select-sm" required>
                                                <option value="">Select Group</option>
                                                <option value="A" {{ $entry->group_letter == 'A' ? 'selected' : '' }}>A</option>
                                                <option value="B" {{ $entry->group_letter == 'B' ? 'selected' : '' }}>B</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" 
                                                   name="assignments[{{ $loop->index }}][card_order]" 
                                                   class="form-control form-control-sm" 
                                                   value="{{ $entry->card_order }}"
                                                   min="1" max="20" 
                                                   placeholder="Order">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <strong>Quick Assignment Tools:</strong>
                                <div class="btn-group ms-2" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="autoAssignCards()">
                                        Auto Assign Cards
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearAssignments()">
                                        Clear All
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Assignments
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- QR Codes Modal --}}
<div class="modal fade" id="qrCodesModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-qrcode me-2"></i>QR Codes for Mobile Scoring
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach($tournament->entries as $entry)
                        <div class="col-md-4 col-sm-6 mb-4 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $entry->user->name }}</h6>
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('scores.mobile', $entry)) }}" 
                                         alt="QR Code for {{ $entry->user->name }}" 
                                         class="img-fluid mb-2">
                                    <p class="small text-muted">Scan to enter scores</p>
                                    <a href="{{ route('scores.mobile', $entry) }}" 
                                       class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="fas fa-mobile-alt me-1"></i>Open Mobile Scoring
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Print QR Codes
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function autoAssignCards() {
    const rows = document.querySelectorAll('#setupCardsModal tbody tr');
    let currentHole = 1;
    let currentGroup = 'A';
    let playersPerHole = 0;
    const maxPlayersPerHole = 8; // 4 players per group, 2 groups max
    
    rows.forEach((row, index) => {
        // Set starting hole
        const holeSelect = row.querySelector('select[name*="[starting_hole]"]');
        holeSelect.value = currentHole;
        
        // Set group
        const groupSelect = row.querySelector('select[name*="[group_letter]"]');
        groupSelect.value = currentGroup;
        
        // Set card order
        const orderInput = row.querySelector('input[name*="[card_order]"]');
        orderInput.value = Math.floor(playersPerHole / 4) + 1;
        
        playersPerHole++;
        
        // Switch to group B after 4 players
        if (playersPerHole === 4 && currentGroup === 'A') {
            currentGroup = 'B';
        }
        
        // Move to next hole after maxPlayersPerHole
        if (playersPerHole >= maxPlayersPerHole) {
            currentHole = currentHole === 18 ? 1 : currentHole + 1;
            currentGroup = 'A';
            playersPerHole = 0;
        }
    });
    
    alert('Cards auto-assigned successfully! Review and save changes.');
}

function clearAssignments() {
    if (!confirm('Clear all card assignments?')) return;
    
    const rows = document.querySelectorAll('#setupCardsModal tbody tr');
    rows.forEach(row => {
        row.querySelector('select[name*="[starting_hole]"]').value = '';
        row.querySelector('select[name*="[group_letter]"]').value = '';
        row.querySelector('input[name*="[card_order]"]').value = '';
    });
}
</script>
@endpush

@endsection