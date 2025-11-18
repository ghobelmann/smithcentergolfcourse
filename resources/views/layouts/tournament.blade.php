<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SC Golf') }} - @yield('title', 'Golf Tournament Scoring')</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        html, body {
            height: 100%;
        }
        
        body {
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1 0 auto;
        }
        
        footer {
            flex-shrink: 0;
        }
        
        /* Fix dropdown positioning */
        .navbar .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            transform: none !important;
        }
        
        .navbar .dropdown {
            position: relative;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-golf-ball me-2"></i>SC Golf
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tournaments.index') }}">Tournaments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('courses.index') }}">Courses</a>
                    </li>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('tournaments.create') }}">Create Tournament</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    @if (session('info'))
                        <br><small class="text-muted">{{ session('info') }}</small>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} SC Golf Tournament Scoring System</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Session Timeout Handler -->
    <script>
        // Enhanced session timeout and CSRF handling
        document.addEventListener('DOMContentLoaded', function() {
            // Setup CSRF token for all AJAX requests
            const token = document.querySelector('meta[name="csrf-token"]');
            if (token) {
                window.axios = window.axios || {};
                if (window.axios.defaults) {
                    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
                }
                
                // Update all form CSRF tokens
                const forms = document.querySelectorAll('form input[name="_token"]');
                forms.forEach(input => {
                    input.value = token.getAttribute('content');
                });
            }

            // Enhanced fetch interception for session/CSRF handling
            const originalFetch = window.fetch;
            window.fetch = function(...args) {
                return originalFetch.apply(this, args)
                    .then(response => {
                        // Handle session expired or CSRF token mismatch
                        if (response.status === 419) {
                            handleSessionExpired('Your session has expired. Redirecting to login...');
                            return Promise.reject('Session expired');
                        }
                        
                        // Handle unauthorized access
                        if (response.status === 401) {
                            handleSessionExpired('Authentication required. Redirecting to login...');
                            return Promise.reject('Authentication required');
                        }
                        
                        return response;
                    })
                    .catch(error => {
                        if (error.status === 419 || error.status === 401) {
                            handleSessionExpired('Session error. Redirecting to login...');
                        }
                        throw error;
                    });
            };

            // Handle session expiration with user feedback
            function handleSessionExpired(message) {
                // Show user-friendly message
                showSessionExpiredModal(message);
                
                // Redirect after brief delay
                setTimeout(() => {
                    window.location.href = '{{ route("login") }}';
                }, 2000);
            }

            // Show session expired modal
            function showSessionExpiredModal(message) {
                // Remove any existing modal
                const existingModal = document.getElementById('sessionExpiredModal');
                if (existingModal) {
                    existingModal.remove();
                }

                const modal = document.createElement('div');
                modal.id = 'sessionExpiredModal';
                modal.className = 'modal fade show';
                modal.style.display = 'block';
                modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
                modal.innerHTML = `
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Session Expired
                                </h5>
                            </div>
                            <div class="modal-body text-center">
                                <p>${message}</p>
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(modal);
            }

            // Enhanced form submission handling
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (form.method && form.method.toLowerCase() === 'post') {
                    // Update CSRF token before submission
                    const csrfInput = form.querySelector('input[name="_token"]');
                    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                    if (csrfInput && csrfMeta) {
                        csrfInput.value = csrfMeta.getAttribute('content');
                    }

                    // Add timestamp for duplicate submission prevention
                    const timestamp = new Date().getTime();
                    let timestampField = form.querySelector('input[name="_timestamp"]');
                    if (!timestampField) {
                        timestampField = document.createElement('input');
                        timestampField.type = 'hidden';
                        timestampField.name = '_timestamp';
                        form.appendChild(timestampField);
                    }
                    timestampField.value = timestamp;
                }
            });

            // Handle form submission errors (including CSRF)
            document.addEventListener('submit', function(e) {
                const form = e.target;
                const submitBtn = form.querySelector('button[type="submit"]');
                
                if (submitBtn && form.method && form.method.toLowerCase() === 'post') {
                    // Show loading state
                    const originalContent = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
                    submitBtn.disabled = true;
                    
                    // Reset button after timeout (in case of errors)
                    setTimeout(() => {
                        if (submitBtn.disabled) {
                            submitBtn.innerHTML = originalContent;
                            submitBtn.disabled = false;
                        }
                    }, 30000); // 30 second timeout
                }
            });

            // Session timeout warning system
            @auth
            let sessionWarningShown = false;
            let sessionTimeout = {{ config('session.lifetime') * 60 * 1000 }}; // Convert to milliseconds
            let warningTime = sessionTimeout - (5 * 60 * 1000); // Warn 5 minutes before expiry
            
            function showSessionWarning() {
                if (sessionWarningShown) return;
                sessionWarningShown = true;
                
                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.id = 'sessionWarningModal';
                modal.innerHTML = `
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Session Expiring Soon
                                </h5>
                            </div>
                            <div class="modal-body">
                                <p>Your session will expire in <strong>5 minutes</strong> due to inactivity.</p>
                                <p>Click "Stay Logged In" to extend your session, or you will be automatically logged out.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Logout Now</button>
                                <button type="button" class="btn btn-success" onclick="extendSession()">Stay Logged In</button>
                            </div>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(modal);
                const bootstrapModal = new bootstrap.Modal(modal);
                bootstrapModal.show();
                
                // Auto-logout after 5 minutes if no action taken
                setTimeout(function() {
                    document.getElementById('logout-form').submit();
                }, 5 * 60 * 1000);
            }
            
            function extendSession() {
                fetch('{{ route("session.extend") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                }).then(function(response) {
                    return response.json();
                }).then(function(data) {
                    if (data.success && data.csrf_token) {
                        // Update CSRF token in meta tag and all forms
                        const metaToken = document.querySelector('meta[name="csrf-token"]');
                        if (metaToken) {
                            metaToken.setAttribute('content', data.csrf_token);
                        }
                        
                        // Update all form CSRF tokens
                        const formTokens = document.querySelectorAll('input[name="_token"]');
                        formTokens.forEach(input => {
                            input.value = data.csrf_token;
                        });
                    }
                }).then(function() {
                    // Close warning modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('sessionWarningModal'));
                    if (modal) modal.hide();
                    sessionWarningShown = false;
                    
                    // Reset warning timer
                    setTimeout(showSessionWarning, warningTime);
                    
                    // Show success message
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
                    alert.style.top = '20px';
                    alert.style.right = '20px';
                    alert.style.zIndex = '9999';
                    alert.innerHTML = `
                        <i class="fas fa-check-circle me-2"></i>Session extended successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(alert);
                    
                    setTimeout(() => alert.remove(), 3000);
                }).catch(function() {
                    // Session already expired, redirect to login
                    window.location.href = '{{ route("login") }}';
                });
            }
            
            // Start session warning timer
            setTimeout(showSessionWarning, warningTime);
            @endauth

            // Session activity tracker (optional - helps extend session on user activity)
            let activityTimer;
            function trackActivity() {
                clearTimeout(activityTimer);
                activityTimer = setTimeout(function() {
                    // Send a keep-alive request every 10 minutes of activity
                    @auth
                    fetch('{{ route("dashboard") }}', {
                        method: 'HEAD',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).catch(function() {
                        // Ignore errors - this is just a keep-alive
                    });
                    @endauth
                }, 600000); // 10 minutes
            }

            // Track user activity
            ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(function(event) {
                document.addEventListener(event, trackActivity, true);
            });

            // Initial activity tracking
            trackActivity();
        });

        // Global error handler for uncaught session timeouts
        window.addEventListener('unhandledrejection', function(event) {
            if (event.reason && (event.reason.status === 419 || event.reason.status === 401)) {
                event.preventDefault();
                handleSessionExpired('Session expired. Redirecting to login...');
            }
        });

        // Handle page errors (like direct navigation to expired sessions)
        window.addEventListener('error', function(event) {
            if (event.error && event.error.message && 
                (event.error.message.includes('419') || event.error.message.includes('CSRF'))) {
                handleSessionExpired('Session expired. Redirecting to login...');
            }
        });

        // Auto-refresh CSRF token every 10 minutes for active users
        @auth
        setInterval(function() {
            // Only refresh if user is active (has interacted recently)
            if (document.hasFocus() || (Date.now() - lastActivity) < 600000) { // 10 minutes
                fetch('{{ route("session.extend") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                }).then(function(response) {
                    return response.json();
                }).then(function(data) {
                    if (data.success && data.csrf_token) {
                        // Update CSRF token silently
                        const metaToken = document.querySelector('meta[name="csrf-token"]');
                        if (metaToken) {
                            metaToken.setAttribute('content', data.csrf_token);
                        }
                        
                        const formTokens = document.querySelectorAll('input[name="_token"]');
                        formTokens.forEach(input => {
                            input.value = data.csrf_token;
                        });
                    }
                }).catch(function(error) {
                    if (error.status === 419 || error.status === 401) {
                        handleSessionExpired('Session expired. Redirecting to login...');
                    }
                });
            }
        }, 600000); // 10 minutes
        
        // Track user activity
        let lastActivity = Date.now();
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(function(event) {
            document.addEventListener(event, function() {
                lastActivity = Date.now();
            }, true);
        });
        @endauth
    </script>
    
    @stack('scripts')
</body>
</html>