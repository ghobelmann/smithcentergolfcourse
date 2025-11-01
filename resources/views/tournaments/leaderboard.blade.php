@extends('layouts.tournament')

@section('title', 'Leaderboard - ' . $tournament->name)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-list-ol me-2"></i>
                        Leaderboard - {{ $tournament->name }}
                    </h4>
                    <div>
                        @if($tournament->format === 'scramble')
                            <a href="{{ route('tournaments.team-leaderboard', $tournament) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-table me-2"></i>Hole by Hole
                            </a>
                        @else
                            <a href="{{ route('tournaments.team-leaderboard', $tournament) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-table me-2"></i>Hole by Hole
                            </a>
                        @endif
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="printScorecards()">
                            <i class="fas fa-print me-2"></i>Print Scorecards
                        </button>
                        <a href="{{ route('tournaments.show', $tournament) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Tournament
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <h6><i class="fas fa-calendar me-2"></i>Tournament Dates</h6>
                        <p class="mb-0">{{ $tournament->start_date->format('M j, Y') }} - {{ $tournament->end_date->format('M j, Y') }}</p>
                    </div>
                    <div class="col-md-3">
                        <h6><i class="fas fa-users me-2"></i>Participants</h6>
                        <p class="mb-0">{{ $entries->count() }} players</p>
                    </div>
                    <div class="col-md-3">
                        <h6><i class="fas fa-golf-ball me-2"></i>Course</h6>
                        <p class="mb-0">{{ $tournament->holes }} holes</p>
                    </div>
                    <div class="col-md-3">
                        <h6><i class="fas fa-trophy me-2"></i>Status</h6>
                        <p class="mb-0">
                            @if($tournament->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($tournament->status === 'completed')
                                <span class="badge bg-secondary">Completed</span>
                            @else
                                <span class="badge bg-primary">Upcoming</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($entries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>Position</th>
                                    <th>Player</th>
                                    <th>Handicap</th>
                                    <th>Holes Completed</th>
                                    <th>Total Score</th>
                                    <th>Vs Par</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($entriesWithFlights) && count($entriesWithFlights) > 1)
                                    {{-- Display with flight separators --}}
                                    @php $overallPosition = 1; @endphp
                                    @foreach($entriesWithFlights as $flightNumber => $flightEntries)
                                        {{-- Flight Header --}}
                                        <tr class="table-primary">
                                            <td colspan="7" class="text-center fw-bold py-3">
                                                <i class="fas fa-flag me-2"></i>Flight {{ $flightNumber }}
                                                <span class="badge bg-primary ms-2">{{ count($flightEntries) }} {{ count($flightEntries) == 1 ? 'Player' : 'Players' }}</span>
                                            </td>
                                        </tr>
                                        
                                        {{-- Flight Entries --}}
                                        @php $flightPosition = 1; $lastScore = null; $displayPosition = 1; @endphp
                                        @foreach($flightEntries as $entry)
                                            @php
                                                $entry = (object) $entry; // Ensure it's an object
                                                if ($lastScore !== null && $entry->total_score !== $lastScore) {
                                                    $displayPosition = $flightPosition;
                                                }
                                                $lastScore = $entry->total_score;
                                            @endphp
                                            <tr>
                                                <td>
                                                    @if($entry->completed_holes > 0)
                                                        <div class="d-flex align-items-center">
                                                            <small class="text-muted me-2">#{{ $overallPosition }}</small>
                                                            <strong class="
                                                            @if($displayPosition == 1 && $flightNumber == 1) text-warning
                                                            @elseif($displayPosition == 1) text-info
                                                            @elseif($displayPosition == 2) text-secondary
                                                            @elseif($displayPosition == 3) text-danger
                                                            @endif
                                                            ">
                                                                @if($displayPosition == 1 && $flightNumber == 1)
                                                                    <i class="fas fa-crown me-1"></i>
                                                                @elseif($displayPosition == 1)
                                                                    <i class="fas fa-medal me-1"></i>
                                                                @endif
                                                                {{ $displayPosition }}
                                                            </strong>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $entry->user->name ?? 'Unknown' }}</strong>
                                                    @if($entry->user->home_course ?? null)
                                                        <br><small class="text-muted">{{ $entry->user->home_course }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($entry->handicap ?? null)
                                                        <span class="badge bg-info">{{ $entry->handicap }}</span>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">{{ $entry->completed_holes }} / {{ $tournament->holes }}</span>
                                                        <div class="progress flex-grow-1" style="height: 8px; width: 60px;">
                                                            <div class="progress-bar" style="width: {{ $tournament->holes > 0 ? ($entry->completed_holes / $tournament->holes) * 100 : 0 }}%"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($entry->completed_holes > 0)
                                                        <strong>{{ $entry->total_score }}</strong>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($entry->completed_holes > 0)
                                                        @if($entry->score_vs_par > 0)
                                                            <span class="badge bg-danger">+{{ $entry->score_vs_par }}</span>
                                                        @elseif($entry->score_vs_par < 0)
                                                            <span class="badge bg-success">{{ $entry->score_vs_par }}</span>
                                                        @else
                                                            <span class="badge bg-primary">Even</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($entry->completed_holes > 0)
                                                        <a href="{{ route('scores.show', $entry->id ?? $entry) }}" class="btn btn-sm btn-outline-primary" title="View Scorecard">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif
                                                    @if(Auth::check() && Auth::id() === ($entry->user_id ?? $entry->user->id ?? null) && $tournament->status === 'active')
                                                        <a href="{{ route('scores.edit', $entry->id ?? $entry) }}" class="btn btn-sm btn-outline-success" title="Enter Scores">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php 
                                                $flightPosition++; 
                                                $overallPosition++; 
                                            @endphp
                                        @endforeach
                                        
                                        {{-- Add red separator line after each flight (except the last one) --}}
                                        @if($flightNumber < count($entriesWithFlights))
                                            <tr>
                                                <td colspan="7" class="p-0">
                                                    <div style="height: 3px; background: linear-gradient(90deg, #dc3545 0%, #dc3545 100%); margin: 8px 0;"></div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    {{-- Display without flights (original logic) --}}
                                    @php $position = 1; $lastScore = null; $displayPosition = 1; @endphp
                                    @foreach($entries as $entry)
                                    @php
                                        if ($lastScore !== null && $entry->total_score !== $lastScore) {
                                            $displayPosition = $position;
                                        }
                                        $lastScore = $entry->total_score;
                                    @endphp
                                    <tr>
                                        <td>
                                            @if($entry->completed_holes > 0)
                                                <strong class="
                                                @if($displayPosition == 1) text-warning
                                                @elseif($displayPosition == 2) text-secondary
                                                @elseif($displayPosition == 3) text-danger
                                                @endif
                                                ">
                                                    @if($displayPosition == 1)
                                                        <i class="fas fa-crown me-1"></i>
                                                    @endif
                                                    {{ $displayPosition }}
                                                </strong>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $entry->user->name }}</strong>
                                            @if($entry->user->home_course)
                                                <br><small class="text-muted">{{ $entry->user->home_course }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($entry->handicap)
                                                <span class="badge bg-info">{{ $entry->handicap }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="me-2">{{ $entry->completed_holes }} / {{ $tournament->holes }}</span>
                                                <div class="progress flex-grow-1" style="height: 8px; width: 60px;">
                                                    <div class="progress-bar" style="width: {{ $tournament->holes > 0 ? ($entry->completed_holes / $tournament->holes) * 100 : 0 }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($entry->completed_holes > 0)
                                                <strong>{{ $entry->total_score }}</strong>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($entry->completed_holes > 0)
                                                @if($entry->score_vs_par > 0)
                                                    <span class="badge bg-danger">+{{ $entry->score_vs_par }}</span>
                                                @elseif($entry->score_vs_par < 0)
                                                    <span class="badge bg-success">{{ $entry->score_vs_par }}</span>
                                                @else
                                                    <span class="badge bg-primary">Even</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($entry->completed_holes > 0)
                                                <a href="{{ route('scores.show', $entry) }}" class="btn btn-sm btn-outline-primary" title="View Scorecard">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            @if(Auth::check() && Auth::id() === $entry->user_id && $tournament->status === 'active')
                                                <a href="{{ route('scores.edit', $entry) }}" class="btn btn-sm btn-outline-success" title="Enter Scores">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @php $position++; @endphp
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if($entries->where('completed_holes', '>', 0)->count() === 0)
                        <div class="text-center py-4">
                            <i class="fas fa-golf-ball fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No scores entered yet</h5>
                            <p class="text-muted">Scores will appear here as players complete their rounds.</p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No participants registered</h5>
                        <p class="text-muted">The leaderboard will appear once players register for this tournament.</p>
                    </div>
                @endif
            </div>
        </div>

        @if($tournament->status === 'completed' && $entries->where('completed_holes', '>', 0)->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-medal me-2"></i>Tournament Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php 
                            $completedEntries = $entries->where('completed_holes', '>', 0);
                            $winner = $completedEntries->first();
                            $averageScore = $completedEntries->avg('total_score');
                            $bestScore = $completedEntries->min('total_score');
                            $worstScore = $completedEntries->max('total_score');
                        @endphp
                        
                        @if($winner)
                            <div class="col-md-3">
                                <h6><i class="fas fa-crown text-warning me-2"></i>Winner</h6>
                                <p class="mb-0">{{ $winner->user->name }}</p>
                                <small class="text-muted">{{ $winner->total_score }} strokes</small>
                            </div>
                        @endif
                        
                        <div class="col-md-3">
                            <h6><i class="fas fa-chart-line me-2"></i>Best Score</h6>
                            <p class="mb-0">{{ $bestScore }} strokes</p>
                        </div>
                        
                        <div class="col-md-3">
                            <h6><i class="fas fa-calculator me-2"></i>Average Score</h6>
                            <p class="mb-0">{{ number_format($averageScore, 1) }} strokes</p>
                        </div>
                        
                        <div class="col-md-3">
                            <h6><i class="fas fa-users me-2"></i>Completed Rounds</h6>
                            <p class="mb-0">{{ $completedEntries->count() }} / {{ $entries->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function printScorecards() {
    const entries = @json($entries->pluck('id'));
    
    if (entries.length === 0) {
        alert('No entries found to print scorecards for.');
        return;
    }
    
    if (confirm(`This will open ${entries.length} scorecard(s) for printing. Continue?`)) {
        entries.forEach((entryId, index) => {
            setTimeout(() => {
                const printUrl = `/entries/${entryId}/scorecard/print?print=1`;
                window.open(printUrl, `scorecard_${entryId}`, 'width=800,height=600');
            }, index * 100);
        });
    }
}
</script>
@endpush

@endsection