@extends('layouts.tournament')

@section('title', 'Course Setup - ' . $course->name)

@push('styles')
<style>
    .form-control-sm:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    .table td input.form-control-sm {
        border: 1px solid #ced4da;
        background-color: #fff;
        cursor: text;
    }
    
    .table td input.form-control-sm:hover {
        border-color: #80bdff;
        background-color: #f8f9fa;
    }
    
    .table td input.form-control-sm[readonly] {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
    
    .editable-field {
        position: relative;
    }
    
    .editable-field::after {
        content: "✏️";
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12px;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
    }
    
    .editable-field:hover::after {
        opacity: 0.7;
    }
    
    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-cog me-2"></i>Course Setup - {{ $course->name }}
                    </h4>
                    <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Course
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>How to Edit:</strong> Click on any par or yardage field to edit values. 
                    Par values must be between 3-5, handicap values 1-18, and yardages 50-800 yards. 
                    Click "Save Course Setup" when finished.
                </div>
                
                <form method="POST" action="{{ route('courses.update-setup', $course) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5><i class="fas fa-flag me-2"></i>Course Tees</h5>
                            <div id="tees-container">
                                @forelse($course->tees as $tee)
                                    <div class="card mb-3 tee-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Tee Name</label>
                                                    <input type="text" class="form-control" name="tees[{{ $tee->id }}][name]" value="{{ $tee->name }}" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Color</label>
                                                    <input type="text" class="form-control" name="tees[{{ $tee->id }}][color]" value="{{ $tee->color }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Gender</label>
                                                    <select class="form-select" name="tees[{{ $tee->id }}][gender]">
                                                        <option value="mixed" {{ $tee->gender === 'mixed' ? 'selected' : '' }}>Mixed</option>
                                                        <option value="men" {{ $tee->gender === 'men' ? 'selected' : '' }}>Men</option>
                                                        <option value="women" {{ $tee->gender === 'women' ? 'selected' : '' }}>Women</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-4">
                                                    <label class="form-label">Course Rating</label>
                                                    <input type="number" step="0.1" class="form-control" name="tees[{{ $tee->id }}][course_rating]" value="{{ $tee->course_rating }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Slope Rating</label>
                                                    <input type="number" class="form-control" name="tees[{{ $tee->id }}][slope_rating]" value="{{ $tee->slope_rating }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Total Yardage</label>
                                                    <input type="number" class="form-control" name="tees[{{ $tee->id }}][total_yardage]" value="{{ $tee->total_yardage }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>No tees configured yet. Add tees to set up yardages for each hole.
                                    </div>
                                @endforelse
                            </div>
                            
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addTee()">
                                <i class="fas fa-plus me-2"></i>Add Tee
                            </button>
                        </div>
                        
                        <div class="col-md-6">
                            <h5><i class="fas fa-list-ol me-2"></i>Course Holes</h5>
                            @if($course->holes()->count() === 0)
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    No holes configured. This will automatically create {{ $course->hole_count }} holes when you save.
                                </div>
                            @else
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-sm table-striped">
                                        <thead class="table-dark sticky-top">
                                            <tr>
                                                <th>Hole</th>
                                                <th>Par</th>
                                                <th>Handicap</th>
                                                @foreach($course->tees as $tee)
                                                    <th>{{ $tee->name }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($course->holes as $hole)
                                                <tr>
                                                    <td><strong>{{ $hole->hole_number }}</strong></td>
                                                    <td class="editable-field">
                                                        <input type="number" class="form-control form-control-sm" 
                                                               name="holes[{{ $hole->id }}][par]" 
                                                               value="{{ $hole->par }}" 
                                                               min="3" max="5" style="width: 60px;"
                                                               title="Click to edit par value"
                                                               data-original-value="{{ $hole->par }}">
                                                    </td>
                                                    <td class="editable-field">
                                                        <input type="number" class="form-control form-control-sm" 
                                                               name="holes[{{ $hole->id }}][handicap]" 
                                                               value="{{ $hole->handicap }}" 
                                                               min="1" max="18" style="width: 60px;"
                                                               title="Click to edit handicap value"
                                                               data-original-value="{{ $hole->handicap }}">
                                                    </td>
                                                    @foreach($course->tees as $tee)
                                                        @php
                                                            $yardage = $hole->yardages->where('course_tee_id', $tee->id)->first();
                                                        @endphp
                                                        <td class="editable-field">
                                                            <input type="number" class="form-control form-control-sm" 
                                                                   name="yardages[{{ $hole->id }}][{{ $tee->id }}]" 
                                                                   value="{{ $yardage ? $yardage->yardage : '' }}" 
                                                                   min="50" max="800" style="width: 80px;" 
                                                                   placeholder="Yards"
                                                                   title="Click to edit yardage"
                                                                   data-original-value="{{ $yardage ? $yardage->yardage : '' }}">
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-success" onclick="return confirmSave()">
                            <i class="fas fa-save me-2"></i>Save Course Setup
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let teeCounter = {{ $course->tees->count() }};

// Debug function to check if form is working
function debugForm() {
    console.log('Form elements found:', document.querySelectorAll('input[type="number"]').length);
    console.log('Par inputs:', document.querySelectorAll('input[name*="[par]"]').length);
    console.log('Yardage inputs:', document.querySelectorAll('input[name*="yardages"]').length);
}

// Call debug function when page loads
document.addEventListener('DOMContentLoaded', function() {
    debugForm();
    
    // Add event listeners to form inputs for better UX
    const inputs = document.querySelectorAll('input[type="number"]');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.select(); // Select all text when focused
        });
        
        input.addEventListener('change', function() {
            // Validate par values
            if (this.name.includes('[par]')) {
                if (this.value < 3) this.value = 3;
                if (this.value > 5) this.value = 5;
            }
            
            // Validate handicap values
            if (this.name.includes('[handicap]')) {
                if (this.value < 1) this.value = 1;
                if (this.value > 18) this.value = 18;
            }
            
            // Validate yardage values
            if (this.name.includes('yardages')) {
                if (this.value && this.value < 50) this.value = 50;
                if (this.value && this.value > 800) this.value = 800;
            }
        });
    });
});

