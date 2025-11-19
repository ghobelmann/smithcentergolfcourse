@extends('layouts.tournament')

@section('title', 'Create Team')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-users me-2"></i>Create Team
                    </h4>
                    @if(request('tournament'))
                        <a href="{{ route('tournaments.show', request('tournament')) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to Tournament
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if(!isset($tournament) && request('tournament'))
                    @php
                        $tournament = \App\Models\Tournament::find(request('tournament'));
                    @endphp
                @endif
                
                @if(isset($tournament) && $tournament)
                    <div class="alert alert-info mb-4">
                        <h6><i class="fas fa-info-circle me-2"></i>Tournament Information</h6>
                        <p class="mb-2"><strong>{{ $tournament->name }}</strong></p>
                        <p class="mb-0">
                            This is a {{ $tournament->team_size }}-player scramble tournament. 
                            You'll need to recruit {{ $tournament->team_size - 1 }} additional player{{ $tournament->team_size > 2 ? 's' : '' }} to complete your team.
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ isset($tournament) && $tournament ? route('tournaments.teams.store', $tournament) : route('teams.store') }}">
                    @csrf
                    
                    @if(isset($tournament) && $tournament)
                        <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">
                    @elseif(request('tournament'))
                        <input type="hidden" name="tournament_id" value="{{ request('tournament') }}">
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label">Team Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required maxlength="255" 
                               placeholder="Enter a creative team name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Choose a memorable name for your team</div>
                    </div>

                    @if(!request('tournament'))
                        <div class="mb-3">
                            <label for="tournament_id" class="form-label">Tournament <span class="text-danger">*</span></label>
                            <select class="form-select @error('tournament_id') is-invalid @enderror" 
                                    id="tournament_id" name="tournament_id" required>
                                <option value="">Select a tournament</option>
                                @foreach(\App\Models\Tournament::where('format', 'scramble')->where('status', 'upcoming')->get() as $tournament)
                                    <option value="{{ $tournament->id }}" {{ old('tournament_id') == $tournament->id ? 'selected' : '' }}>
                                        {{ $tournament->name }} ({{ $tournament->team_size }}-player)
                                    </option>
                                @endforeach
                            </select>
                            @error('tournament_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="description" class="form-label">Team Description (Optional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" maxlength="500" 
                                  placeholder="Describe your team's playing style, experience level, or goals...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Optional: Add a description to help other players understand your team</div>
                    </div>

                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Team Captain Responsibilities</h6>
                        <ul class="mb-0">
                            <li>You will be the team captain and responsible for managing the team</li>
                            <li>You can invite other players to join your team</li>
                            <li>You can remove team members if needed</li>
                            <li>You'll coordinate team participation in tournaments</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ request('tournament') ? route('tournaments.show', request('tournament')) : route('tournaments.index') }}" 
                           class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Create Team
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('tournament_id')?.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
        const teamSize = selectedOption.text.match(/\((\d+)-player\)/)?.[1];
        if (teamSize) {
            const alert = document.querySelector('.alert-info');
            if (alert) {
                alert.innerHTML = `
                    <h6><i class="fas fa-info-circle me-2"></i>Tournament Information</h6>
                    <p class="mb-0">
                        This is a ${teamSize}-player scramble tournament. 
                        You'll need to recruit ${teamSize - 1} additional player${teamSize > 2 ? 's' : ''} to complete your team.
                    </p>
                `;
            }
        }
    }
});
</script>
@endpush
@endsection