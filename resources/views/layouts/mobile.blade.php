<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#198754">

    <title>{{ config('app.name', 'SC Golf') }} - @yield('title', 'Mobile Scoring')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Mobile-specific styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            user-select: none;
        }
        
        .mobile-scorecard {
            padding: 1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .tournament-header {
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
            padding: 1.5rem;
            border-radius: 1rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .tournament-name {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .player-info {
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
        }
        
        .handicap {
            background: rgba(255,255,255,0.2);
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            margin-left: 0.5rem;
        }
        
        .tournament-info {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .holes-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .hole-card {
            background: white;
            border-radius: 1rem;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 3px solid transparent;
            transition: all 0.3s ease;
        }
        
        .hole-card.has-score {
            border-color: #198754;
        }
        
        .hole-card.score-eagle { border-color: #0d6efd; }
        .hole-card.score-birdie { border-color: #198754; }
        .hole-card.score-par { border-color: #6c757d; }
        .hole-card.score-bogey { border-color: #fd7e14; }
        .hole-card.score-double { border-color: #dc3545; }
        
        .hole-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .hole-number {
            font-size: 1.5rem;
            font-weight: bold;
            background: #198754;
            color: white;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .par-info {
            font-size: 1rem;
            color: #6c757d;
            font-weight: 600;
        }
        
        .score-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #495057;
        }
        
        .score-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .score-btn {
            background: #198754;
            color: white;
            border: none;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            -webkit-tap-highlight-color: transparent;
        }
        
        .score-btn:hover, .score-btn:active {
            background: #157347;
            transform: scale(0.95);
        }
        
        .score-input {
            flex: 1;
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            border: 2px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 1rem;
            background: #f8f9fa;
            -webkit-appearance: none;
            -moz-appearance: textfield;
        }
        
        .score-input:focus {
            outline: none;
            border-color: #198754;
            background: white;
        }
        
        .score-input::-webkit-outer-spin-button,
        .score-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .score-indicator {
            text-align: center;
            margin-bottom: 0.5rem;
            min-height: 1.5rem;
        }
        
        .score-diff {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-weight: bold;
            font-size: 0.9rem;
        }
        
        .score-diff.eagle { background: #cff4fc; color: #055160; }
        .score-diff.birdie { background: #d1e7dd; color: #0f5132; }
        .score-diff.par { background: #e2e3e5; color: #41464b; }
        .score-diff.bogey { background: #fff3cd; color: #664d03; }
        .score-diff.double { background: #f8d7da; color: #721c24; }
        
        .notes-input {
            width: 100%;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 0.5rem;
            font-size: 0.9rem;
            resize: none;
            height: 2.5rem;
        }
        
        .notes-input:focus {
            outline: none;
            border-color: #198754;
        }
        
        .score-summary {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #dee2e6;
            font-size: 1.1rem;
        }
        
        .summary-row:last-child {
            border-bottom: none;
        }
        
        .summary-row.total {
            font-weight: bold;
            font-size: 1.3rem;
            color: #198754;
        }
        
        .summary-row.vs-par {
            font-weight: bold;
            color: #495057;
        }
        
        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .btn-save, .btn-view {
            padding: 1rem;
            border-radius: 1rem;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-save {
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
        }
        
        .btn-save:hover {
            background: linear-gradient(135deg, #157347, #1aa085);
            transform: translateY(-2px);
            color: white;
        }
        
        .btn-view {
            background: #f8f9fa;
            color: #495057;
            border: 2px solid #dee2e6;
        }
        
        .btn-view:hover {
            background: #e9ecef;
            color: #495057;
            text-decoration: none;
        }
        
        /* Toast notifications */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1050;
        }
        
        /* Loading state */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        /* Responsive adjustments */
        @media (min-width: 576px) {
            .holes-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (min-width: 768px) {
            .holes-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <main>
        @yield('content')
    </main>

    <!-- Toast Container -->
    <div class="toast-container">
        @if(session('success'))
            <div class="toast show" role="alert">
                <div class="toast-header">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <strong class="me-auto">Success</strong>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="toast show" role="alert">
                <div class="toast-header">
                    <i class="fas fa-exclamation-circle text-danger me-2"></i>
                    <strong class="me-auto">Error</strong>
                </div>
                <div class="toast-body">
                    {{ session('error') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    
    <script>
        // Auto-hide toasts
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            });
        });
        
        // Prevent zoom on double tap
        let lastTouchEnd = 0;
        document.addEventListener('touchend', function (event) {
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    </script>
</body>
</html>