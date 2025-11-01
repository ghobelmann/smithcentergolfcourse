@extends('layouts.tournament')

@section('title', 'Session Timeout Test')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-clock me-2"></i>Session Timeout Test
                </h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Session Information</h6>
                    <p><strong>Session Lifetime:</strong> {{ config('session.lifetime') }} minutes</p>
                    <p><strong>Current Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
                    <p><strong>User:</strong> {{ auth()->user()->name }}</p>
                    <p class="mb-0"><strong>Session ID:</strong> {{ session()->getId() }}</p>
                </div>

                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Test Instructions</h6>
                    <ol class="mb-0">
                        <li>You will see a warning modal 5 minutes before your session expires</li>
                        <li>You can click "Stay Logged In" to extend your session</li>
                        <li>If you don't respond, you'll be automatically logged out</li>
                        <li>Any form submissions with expired sessions will redirect to login</li>
                    </ol>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6>Test AJAX Request</h6>
                        <button id="testAjax" class="btn btn-primary">
                            <i class="fas fa-sync me-2"></i>Test AJAX
                        </button>
                        <div id="ajaxResult" class="mt-2"></div>
                    </div>
                    <div class="col-md-6">
                        <h6>Test Form Submission</h6>
                        <form method="POST" action="{{ route('session.test') }}">
                            @csrf
                            <div class="mb-2">
                                <input type="text" class="form-control" name="test_data" placeholder="Enter test data">
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane me-2"></i>Submit Form
                            </button>
                        </form>
                    </div>
                </div>

                <hr class="my-4">

                <div class="text-center">
                    <h6>Manual Session Actions</h6>
                    <button onclick="extendSession()" class="btn btn-outline-success me-2">
                        <i class="fas fa-clock me-2"></i>Extend Session
                    </button>
                    <button onclick="showSessionWarning()" class="btn btn-outline-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>Show Warning Modal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('testAjax').addEventListener('click', function() {
    const button = this;
    const result = document.getElementById('ajaxResult');
    
    button.disabled = true;
    result.innerHTML = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>Testing...';
    
    fetch('{{ route("session.extend") }}', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        result.innerHTML = '<div class="alert alert-success"><i class="fas fa-check me-2"></i>AJAX request successful: ' + data.message + '</div>';
        button.disabled = false;
    })
    .catch(error => {
        result.innerHTML = '<div class="alert alert-danger"><i class="fas fa-times me-2"></i>AJAX request failed: ' + error.message + '</div>';
        button.disabled = false;
    });
});
</script>
@endpush
@endsection