function addTee() {
    teeCounter++;
    const container = document.getElementById('tees-container');
    const teeCard = document.createElement('div');
    teeCard.className = 'card mb-3 tee-card';
    teeCard.innerHTML = `
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Tee Name</label>
                    <input type="text" class="form-control" name="new_tees[${teeCounter}][name]" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Color</label>
                    <input type="text" class="form-control" name="new_tees[${teeCounter}][color]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="new_tees[${teeCounter}][gender]">
                        <option value="mixed">Mixed</option>
                        <option value="men">Men</option>
                        <option value="women">Women</option>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label class="form-label">Course Rating</label>
                    <input type="number" step="0.1" class="form-control" name="new_tees[${teeCounter}][course_rating]">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Slope Rating</label>
                    <input type="number" class="form-control" name="new_tees[${teeCounter}][slope_rating]">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Total Yardage</label>
                    <input type="number" class="form-control" name="new_tees[${teeCounter}][total_yardage]">
                </div>
            </div>
            <div class="mt-2">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeTee(this)">
                    <i class="fas fa-trash me-2"></i>Remove Tee
                </button>
            </div>
        </div>
    `;
    container.appendChild(teeCard);
}

function removeTee(button) {
    if (confirm('Are you sure you want to remove this tee?')) {
        button.closest('.tee-card').remove();
    }
}

function confirmSave() {
    // Count changed fields
    const parInputs = document.querySelectorAll('input[name*="[par]"]');
    const yardageInputs = document.querySelectorAll('input[name*="yardages"]');
    
    let changedFields = 0;
    parInputs.forEach(input => {
        if (input.value && input.value !== input.defaultValue) {
            changedFields++;
        }
    });
    
    yardageInputs.forEach(input => {
        if (input.value && input.value !== input.defaultValue) {
            changedFields++;
        }
    });
    
    if (changedFields === 0) {
        return confirm('No changes detected. Do you still want to save?');
    }
    
    return confirm(`Save ${changedFields} field changes to course setup?`);
}

// Add visual feedback for form interactions
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                submitBtn.disabled = true;
            }
        });
    }
});
</script>
@endpush