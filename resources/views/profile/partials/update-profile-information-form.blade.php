<div>
    <p class="text-muted mb-4">Update your account's profile information and email address.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name', $user->name) }}" 
                   required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email', $user->email) }}" 
                   required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning mt-2">
                    <small>
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Your email address is unverified.
                        <button form="send-verification" class="btn btn-link btn-sm p-0 align-baseline">
                            Click here to re-send the verification email.
                        </button>
                    </small>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success mt-2">
                            <small><i class="fas fa-check me-1"></i>A new verification link has been sent to your email address.</small>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                   id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                   autocomplete="tel">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="handicap" class="form-label">
                <i class="fas fa-golf-ball me-1"></i>Golf Handicap
            </label>
            <input type="number" class="form-control @error('handicap') is-invalid @enderror" 
                   id="handicap" name="handicap" value="{{ old('handicap', $user->handicap) }}" 
                   min="0" max="54" placeholder="Enter your handicap">
            @error('handicap')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Enter your official golf handicap (0-54).</div>
        </div>

        <div class="mb-4">
            <label for="home_course" class="form-label">
                <i class="fas fa-flag me-1"></i>Home Course
            </label>
            <input type="text" class="form-control @error('home_course') is-invalid @enderror" 
                   id="home_course" name="home_course" value="{{ old('home_course', $user->home_course) }}" 
                   placeholder="Enter your home golf course">
            @error('home_course')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">The golf course you typically play at.</div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-2"></i>Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success mb-0 py-1 px-2 d-inline-block">
                    <small><i class="fas fa-check me-1"></i>Profile updated successfully!</small>
                </div>
            @endif
        </div>
    </form>
</div>
