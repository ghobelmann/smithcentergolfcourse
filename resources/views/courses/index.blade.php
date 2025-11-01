@extends('layouts.tournament')

@section('title', 'Golf Courses')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6">
                <i class="fas fa-flag me-2"></i>Golf Courses
            </h1>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('courses.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Add New Course
                    </a>
                @endif
            @endauth
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($courses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Location</th>
                                    <th>Holes</th>
                                    <th>Par</th>
                                    <th>Tees</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $course->name }}</strong>
                                            @if($course->description)
                                                <br><small class="text-muted">{{ Str::limit($course->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($course->city || $course->state)
                                            {{ $course->city }}@if($course->city && $course->state), @endif{{ $course->state }}
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $course->hole_count }} holes</span>
                                    </td>
                                    <td>
                                        @if($course->par)
                                            <span class="badge bg-primary">Par {{ $course->par }}</span>
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $course->tees_count }} tees</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @auth
                                                @if(auth()->user()->isAdmin())
                                                    <a href="{{ route('courses.setup', $course) }}" class="btn btn-outline-success">
                                                        <i class="fas fa-cogs"></i>
                                                    </a>
                                                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('courses.destroy', $course) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" 
                                                                onclick="return confirm('Are you sure you want to delete this course? This action cannot be undone.')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $courses->links() }}
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-flag fa-3x text-muted mb-3"></i>
                        <h4>No Courses Found</h4>
                        <p class="text-muted">There are no golf courses in the system yet.</p>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('courses.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i>Add First Course
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection