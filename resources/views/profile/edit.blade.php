@extends('layouts.tournament')

@section('title', 'Profile Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6">
                <i class="fas fa-user-cog me-2"></i>Profile Settings
            </h1>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Profile Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>Profile Information
                        </h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-lock me-2"></i>Update Password
                        </h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                        </h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Profile Summary -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Golf Profile
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Name:</strong> {{ auth()->user()->name }}
                        </div>
                        <div class="mb-3">
                            <strong>Email:</strong> {{ auth()->user()->email }}
                        </div>
                        <div class="mb-3">
                            <strong>Handicap:</strong> {{ auth()->user()->handicap ?? 'Not set' }}
                        </div>
                        <div class="mb-3">
                            <strong>Home Course:</strong> {{ auth()->user()->home_course ?? 'Not set' }}
                        </div>
                        <div class="mb-0">
                            <strong>Member Since:</strong> {{ auth()->user()->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>

                <!-- Tournament Stats -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Tournament Stats
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Tournaments Played:</strong> {{ auth()->user()->tournamentEntries()->count() }}
                        </div>
                        <div class="mb-2">
                            <strong>Teams Joined:</strong> {{ auth()->user()->teams()->count() }}
                        </div>
                        <div class="mb-0">
                            <strong>Scores Recorded:</strong> 
                            {{ auth()->user()->tournamentEntries()->whereHas('scores')->count() }} rounds
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
