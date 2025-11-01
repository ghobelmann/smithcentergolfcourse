@extends('layouts.mobile')

@section('title', 'Mobile Scoring - ' . $entry->user->name)

@section('content')
<div class="mobile-scorecard">
    <!-- Tournament Header -->
    <div class="tournament-header">
        <h3 class="tournament-name">{{ $entry->tournament->name }}</h3>
        <div class="player-info">
            <strong>{{ $entry->user->name }}</strong>
            @if($entry->handicap)
                <span class="handicap">HCP: {{ $entry->handicap }}</span>
            @endif
        </div>
        <div class="tournament-info">
            {{ $entry->tournament->holes }} holes • {{ $entry->tournament->start_date->format('M j, Y') }}
        </div>
    </div>

    <!-- Score Entry Form -->
    <form method="POST" action="{{ route('scores.update', $entry) }}" class="mobile-score-form">
        @csrf
        @method('PUT')

        <!-- Holes Grid -->
        <div class="holes-grid">
            @for($hole = 1; $hole <= $entry->tournament->holes; $hole++)
                @php
                    $score = $scoresByHole[$hole] ?? null;
                    $par = $score->par ?? ($hole <= 9 ? 4 : 4); // Default par 4
                @endphp
                
                <div class="hole-card {{ $score ? 'has-score' : '' }}">
                    <div class="hole-header">
                        <span class="hole-number">{{ $hole }}</span>
                        <span class="par-info">Par {{ $par }}</span>
                    </div>
                    
                    <div class="score-input-group">
                        <input type="hidden" name="scores[{{ $hole }}][par]" value="{{ $par }}">
                        
                        <label for="hole_{{ $hole }}_strokes" class="score-label">Strokes</label>
                        <div class="score-controls">
                            <button type="button" class="score-btn minus" onclick="adjustScore({{ $hole }}, -1)">−</button>
                            <input type="number" 
                                   id="hole_{{ $hole }}_strokes"
                                   name="scores[{{ $hole }}][strokes]" 
                                   value="{{ $score->strokes ?? '' }}"
                                   min="1" 
                                   max="15"
                                   class="score-input"
                                   onchange="updateScoreDisplay({{ $hole }})">
                            <button type="button" class="score-btn plus" onclick="adjustScore({{ $hole }}, 1)">+</button>
                        </div>
                        
                        <div class="score-indicator" id="score_indicator_{{ $hole }}">
                            @if($score)
                                @php $diff = $score->strokes - $score->par; @endphp
                                <span class="score-diff {{ $diff <= -2 ? 'eagle' : ($diff == -1 ? 'birdie' : ($diff == 0 ? 'par' : ($diff == 1 ? 'bogey' : 'double'))) }}">
                                    @if($diff == 0) Par
                                    @elseif($diff == -1) Birdie
                                    @elseif($diff <= -2) Eagle
                                    @elseif($diff == 1) Bogey
                                    @elseif($diff == 2) Double
                                    @else {{ $diff > 0 ? '+' . $diff : $diff }}
                                    @endif
                                </span>
                            @endif
                        </div>
                        
                        <textarea name="scores[{{ $hole }}][notes]" 
                                  placeholder="Notes (optional)"
                                  class="notes-input">{{ $score->notes ?? '' }}</textarea>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Score Summary -->
        <div class="score-summary">
            <div class="summary-row">
                <span>Front 9:</span>
                <span id="front_nine_total">-</span>
            </div>
            @if($entry->tournament->holes > 9)
                <div class="summary-row">
                    <span>Back 9:</span>
                    <span id="back_nine_total">-</span>
                </div>
            @endif
            <div class="summary-row total">
                <span>Total:</span>
                <span id="total_score">-</span>
            </div>
            <div class="summary-row vs-par">
                <span>vs Par:</span>
                <span id="vs_par">-</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button type="submit" class="btn-save">
                💾 Save Scores
            </button>
            <a href="{{ route('scores.show', $entry) }}" class="btn-view">
                👁️ View Scorecard
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function adjustScore(hole, adjustment) {
    const input = document.getElementById(`hole_${hole}_strokes`);
    const currentValue = parseInt(input.value) || 0;
    const newValue = Math.max(1, Math.min(15, currentValue + adjustment));
    input.value = newValue;
    updateScoreDisplay(hole);
    updateTotals();
}

function updateScoreDisplay(hole) {
    const strokesInput = document.getElementById(`hole_${hole}_strokes`);
    const indicator = document.getElementById(`score_indicator_${hole}`);
    const parInput = document.querySelector(`input[name="scores[${hole}][par]"]`);
    
    const strokes = parseInt(strokesInput.value);
    const par = parseInt(parInput.value);
    
    if (strokes && par) {
        const diff = strokes - par;
        let text = '';
        let className = '';
        
        if (diff == 0) { text = 'Par'; className = 'par'; }
        else if (diff == -1) { text = 'Birdie'; className = 'birdie'; }
        else if (diff <= -2) { text = 'Eagle'; className = 'eagle'; }
        else if (diff == 1) { text = 'Bogey'; className = 'bogey'; }
        else if (diff == 2) { text = 'Double'; className = 'double'; }
        else { text = diff > 0 ? '+' + diff : diff.toString(); className = diff > 2 ? 'double' : 'eagle'; }
        
        indicator.innerHTML = `<span class="score-diff ${className}">${text}</span>`;
        
        // Add visual feedback to hole card
        const holeCard = strokesInput.closest('.hole-card');
        holeCard.classList.add('has-score');
        holeCard.className = holeCard.className.replace(/score-\w+/g, '');
        holeCard.classList.add(`score-${className}`);
    } else {
        indicator.innerHTML = '';
    }
    
    updateTotals();
}

function updateTotals() {
    const holes = {{ $entry->tournament->holes }};
    let frontNine = 0, backNine = 0, total = 0;
    let frontNinePar = 0, backNinePar = 0, totalPar = 0;
    let frontNineCount = 0, backNineCount = 0;
    
    for (let hole = 1; hole <= holes; hole++) {
        const strokesInput = document.getElementById(`hole_${hole}_strokes`);
        const parInput = document.querySelector(`input[name="scores[${hole}][par]"]`);
        
        const strokes = parseInt(strokesInput.value) || 0;
        const par = parseInt(parInput.value) || 0;
        
        if (strokes > 0) {
            if (hole <= 9) {
                frontNine += strokes;
                frontNinePar += par;
                frontNineCount++;
            } else {
                backNine += strokes;
                backNinePar += par;
                backNineCount++;
            }
            total += strokes;
            totalPar += par;
        }
    }
    
    document.getElementById('front_nine_total').textContent = frontNineCount > 0 ? frontNine : '-';
    if (holes > 9) {
        document.getElementById('back_nine_total').textContent = backNineCount > 0 ? backNine : '-';
    }
    document.getElementById('total_score').textContent = total > 0 ? total : '-';
    
    if (total > 0 && totalPar > 0) {
        const diff = total - totalPar;
        const vsParText = diff === 0 ? 'Even' : (diff > 0 ? '+' + diff : diff.toString());
        document.getElementById('vs_par').textContent = vsParText;
    } else {
        document.getElementById('vs_par').textContent = '-';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Update displays for existing scores
    for (let hole = 1; hole <= {{ $entry->tournament->holes }}; hole++) {
        updateScoreDisplay(hole);
    }
    updateTotals();
    
    // Add touch-friendly interactions
    document.querySelectorAll('.score-input').forEach(input => {
        input.addEventListener('focus', function() {
            this.select();
        });
    });
});
</script>
@endpush
@endsection