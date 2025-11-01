@extends('layouts.tournament')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-user-plus me-2"></i>Register for SC Golf
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Create your account to join golf tournaments and manage your teams.</p>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number (Optional)</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" autocomplete="tel">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Golf Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="handicap" class="form-label">Golf Handicap (Optional)</label>
                                <input type="number" class="form-control @error('handicap') is-invalid @enderror" 
                                       id="handicap" name="handicap" value="{{ old('handicap') }}" min="0" max="54">
                                @error('handicap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Enter your official golf handicap (0-54)</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="home_course" class="form-label">Home Course (Optional)</label>
                                <input type="text" class="form-control @error('home_course') is-invalid @enderror" 
                                       id="home_course" name="home_course" value="{{ old('home_course') }}">
                                @error('home_course')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Your usual golf course</div>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a class="btn btn-link text-decoration-none" href="{{ route('login') }}">
                                <i class="fas fa-arrow-left me-1"></i>Already have an account?
                            </a>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
