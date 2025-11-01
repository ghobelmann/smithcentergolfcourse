@extends('layouts.tournament')

@section('title', 'Scorecard - ' . $entry->user->name)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Scorecard - {{ $entry->tournament->name }}
                    </h4>
                    <div>
                        @if($entry->tournament->status === 'active' && Auth::id() === $entry->user_id)
                            <div class="btn-group" role="group">
                                <a href="{{ route('scores.edit', $entry) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Scores
                                </a>
                                <a href="{{ route('scores.mobile', $entry) }}" class="btn btn-success">
                                    <i class="fas fa-mobile-alt me-2"></i>Mobile
                                </a>
                            </div>
                        @endif
                        <a href="{{ route('scores.print', $entry) }}" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-print me-2"></i>Print Scorecard
                        </a>
                        <a href="{{ route('tournaments.show', $entry->tournament) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Tournament
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <h6><i class="fas fa-user me-2"></i>Player</h6>
                        <p class="mb-0">{{ $entry->user->name }}</p>
                        @if($entry->handicap)
                            <small class="text-muted">Handicap: {{ $entry->handicap }}</small>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <h6><i class="fas fa-trophy me-2"></i>Tournament</h6>
                        <p class="mb-0">{{ $entry->tournament->name }}</p>
                        <small class="text-muted">{{ $entry->tournament->holes }} holes</small>
                    </div>
                    <div class="col-md-3">
                        <h6><i class="fas fa-calculator me-2"></i>Total Score</h6>
                        <p class="mb-0">
                            @if($entry->getCompletedHoles() > 0)
                                {{ $entry->getTotalScore() }} strokes
                                <br><small class="text-muted">
                                    @php
                                        $scoreToPar = $entry->getScoreRelativeToPar();
                                    @endphp
                                    @if($scoreToPar > 0)
                                        <span class="text-danger">+{{ $scoreToPar }}</span>
                                    @elseif($scoreToPar < 0)
                                        <span class="text-success">{{ $scoreToPar }}</span>
                                    @else
                                        <span class="text-primary">Even</span>
                                    @endif
                                </small>
                            @else
                                <span class="text-muted">No scores entered</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-3">
                        <h6><i class="fas fa-flag-checkered me-2"></i>Progress</h6>
                        <p class="mb-0">{{ $entry->getCompletedHoles() }} / {{ $entry->tournament->holes }} holes</p>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" style="width: {{ ($entry->getCompletedHoles() / $entry->tournament->holes) * 100 }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-success">
                            <tr>
                                <th>Hole</th>
                                <th>Par</th>
                                <th>Strokes</th>
                                <th>Score</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($hole = 1; $hole <= $entry->tournament->holes; $hole++)
                                @php
                                    $score = $scoresByHole->get($hole);
                                @endphp
                                <tr>
                                    <td><strong>{{ $hole }}</strong></td>
                                    <td>{{ $score ? $score->par : 4 }}</td>
                                    <td>
                                        @if($score)
                                            <span class="badge 
                                                @if($score->isUnderPar()) bg-success
                                                @elseif($score->isOverPar()) bg-danger
                                                @else bg-primary
                                                @endif
                                            ">
                                                {{ $score->strokes }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($score)
                                            <small class="
                                                @if($score->isUnderPar()) text-success
                                                @elseif($score->isOverPar()) text-danger
                                                @else text-primary
                                                @endif
                                            ">
                                                {{ $score->getScoreDescription() }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($score && $score->notes)
                                            <small class="text-muted">{{ Str::limit($score->notes, 30) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                        @if($entry->getCompletedHoles() > 0)
                            <tfoot class="table-light">
                                <tr>
                                    <th>Total</th>
                                    <th>{{ $entry->scores->sum('par') }}</th>
                                    <th>{{ $entry->getTotalScore() }}</th>
                                    <th>
                                        @php
                                            $scoreToPar = $entry->getScoreRelativeToPar();
                                        @endphp
                                        @if($scoreToPar > 0)
                                            <span class="text-danger">+{{ $scoreToPar }}</span>
                                        @elseif($scoreToPar < 0)
                                            <span class="text-success">{{ $scoreToPar }}</span>
                                        @else
                                            <span class="text-primary">Even</span>
                                        @endif
                                    </th>
                                    <th>-</th>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                @if($entry->getCompletedHoles() === 0)
                    <div class="text-center py-4">
                        <i class="fas fa-golf-ball fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No scores entered yet</h5>
                        @if($entry->tournament->status === 'active' && Auth::id() === $entry->user_id)
                            <p class="text-muted">Start entering your scores to track your progress!</p>
                            <a href="{{ route('scores.edit', $entry) }}" class="btn btn-success">
                                <i class="fas fa-plus me-2"></i>Start Scoring
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection