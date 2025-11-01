@extends('layouts.tournament')

@section('title', 'Edit Tournament')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Tournament
                    </h4>
                    <a href="{{ route('tournaments.show', $tournament) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back to Tournament
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('tournaments.update', $tournament) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tournament Name</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $tournament->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="3">{{ old('description', $tournament->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" 
                                       name="start_date" 
                                       value="{{ old('start_date', $tournament->start_date->format('Y-m-d')) }}" 
                                       required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" 
                                       name="end_date" 
                                       value="{{ old('end_date', $tournament->end_date->format('Y-m-d')) }}" 
                                       required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="holes" class="form-label">Number of Holes</label>
                                <select class="form-select @error('holes') is-invalid @enderror" 
                                        id="holes" 
                                        name="holes" 
                                        required>
                                    <option value="">Select holes</option>
                                    <option value="9" {{ old('holes', $tournament->holes) == 9 ? 'selected' : '' }}>9 Holes</option>
                                    <option value="18" {{ old('holes', $tournament->holes) == 18 ? 'selected' : '' }}>18 Holes</option>
                                </select>
                                @error('holes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="format" class="form-label">Tournament Format</label>
                                <select class="form-select @error('format') is-invalid @enderror" 
                                        id="format" 
                                        name="format" 
                                        required>
                                    <option value="">Select format</option>
                                    <option value="individual" {{ old('format', $tournament->format) == 'individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="scramble" {{ old('format', $tournament->format) == 'scramble' ? 'selected' : '' }}>Scramble</option>
                                </select>
                                @error('format')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="team_size" class="form-label">Team Size</label>
                                <select class="form-select @error('team_size') is-invalid @enderror" 
                                        id="team_size" 
                                        name="team_size">
                                    <option value="">Not applicable</option>
                                    <option value="1" {{ old('team_size', $tournament->team_size) == 1 ? 'selected' : '' }}>1 Player</option>
                                    <option value="2" {{ old('team_size', $tournament->team_size) == 2 ? 'selected' : '' }}>2 Players</option>
                                    <option value="3" {{ old('team_size', $tournament->team_size) == 3 ? 'selected' : '' }}>3 Players</option>
                                    <option value="4" {{ old('team_size', $tournament->team_size) == 4 ? 'selected' : '' }}>4 Players</option>
                                </select>
                                @error('team_size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Only required for scramble tournaments</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="entry_fee" class="form-label">Entry Fee ($)</label>
                                <input type="number" 
                                       class="form-control @error('entry_fee') is-invalid @enderror" 
                                       id="entry_fee" 
                                       name="entry_fee" 
                                       value="{{ old('entry_fee', $tournament->entry_fee) }}" 
                                       min="0" 
                                       step="0.01" 
                                       required>
                                @error('entry_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_participants" class="form-label">Maximum Participants</label>
                                <input type="number" 
                                       class="form-control @error('max_participants') is-invalid @enderror" 
                                       id="max_participants" 
                                       name="max_participants" 
                                       value="{{ old('max_participants', $tournament->max_participants) }}" 
                                       min="1">
                                @error('max_participants')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave empty for unlimited participants</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="number_of_flights" class="form-label">Number of Flights</label>
                                <select class="form-select @error('number_of_flights') is-invalid @enderror" 
                                        id="number_of_flights" 
                                        name="number_of_flights" 
                                        required>
                                    <option value="">Select flights</option>
                                    <option value="1" {{ old('number_of_flights', $tournament->number_of_flights) == '1' ? 'selected' : '' }}>1 Flight</option>
                                    <option value="2" {{ old('number_of_flights', $tournament->number_of_flights) == '2' ? 'selected' : '' }}>2 Flights</option>
                                    <option value="3" {{ old('number_of_flights', $tournament->number_of_flights) == '3' ? 'selected' : '' }}>3 Flights</option>
                                    <option value="4" {{ old('number_of_flights', $tournament->number_of_flights) == '4' ? 'selected' : '' }}>4 Flights</option>
                                    <option value="5" {{ old('number_of_flights', $tournament->number_of_flights) == '5' ? 'selected' : '' }}>5 Flights</option>
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
                                <select class="form-select @error('tie_breaking_method') is-invalid @enderror" 
                                        id="tie_breaking_method" 
                                        name="tie_breaking_method" 
                                        required>
                                    <option value="">Select method</option>
                                    <option value="usga" {{ old('tie_breaking_method', $tournament->tie_breaking_method) == 'usga' ? 'selected' : '' }}>USGA (Last 9, 6, 3, 1)</option>
                                    <option value="hc_holes" {{ old('tie_breaking_method', $tournament->tie_breaking_method) == 'hc_holes' ? 'selected' : '' }}>Handicap Holes Only</option>
                                </select>
                                <div class="form-text">USGA standard or handicap holes priority</div>
                                @error('tie_breaking_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="status" class="form-label">Tournament Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="upcoming" {{ old('status', $tournament->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                    <option value="active" {{ old('status', $tournament->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ old('status', $tournament->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tournaments.show', $tournament) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Update Tournament
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('format')?.addEventListener('change', function() {
    const teamSizeField = document.getElementById('team_size');
    const teamSizeContainer = teamSizeField.closest('.mb-3');
    
    if (this.value === 'scramble') {
        teamSizeContainer.style.display = 'block';
        teamSizeField.required = true;
        if (!teamSizeField.value) {
            teamSizeField.value = '4'; // Default to 4-player scramble
        }
    } else {
        teamSizeContainer.style.display = 'none';
        teamSizeField.required = false;
        teamSizeField.value = '';
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const formatField = document.getElementById('format');
    if (formatField) {
        formatField.dispatchEvent(new Event('change'));
    }
});

// Ensure end date is not before start date
document.getElementById('start_date')?.addEventListener('change', function() {
    const endDateField = document.getElementById('end_date');
    endDateField.min = this.value;
    
    if (endDateField.value && endDateField.value < this.value) {
        endDateField.value = this.value;
    }
});
</script>
@endpush
@endsection