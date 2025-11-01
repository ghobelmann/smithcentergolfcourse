<div>
    <p class="text-muted mb-4">Ensure your account is using a long, random password to stay secure.</p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                   id="update_password_current_password" name="current_password" 
                   autocomplete="current-password" required>
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">New Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                   id="update_password_password" name="password" 
                   autocomplete="new-password" required>
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Password must be at least 8 characters long.</div>
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                   id="update_password_password_confirmation" name="password_confirmation" 
                   autocomplete="new-password" required>
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-lock me-2"></i>Update Password
            </button>

            @if (session('status') === 'password-updated')
                <div class="alert alert-success mb-0 py-1 px-2 d-inline-block">
                    <small><i class="fas fa-check me-1"></i>Password updated successfully!</small>
                </div>
            @endif
        </div>
    </form>
</div>
