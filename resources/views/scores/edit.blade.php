@extends('layouts.tournament')

@section('title', 'Enter Scores - ' . $entry->user->name)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Enter Scores - {{ $entry->tournament->name }}
                    </h4>
                    <div>
                        <a href="{{ route('scores.mobile', $entry) }}" class="btn btn-success">
                            <i class="fas fa-mobile-alt me-2"></i>Mobile Scoring
                        </a>
                        <a href="{{ route('scores.show', $entry) }}" class="btn btn-secondary">
                            <i class="fas fa-eye me-2"></i>View Scorecard
                        </a>
                        <a href="{{ route('scores.print', $entry) }}" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-print me-2"></i>Print
                        </a>
                        <a href="{{ route('tournaments.show', $entry->tournament) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Tournament
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <h6><i class="fas fa-user me-2"></i>Player</h6>
                        <p class="mb-0">{{ $entry->user->name }}</p>
                        @if($entry->handicap)
                            <small class="text-muted">Handicap: {{ $entry->handicap }}</small>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h6><i class="fas fa-trophy me-2"></i>Tournament</h6>
                        <p class="mb-0">{{ $entry->tournament->name }}</p>
                        <small class="text-muted">{{ $entry->tournament->holes }} holes</small>
                    </div>
                    <div class="col-md-4">
                        <h6><i class="fas fa-info-circle me-2"></i>Instructions</h6>
                        <small class="text-muted">Enter the number of strokes for each hole. Leave blank for holes not yet played.</small>
                    </div>
                </div>

                <form method="POST" action="{{ route('scores.update', $entry) }}">
                    @csrf
                    @method('PUT')

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-success">
                                <tr>
                                    <th>Hole</th>
                                    <th>Par</th>
                                    <th>Strokes</th>
                                    <th>Score</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($hole = 1; $hole <= $entry->tournament->holes; $hole++)
                                    @php
                                        $score = $scoresByHole->get($hole);
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $hole }}</strong></td>
                                        <td>
                                            <select name="scores[{{ $hole }}][par]" class="form-select form-select-sm" required>
                                                <option value="3" {{ ($score && $score->par == 3) || (!$score && $hole <= 4) ? 'selected' : '' }}>3</option>
                                                <option value="4" {{ ($score && $score->par == 4) || (!$score && $hole > 4 && $hole <= 14) ? 'selected' : '' }}>4</option>
                                                <option value="5" {{ ($score && $score->par == 5) || (!$score && $hole > 14) ? 'selected' : '' }}>5</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" 
                                                   name="scores[{{ $hole }}][strokes]" 
                                                   class="form-control form-control-sm @error('scores.'.$hole.'.strokes') is-invalid @enderror" 
                                                   value="{{ old('scores.'.$hole.'.strokes', $score ? $score->strokes : '') }}"
                                                   min="1" max="15" 
                                                   placeholder="Strokes"
                                                   onchange="calculateScore({{ $hole }})">
                                            @error('scores.'.$hole.'.strokes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <span id="score-{{ $hole }}" class="badge bg-secondary">
                                                @if($score)
                                                    {{ $score->getScoreDescription() }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <input type="text" 
                                                   name="scores[{{ $hole }}][notes]" 
                                                   class="form-control form-control-sm" 
                                                   value="{{ old('scores.'.$hole.'.notes', $score ? $score->notes : '') }}"
                                                   placeholder="Optional notes">
                                        </td>
                                        <td>
                                            @if($score)
                                                <a href="#" onclick="clearHole({{ $hole }})" class="btn btn-sm btn-outline-danger" title="Clear score">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <button type="button" class="btn btn-outline-secondary" onclick="fillDefaultPars()">
                                <i class="fas fa-magic me-2"></i>Fill Default Pars
                            </button>
                            <button type="button" class="btn btn-outline-warning" onclick="clearAllScores()">
                                <i class="fas fa-eraser me-2"></i>Clear All Scores
                            </button>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Save Scores
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function calculateScore(hole) {
    const strokesInput = document.querySelector(`input[name="scores[${hole}][strokes]"]`);
    const parSelect = document.querySelector(`select[name="scores[${hole}][par]"]`);
    const scoreSpan = document.getElementById(`score-${hole}`);
    
    const strokes = parseInt(strokesInput.value);
    const par = parseInt(parSelect.value);
    
    if (strokes && par) {
        const diff = strokes - par;
        let scoreText = '';
        let badgeClass = 'bg-secondary';
        
        switch(diff) {
            case -3: scoreText = 'Albatross'; badgeClass = 'bg-success'; break;
            case -2: scoreText = 'Eagle'; badgeClass = 'bg-success'; break;
            case -1: scoreText = 'Birdie'; badgeClass = 'bg-success'; break;
            case 0: scoreText = 'Par'; badgeClass = 'bg-primary'; break;
            case 1: scoreText = 'Bogey'; badgeClass = 'bg-warning'; break;
            case 2: scoreText = 'Double Bogey'; badgeClass = 'bg-danger'; break;
            default: 
                scoreText = diff > 0 ? '+' + diff : diff.toString();
                badgeClass = diff > 0 ? 'bg-danger' : 'bg-success';
                break;
        }
        
        scoreSpan.textContent = scoreText;
        scoreSpan.className = `badge ${badgeClass}`;
    } else {
        scoreSpan.textContent = '-';
        scoreSpan.className = 'badge bg-secondary';
    }
}

function clearHole(hole) {
    if (confirm('Are you sure you want to clear the score for hole ' + hole + '?')) {
        document.querySelector(`input[name="scores[${hole}][strokes]"]`).value = '';
        document.querySelector(`input[name="scores[${hole}][notes]"]`).value = '';
        calculateScore(hole);
    }
}

function fillDefaultPars() {
    @for($hole = 1; $hole <= $entry->tournament->holes; $hole++)
        @php
            // Default par assignment: holes 1-4 and 15-18 are par 3, 5-14 are par 4, with some par 5s
            $defaultPar = 4;
            if($hole <= 4 || $hole > 14) $defaultPar = 3;
            if($hole == 5 || $hole == 10 || $hole == 15) $defaultPar = 5;
        @endphp
        document.querySelector(`select[name="scores[{{ $hole }}][par]"]`).value = {{ $defaultPar }};
    @endfor
}

function clearAllScores() {
    if (confirm('Are you sure you want to clear all scores? This cannot be undone.')) {
        @for($hole = 1; $hole <= $entry->tournament->holes; $hole++)
            document.querySelector(`input[name="scores[{{ $hole }}][strokes]"]`).value = '';
            document.querySelector(`input[name="scores[{{ $hole }}][notes]"]`).value = '';
            calculateScore({{ $hole }});
        @endfor
    }
}

// Initialize score calculations on page load
document.addEventListener('DOMContentLoaded', function() {
    @for($hole = 1; $hole <= $entry->tournament->holes; $hole++)
        calculateScore({{ $hole }});
    @endfor
});
</script>
@endsection