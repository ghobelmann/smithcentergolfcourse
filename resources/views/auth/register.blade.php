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
                
                <!-- Google Sign In -->
                <div class="text-center mb-4">
                    <a href="{{ route('auth.google') }}" class="btn btn-outline-danger w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google me-2" viewBox="0 0 16 16">
                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                        </svg>
                        Sign up with Google
                    </a>
                    <p class="text-muted my-3">Or register with email</p>
                </div>
                
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
