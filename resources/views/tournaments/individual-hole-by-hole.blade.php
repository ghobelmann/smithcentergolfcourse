@extends('layouts.tournament')

@section('title', 'Hole by Hole Leaderboard - ' . $tournament->name)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-table me-2"></i>
                        Hole by Hole - {{ $tournament->name }}
                    </h4>
                    <div>
                        <a href="{{ route('tournaments.leaderboard', $tournament) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-list-ol me-2"></i>Summary View
                        </a>
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
                        <p>{{ ucfirst($tournament->format) }}</p>
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
                        <h6><i class="fas fa-users me-2"></i>Players</h6>
                        <p>{{ $entries->count() }} registered</p>
                    </div>
                </div>

                @if($entries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" style="font-size: 0.9rem;">
                            <thead class="table-success">
                                <tr>
                                    <th rowspan="2" class="align-middle text-center" style="min-width: 50px;">Pos</th>
                                    <th rowspan="2" class="align-middle" style="min-width: 150px;">Player</th>
                                    
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
                                @if(isset($entriesWithFlights) && count($entriesWithFlights) > 1)
                                    {{-- Display with flight separators --}}
                                    @php $overallPosition = 1; @endphp
                                    @foreach($entriesWithFlights as $flightNumber => $flightEntries)
                                        {{-- Flight Header --}}
                                        <tr class="table-primary">
                                            <td colspan="{{ 5 + $tournament->holes }}" class="text-center fw-bold py-3">
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
                                                <td class="text-center align-middle">
                                                    @if($displayPosition <= 3 && $entry->completed_holes > 0)
                                                        <span class="badge bg-warning text-dark">{{ $displayPosition }}</span>
                                                    @else
                                                        {{ $displayPosition }}
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div>
                                                        <strong>{{ $entry->user->name ?? 'Unknown' }}</strong>
                                                        @if($entry->handicap ?? null)
                                                            <br>
                                                            <small class="text-muted">Handicap: {{ $entry->handicap }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                
                                                {{-- Front 9 holes --}}
                                                @if($tournament->holes >= 9)
                                                    @for($hole = 1; $hole <= min(9, $tournament->holes); $hole++)
                                                        <td class="text-center align-middle">
                                                            @php
                                                                $score = null;
                                                                if (isset($entry->scoresByHole) && isset($entry->scoresByHole[$hole])) {
                                                                    $score = $entry->scoresByHole[$hole];
                                                                } elseif (is_array($entry->scoresByHole ?? null)) {
                                                                    $scoreObj = collect($entry->scoresByHole)->firstWhere('hole_number', $hole);
                                                                    if ($scoreObj) {
                                                                        $score = (object) $scoreObj;
                                                                    }
                                                                }
                                                            @endphp
                                                            @if($score)
                                                                @php
                                                                    $strokes = $score->strokes ?? 0;
                                                                    $par = $score->par ?? 4;
                                                                    $diff = $strokes - $par;
                                                                @endphp
                                                                <span class="
                                                                @if($diff <= -2) text-success fw-bold
                                                                @elseif($diff == -1) text-success fw-bold
                                                                @elseif($diff == 0) text-primary fw-bold
                                                                @elseif($diff == 1) text-dark
                                                                @elseif($diff == 2) text-warning fw-bold
                                                                @else text-danger fw-bold
                                                                @endif
                                                                ">
                                                                    {{ $strokes }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    @endfor
                                                @endif
                                                
                                                {{-- Front 9 total --}}
                                                <td class="text-center align-middle bg-light fw-bold">
                                                    @if(($entry->front9_score ?? 0) > 0)
                                                        {{ $entry->front9_score }}
                                                        <br>
                                                        <small class="text-muted">
                                                            @if(($entry->front9_score - $entry->front9_par) > 0)+@endif{{ $entry->front9_score - $entry->front9_par }}
                                                        </small>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                
                                                {{-- Back 9 holes --}}
                                                @if($tournament->holes > 9)
                                                    @for($hole = 10; $hole <= $tournament->holes; $hole++)
                                                        <td class="text-center align-middle">
                                                            @php
                                                                $score = null;
                                                                if (isset($entry->scoresByHole) && isset($entry->scoresByHole[$hole])) {
                                                                    $score = $entry->scoresByHole[$hole];
                                                                } elseif (is_array($entry->scoresByHole ?? null)) {
                                                                    $scoreObj = collect($entry->scoresByHole)->firstWhere('hole_number', $hole);
                                                                    if ($scoreObj) {
                                                                        $score = (object) $scoreObj;
                                                                    }
                                                                }
                                                            @endphp
                                                            @if($score)
                                                                @php
                                                                    $strokes = $score->strokes ?? 0;
                                                                    $par = $score->par ?? 4;
                                                                    $diff = $strokes - $par;
                                                                @endphp
                                                                <span class="
                                                                @if($diff <= -2) text-success fw-bold
                                                                @elseif($diff == -1) text-success fw-bold
                                                                @elseif($diff == 0) text-primary fw-bold
                                                                @elseif($diff == 1) text-dark
                                                                @elseif($diff == 2) text-warning fw-bold
                                                                @else text-danger fw-bold
                                                                @endif
                                                                ">
                                                                    {{ $strokes }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    @endfor
                                                @endif
                                                
                                                {{-- Back 9 total --}}
                                                <td class="text-center align-middle bg-light fw-bold">
                                                    @if(($entry->back9_score ?? 0) > 0)
                                                        {{ $entry->back9_score }}
                                                        <br>
                                                        <small class="text-muted">
                                                            @if(($entry->back9_score - $entry->back9_par) > 0)+@endif{{ $entry->back9_score - $entry->back9_par }}
                                                        </small>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                
                                                {{-- 18 hole total --}}
                                                <td class="text-center align-middle bg-success text-white fw-bold">
                                                    @if($entry->completed_holes > 0)
                                                        {{ $entry->total_score }}
                                                        <br>
                                                        <small>{{ $entry->completed_holes }}/{{ $tournament->holes }}</small>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                
                                                {{-- vs Par --}}
                                                <td class="text-center align-middle bg-success text-white fw-bold">
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
                                            </tr>
                                            @php 
                                                $flightPosition++; 
                                                $overallPosition++; 
                                            @endphp
                                        @endforeach
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
                                        <td class="text-center align-middle">
                                            @if($displayPosition <= 3 && $entry->completed_holes > 0)
                                                <span class="badge bg-warning text-dark">{{ $displayPosition }}</span>
                                            @else
                                                {{ $displayPosition }}
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <div>
                                                <strong>{{ $entry->user->name }}</strong>
                                                @if($entry->handicap)
                                                    <br>
                                                    <small class="text-muted">Handicap: {{ $entry->handicap }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        {{-- Front 9 Holes --}}
                                        @if($tournament->holes >= 9)
                                            @for($hole = 1; $hole <= min(9, $tournament->holes); $hole++)
                                                <td class="text-center align-middle">
                                                    @if(isset($entry->scoresByHole[$hole]))
                                                        @php
                                                            $score = $entry->scoresByHole[$hole];
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
                                                @if($entry->front9_score > 0)
                                                    {{ $entry->front9_score }}
                                                    @if($entry->front9_par > 0)
                                                        <br>
                                                        <small class="text-muted">
                                                            @php $f9_diff = $entry->front9_score - $entry->front9_par; @endphp
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
                                                    @if(isset($entry->scoresByHole[$hole]))
                                                        @php
                                                            $score = $entry->scoresByHole[$hole];
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
                                                @if($entry->back9_score > 0)
                                                    {{ $entry->back9_score }}
                                                    @if($entry->back9_par > 0)
                                                        <br>
                                                        <small class="text-muted">
                                                            @php $b9_diff = $entry->back9_score - $entry->back9_par; @endphp
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
                                            @if($entry->completed_holes > 0)
                                                {{ $entry->total_score }}
                                                <br>
                                                <small>{{ $entry->completed_holes }}/{{ $tournament->holes }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        
                                        {{-- vs Par --}}
                                        <td class="text-center align-middle bg-success text-white fw-bold">
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
                            <p class="text-muted">Player scores will appear here as they complete their rounds.</p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No players registered</h5>
                        <p class="text-muted">The leaderboard will appear once players register for this tournament.</p>
                    </div>
                @endif
            </div>
        </div>

        @if($tournament->status === 'completed' && $entries->where('completed_holes', '>', 0)->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Tournament Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php 
                            $completedEntries = $entries->where('completed_holes', '>', 0);
                            $winner = $completedEntries->first();
                            $averageScore = $completedEntries->avg('total_score');
                            $bestScore = $completedEntries->min('total_score');
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
                            <h6><i class="fas fa-users me-2"></i>Players Completed</h6>
                            <p class="mb-0">{{ $completedEntries->count() }} / {{ $entries->count() }}</p>
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
@endsection