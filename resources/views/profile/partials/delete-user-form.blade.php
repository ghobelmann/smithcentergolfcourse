<div>
    <div class="alert alert-danger">
        <h6><i class="fas fa-exclamation-triangle me-2"></i>Danger Zone</h6>
        <p class="mb-0">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
    </div>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
        <i class="fas fa-trash me-2"></i>Delete Account
    </button>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <strong>Are you sure you want to delete your account?</strong>
                        </div>
                        
                        <p>Once your account is deleted, all of its resources and data will be permanently deleted. This includes:</p>
                        <ul>
                            <li>Your tournament entries and scores</li>
                            <li>Team memberships and created teams</li>
                            <li>Profile information and settings</li>
                            <li>All associated data</li>
                        </ul>
                        
                        <p><strong>Please enter your password to confirm you would like to permanently delete your account.</strong></p>
                        
                        <div class="mb-3">
                            <label for="delete_password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                   id="delete_password" name="password" 
                                   placeholder="Enter your current password" required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Delete My Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
    @push('scripts')
    <script>
        // Show modal if there are deletion errors
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        });
    </script>
    @endpush
@endif
