@extends('layouts.tournament')

@section('title', 'Create Tournament')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-plus me-2"></i>Create New Tournament</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('tournaments.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Tournament Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="holes" class="form-label">Number of Holes</label>
                                <select class="form-select @error('holes') is-invalid @enderror" id="holes" name="holes" required>
                                    <option value="">Select holes</option>
                                    <option value="9" {{ old('holes') == '9' ? 'selected' : '' }}>9 holes</option>
                                    <option value="18" {{ old('holes', '18') == '18' ? 'selected' : '' }}>18 holes</option>
                                </select>
                                @error('holes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="entry_fee" class="form-label">Entry Fee ($)</label>
                                <input type="number" class="form-control @error('entry_fee') is-invalid @enderror" 
                                       id="entry_fee" name="entry_fee" value="{{ old('entry_fee', '0') }}" 
                                       min="0" step="0.01" required>
                                @error('entry_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="format" class="form-label">Tournament Format</label>
                                <select class="form-select @error('format') is-invalid @enderror" id="format" name="format" required onchange="toggleTeamSize()">
                                    <option value="individual" {{ old('format') == 'individual' ? 'selected' : '' }}>Individual Play</option>
                                    <option value="scramble" {{ old('format') == 'scramble' ? 'selected' : '' }}>Scramble Format</option>
                                </select>
                                @error('format')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3" id="team-size-group" style="display: none;">
                                <label for="team_size" class="form-label">Team Size</label>
                                <select class="form-select @error('team_size') is-invalid @enderror" id="team_size" name="team_size">
                                    <option value="">Select team size</option>
                                    <option value="1" {{ old('team_size') == '1' ? 'selected' : '' }}>1 Player Scramble</option>
                                    <option value="2" {{ old('team_size') == '2' ? 'selected' : '' }}>2 Player Scramble</option>
                                    <option value="3" {{ old('team_size') == '3' ? 'selected' : '' }}>3 Player Scramble</option>
                                    <option value="4" {{ old('team_size') == '4' ? 'selected' : '' }}>4 Player Scramble</option>
                                </select>
                                @error('team_size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="max_participants" class="form-label">Maximum Participants</label>
                        <input type="number" class="form-control @error('max_participants') is-invalid @enderror" 
                               id="max_participants" name="max_participants" value="{{ old('max_participants') }}" 
                               min="1">
                        <div class="form-text">Leave empty for unlimited participants</div>
                        @error('max_participants')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="number_of_flights" class="form-label">Number of Flights</label>
                                <select class="form-select @error('number_of_flights') is-invalid @enderror" id="number_of_flights" name="number_of_flights" required>
                                    <option value="">Select flights</option>
                                    <option value="1" {{ old('number_of_flights', '1') == '1' ? 'selected' : '' }}>1 Flight</option>
                                    <option value="2" {{ old('number_of_flights') == '2' ? 'selected' : '' }}>2 Flights</option>
                                    <option value="3" {{ old('number_of_flights') == '3' ? 'selected' : '' }}>3 Flights</option>
                                    <option value="4" {{ old('number_of_flights') == '4' ? 'selected' : '' }}>4 Flights</option>
                                    <option value="5" {{ old('number_of_flights') == '5' ? 'selected' : '' }}>5 Flights</option>
                                </select>
                                <div class="form-text">Flights divide participants into competitive groups</div>
                                @error('number_of_flights')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tie_breaking_method" class="form-label">Tie Breaking Method</label>
                                <select class="form-select @error('tie_breaking_method') is-invalid @enderror" id="tie_breaking_method" name="tie_breaking_method" required>
                                    <option value="">Select method</option>
                                    <option value="usga" {{ old('tie_breaking_method', 'usga') == 'usga' ? 'selected' : '' }}>USGA (Last 9, 6, 3, 1)</option>
                                    <option value="hc_holes" {{ old('tie_breaking_method') == 'hc_holes' ? 'selected' : '' }}>Handicap Holes Only</option>
                                </select>
                                <div class="form-text">USGA standard or handicap holes priority</div>
                                @error('tie_breaking_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Create Tournament
                        </button>
                        <a href="{{ route('tournaments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleTeamSize() {
    const formatSelect = document.getElementById('format');
    const teamSizeGroup = document.getElementById('team-size-group');
    const teamSizeSelect = document.getElementById('team_size');
    
    if (formatSelect.value === 'scramble') {
        teamSizeGroup.style.display = 'block';
        teamSizeSelect.required = true;
    } else {
        teamSizeGroup.style.display = 'none';
        teamSizeSelect.required = false;
        teamSizeSelect.value = '';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleTeamSize();
});
</script>
@endsection