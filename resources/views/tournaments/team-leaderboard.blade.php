@extends('layouts.tournament')

@section('title', 'Team Leaderboard - ' . $tournament->name)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-users me-2"></i>
                        Team Leaderboard - {{ $tournament->name }}
                    </h4>
                    <div>
                        <a href="{{ route('tournaments.leaderboard', $tournament) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-user me-2"></i>Individual View
                        </a>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="printTeamScorecards()">
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
                        <p>{{ $tournament->start_date->format('M j, Y') }} - {{ $tournament->end_date->format('M j, Y') }}</p>
                    </div>
                    <div class="col-md-3">
                        <h6><i class="fas fa-golf-ball me-2"></i>Format</h6>
                        <p>{{ ucfirst($tournament->format) }} ({{ $tournament->team_size }} players)</p>
                    </div>
                    <div class="col-md-3">
                        <h6><i class="fas fa-flag me-2"></i>Status</h6>
                        <p>
                            @if($tournament->status === 'upcoming')
                                <span class="badge bg-primary">Upcoming</span>
                            @elseif($tournament->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Completed</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-3">
                        <h6><i class="fas fa-users me-2"></i>Teams</h6>
                        <p>{{ $teams->count() }} registered</p>
                    </div>
                </div>

                @if($teams->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" style="font-size: 0.9rem;">
                            <thead class="table-success">
                                <tr>
                                    <th rowspan="2" class="align-middle text-center" style="min-width: 50px;">Pos</th>
                                    <th rowspan="2" class="align-middle" style="min-width: 150px;">Team</th>
                                    
                                    @if($tournament->holes >= 9)
                                        <th colspan="{{ min(9, $tournament->holes) }}" class="text-center bg-info text-white">Front 9</th>
                                        <th rowspan="2" class="align-middle text-center bg-info text-white" style="min-width: 60px;">F9 Total</th>
                                    @endif
                                    
                                    @if($tournament->holes > 9)
                                        <th colspan="{{ $tournament->holes - 9 }}" class="text-center bg-warning text-dark">Back 9</th>
                                        <th rowspan="2" class="align-middle text-center bg-warning text-dark" style="min-width: 60px;">B9 Total</th>
                                    @endif
                                    
                                    <th rowspan="2" class="align-middle text-center bg-success text-white" style="min-width: 80px;">18 Total</th>
                                    <th rowspan="2" class="align-middle text-center bg-success text-white" style="min-width: 70px;">vs Par</th>
                                </tr>
                                <tr>
                                    @if($tournament->holes >= 9)
                                        @for($hole = 1; $hole <= min(9, $tournament->holes); $hole++)
                                            <th class="text-center bg-info text-white" style="min-width: 40px;">{{ $hole }}</th>
                                        @endfor
                                    @endif
                                    
                                    @if($tournament->holes > 9)
                                        @for($hole = 10; $hole <= $tournament->holes; $hole++)
                                            <th class="text-center bg-warning text-dark" style="min-width: 40px;">{{ $hole }}</th>
                                        @endfor
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($teamsWithFlights) && count($teamsWithFlights) > 1)
                                    {{-- Display with flight separators --}}
                                    @php $overallPosition = 1; @endphp
                                    @foreach($teamsWithFlights as $flightNumber => $flightTeams)
                                        {{-- Flight Header --}}
                                        <tr class="table-primary">
                                            <td colspan="{{ $tournament->holes + 5 }}" class="text-center fw-bold py-3">
                                                <i class="fas fa-flag me-2"></i>Flight {{ $flightNumber }}
                                                <span class="badge bg-primary ms-2">{{ count($flightTeams) }} {{ count($flightTeams) == 1 ? 'Team' : 'Teams' }}</span>
                                            </td>
                                        </tr>
                                        
                                        {{-- Flight Teams --}}
                                        @php $flightPosition = 1; $lastScore = null; $displayPosition = 1; @endphp
                                        @foreach($flightTeams as $team)
                                            @php
                                                $team = (object) $team; // Ensure it's an object
                                                if ($lastScore !== null && $team->total_score !== $lastScore) {
                                                    $displayPosition = $flightPosition;
                                                }
                                                $lastScore = $team->total_score;
                                            @endphp
                                    <tr>
                                        <td class="text-center align-middle">
                                            @if($displayPosition <= 3 && $team->completed_holes > 0)
                                                <span class="badge bg-warning text-dark">{{ $displayPosition }}</span>
                                            @else
                                                {{ $displayPosition }}
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <div>
                                                <strong>{{ $team->name }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $team->members->pluck('user.name')->take(2)->join(', ') }}
                                                    @if($team->members->count() > 2)
                                                        + {{ $team->members->count() - 2 }} more
                                                    @endif
                                                </small>
                                            </div>
                                        </td>
                                        
                                        {{-- Front 9 Holes --}}
                                        @if($tournament->holes >= 9)
                                            @for($hole = 1; $hole <= min(9, $tournament->holes); $hole++)
                                                <td class="text-center align-middle">
                                                    @if(isset($team->scoresByHole[$hole]))
                                                        @php
                                                            $score = $team->scoresByHole[$hole];
                                                            $diff = $score->strokes - $score->par;
                                                        @endphp
                                                        <span class="
                                                            @if($diff <= -2) text-success fw-bold
                                                            @elseif($diff == -1) text-primary fw-bold
                                                            @elseif($diff == 0) text-dark
                                                            @elseif($diff == 1) text-warning fw-bold
                                                            @else text-danger fw-bold
                                                            @endif
                                                        ">
                                                            {{ $score->strokes }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endfor
                                            
                                            {{-- Front 9 Total --}}
                                            <td class="text-center align-middle bg-light fw-bold">
                                                @if($team->front9_score > 0)
                                                    {{ $team->front9_score }}
                                                    @if($team->front9_par > 0)
                                                        <br>
                                                        <small class="text-muted">
                                                            @php $f9_diff = $team->front9_score - $team->front9_par; @endphp
                                                            @if($f9_diff > 0)+@endif{{ $f9_diff }}
                                                        </small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endif
                                        
                                        {{-- Back 9 Holes --}}
                                        @if($tournament->holes > 9)
                                            @for($hole = 10; $hole <= $tournament->holes; $hole++)
                                                <td class="text-center align-middle">
                                                    @if(isset($team->scoresByHole[$hole]))
                                                        @php
                                                            $score = $team->scoresByHole[$hole];
                                                            $diff = $score->strokes - $score->par;
                                                        @endphp
                                                        <span class="
                                                            @if($diff <= -2) text-success fw-bold
                                                            @elseif($diff == -1) text-primary fw-bold
                                                            @elseif($diff == 0) text-dark
                                                            @elseif($diff == 1) text-warning fw-bold
                                                            @else text-danger fw-bold
                                                            @endif
                                                        ">
                                                            {{ $score->strokes }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endfor
                                            
                                            {{-- Back 9 Total --}}
                                            <td class="text-center align-middle bg-light fw-bold">
                                                @if($team->back9_score > 0)
                                                    {{ $team->back9_score }}
                                                    @if($team->back9_par > 0)
                                                        <br>
                                                        <small class="text-muted">
                                                            @php $b9_diff = $team->back9_score - $team->back9_par; @endphp
                                                            @if($b9_diff > 0)+@endif{{ $b9_diff }}
                                                        </small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endif
                                        
                                        {{-- 18 Hole Total --}}
                                        <td class="text-center align-middle bg-success text-white fw-bold">
                                            @if($team->completed_holes > 0)
                                                {{ $team->total_score }}
                                                <br>
                                                <small>{{ $team->completed_holes }}/{{ $tournament->holes }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        
                                        {{-- vs Par --}}
                                        <td class="text-center align-middle bg-success text-white fw-bold">
                                            @if($team->completed_holes > 0)
                                                @if($team->score_vs_par > 0)
                                                    <span class="badge bg-danger">+{{ $team->score_vs_par }}</span>
                                                @elseif($team->score_vs_par < 0)
                                                    <span class="badge bg-success">{{ $team->score_vs_par }}</span>
                                                @else
                                                    <span class="badge bg-primary">Even</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                            @php $flightPosition++; $overallPosition++; @endphp
                                        @endforeach
                                        
                                        {{-- Add red separator line after each flight (except the last one) --}}
                                        @if($flightNumber < count($teamsWithFlights))
                                            <tr>
                                                <td colspan="{{ $tournament->holes + 5 }}" class="p-0">
                                                    <div style="height: 3px; background: linear-gradient(90deg, #dc3545 0%, #dc3545 100%); margin: 8px 0;"></div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    {{-- Display without flight separators --}}
                                    @php $position = 1; $lastScore = null; $displayPosition = 1; @endphp
                                    @foreach($teams as $team)
                                        @php
                                            if ($lastScore !== null && $team->total_score !== $lastScore) {
                                                $displayPosition = $position;
                                            }
                                            $lastScore = $team->total_score;
                                        @endphp
                                        <tr>
                                            <td class="text-center align-middle">
                                                @if($displayPosition <= 3 && $team->completed_holes > 0)
                                                    <span class="badge bg-warning text-dark">{{ $displayPosition }}</span>
                                                @else
                                                    {{ $displayPosition }}
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div>
                                                    <strong>{{ $team->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ $team->members->pluck('user.name')->take(2)->join(', ') }}
                                                        @if($team->members->count() > 2)
                                                            + {{ $team->members->count() - 2 }} more
                                                        @endif
                                                    </small>
                                                </div>
                                            </td>
                                            
                                            {{-- Front 9 Holes --}}
                                            @if($tournament->holes >= 9)
                                                @for($hole = 1; $hole <= min(9, $tournament->holes); $hole++)
                                                    <td class="text-center align-middle">
                                                        @if(isset($team->scoresByHole[$hole]))
                                                            @php
                                                                $score = $team->scoresByHole[$hole];
                                                                $diff = $score->strokes - $score->par;
                                                            @endphp
                                                            <span class="
                                                                @if($diff <= -2) text-success fw-bold
                                                                @elseif($diff == -1) text-primary fw-bold
                                                                @elseif($diff == 0) text-dark
                                                                @elseif($diff == 1) text-warning fw-bold
                                                                @else text-danger fw-bold
                                                                @endif
                                                            ">
                                                                {{ $score->strokes }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                @endfor
                                                
                                                {{-- Front 9 Total --}}
                                                <td class="text-center align-middle bg-light fw-bold">
                                                    @if($team->front9_score > 0)
                                                        {{ $team->front9_score }}
                                                        @if($team->front9_par > 0)
                                                            <br>
                                                            <small class="text-muted">
                                                                {{ $team->front9_score - $team->front9_par >= 0 ? '+' : '' }}{{ $team->front9_score - $team->front9_par }}
                                                            </small>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endif
                                            
                                            {{-- Back 9 Holes --}}
                                            @if($tournament->holes > 9)
                                                @for($hole = 10; $hole <= $tournament->holes; $hole++)
                                                    <td class="text-center align-middle">
                                                        @if(isset($team->scoresByHole[$hole]))
                                                            @php
                                                                $score = $team->scoresByHole[$hole];
                                                                $diff = $score->strokes - $score->par;
                                                            @endphp
                                                            <span class="
                                                                @if($diff <= -2) text-success fw-bold
                                                                @elseif($diff == -1) text-primary fw-bold
                                                                @elseif($diff == 0) text-dark
                                                                @elseif($diff == 1) text-warning fw-bold
                                                                @else text-danger fw-bold
                                                                @endif
                                                            ">
                                                                {{ $score->strokes }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                @endfor
                                                
                                                {{-- Back 9 Total --}}
                                                <td class="text-center align-middle bg-light fw-bold">
                                                    @if($team->back9_score > 0)
                                                        {{ $team->back9_score }}
                                                        @if($team->back9_par > 0)
                                                            <br>
                                                            <small class="text-muted">
                                                                {{ $team->back9_score - $team->back9_par >= 0 ? '+' : '' }}{{ $team->back9_score - $team->back9_par }}
                                                            </small>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endif
                                            
                                            {{-- Total Score --}}
                                            <td class="text-center align-middle bg-success text-white fw-bold">
                                                @if($team->completed_holes > 0)
                                                    {{ $team->total_score }}
                                                    <br>
                                                    <small>{{ $team->completed_holes }}/{{ $tournament->holes }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            
                                            {{-- Vs Par --}}
                                            <td class="text-center align-middle bg-success text-white fw-bold">
                                                @if($team->completed_holes > 0)
                                                    @if($team->score_vs_par == 0)
                                                        <span class="badge bg-primary">Even</span>
                                                    @elseif($team->score_vs_par < 0)
                                                        <span class="badge bg-success">{{ $team->score_vs_par }}</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">+{{ $team->score_vs_par }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @php $position++; @endphp
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if($teams->where('completed_holes', '>', 0)->count() === 0)
                        <div class="text-center py-4">
                            <i class="fas fa-golf-ball fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No scores entered yet</h5>
                            <p class="text-muted">Team scores will appear here as teams complete their rounds.</p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No teams registered</h5>
                        <p class="text-muted">The team leaderboard will appear once teams register for this tournament.</p>
                    </div>
                @endif
            </div>
        </div>

        @if($tournament->status === 'completed' && $teams->where('completed_holes', '>', 0)->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Tournament Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php 
                            $completedTeams = $teams->where('completed_holes', '>', 0);
                            $winner = $completedTeams->first();
                            $averageScore = $completedTeams->avg('total_score');
                            $bestScore = $completedTeams->min('total_score');
                        @endphp
                        
                        @if($winner)
                            <div class="col-md-3">
                                <h6><i class="fas fa-crown text-warning me-2"></i>Winning Team</h6>
                                <p class="mb-0">{{ $winner->name }}</p>
                                <small class="text-muted">{{ $winner->total_score }} strokes</small>
                            </div>
                        @endif
                        
                        <div class="col-md-3">
                            <h6><i class="fas fa-chart-line me-2"></i>Best Team Score</h6>
                            <p class="mb-0">{{ $bestScore }} strokes</p>
                        </div>
                        
                        <div class="col-md-3">
                            <h6><i class="fas fa-calculator me-2"></i>Average Team Score</h6>
                            <p class="mb-0">{{ number_format($averageScore, 1) }} strokes</p>
                        </div>
                        
                        <div class="col-md-3">
                            <h6><i class="fas fa-users me-2"></i>Teams Completed</h6>
                            <p class="mb-0">{{ $completedTeams->count() }} / {{ $teams->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .table th, .table td {
        padding: 0.5rem 0.25rem;
        vertical-align: middle;
    }
    
    .table th {
        border-bottom: 2px solid #dee2e6;
    }
    
    .table-responsive {
        border-radius: 0.375rem;
    }
    
    /* Color coding for scores */
    .text-success { color: #198754 !important; } /* Eagle or better */
    .text-primary { color: #0d6efd !important; } /* Birdie */
    .text-warning { color: #fd7e14 !important; } /* Bogey */
    .text-danger { color: #dc3545 !important; } /* Double bogey or worse */
</style>
@endpush

@push('scripts')
<script>
function printTeamScorecards() {
    // For team tournaments, we need to get all individual entries
    // Teams display team scores, but scorecards are still individual
    @if($tournament->format === 'scramble')
        // Get all team members' tournament entries
        const teamEntries = @json($tournament->entries->pluck('id'));
    @else
        // Get all individual entries
        const teamEntries = @json($tournament->entries->pluck('id'));
    @endif
    
    if (teamEntries.length === 0) {
        alert('No entries found to print scorecards for.');
        return;
    }
    
    if (confirm(`This will open ${teamEntries.length} scorecard(s) for printing. Continue?`)) {
        teamEntries.forEach((entryId, index) => {
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