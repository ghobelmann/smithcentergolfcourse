@extends('layouts.tournament')

@section('title', 'Edit Course - ' . $course->name)

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-flag me-2"></i>Edit Golf Course
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('courses.update', $course) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label">Course Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $course->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="hole_count" class="form-label">Number of Holes *</label>
                            <select class="form-select @error('hole_count') is-invalid @enderror" id="hole_count" name="hole_count" required>
                                <option value="">Select...</option>
                                <option value="9" {{ old('hole_count', $course->hole_count) == '9' ? 'selected' : '' }}>9 Holes</option>
                                <option value="18" {{ old('hole_count', $course->hole_count) == '18' ? 'selected' : '' }}>18 Holes</option>
                            </select>
                            @error('hole_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $course->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" 
                               id="address" name="address" value="{{ old('address', $course->address) }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city', $course->city) }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                   id="state" name="state" value="{{ old('state', $course->state) }}">
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="zip_code" class="form-label">ZIP Code</label>
                            <input type="text" class="form-control @error('zip_code') is-invalid @enderror" 
                                   id="zip_code" name="zip_code" value="{{ old('zip_code', $course->zip_code) }}">
                            @error('zip_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $course->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                   id="website" name="website" value="{{ old('website', $course->website) }}" 
                                   placeholder="https://...">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="par" class="form-label">Course Par</label>
                            <input type="number" class="form-control @error('par') is-invalid @enderror" 
                                   id="par" name="par" value="{{ old('par', $course->par) }}" 
                                   min="27" max="108">
                            @error('par')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="yardage" class="form-label">Total Yardage</label>
                            <input type="number" class="form-control @error('yardage') is-invalid @enderror" 
                                   id="yardage" name="yardage" value="{{ old('yardage', $course->yardage) }}" 
                                   min="1000" max="9000">
                            @error('yardage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input type="hidden" name="active" value="0">
                                <input class="form-check-input @error('active') is-invalid @enderror" 
                                       type="checkbox" id="active" name="active" value="1" 
                                       {{ old('active', $course->active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">
                                    Course is Active
                                </label>
                                @error('active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Update Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection