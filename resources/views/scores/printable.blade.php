<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scorecard - {{ $entry->user->name }} - {{ $entry->tournament->name }}</title>
    
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
            .page-break { page-break-after: always; }
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: white;
        }
        
        .scorecard {
            max-width: 8.5in;
            margin: 0 auto;
            border: 2px solid #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .tournament-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .tournament-details {
            font-size: 14px;
            color: #666;
        }
        
        .player-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .player-details {
            flex: 1;
        }
        
        .player-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .player-handicap {
            font-size: 14px;
            color: #666;
        }
        
        .qr-section {
            text-align: center;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background: #f9f9f9;
        }
        
        .qr-code {
            width: 120px;
            height: 120px;
            margin: 0 auto 10px;
            border: 1px solid #ddd;
        }
        
        .qr-instructions {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .mobile-url {
            font-size: 10px;
            color: #999;
            word-break: break-all;
        }
        
        .scorecard-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .scorecard-table th,
        .scorecard-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        
        .scorecard-table th {
            background: #e9ecef;
            font-weight: bold;
        }
        
        .hole-number {
            background: #198754;
            color: white;
            font-weight: bold;
        }
        
        .par-row {
            background: #f8f9fa;
            font-weight: bold;
        }
        
        .score-row {
            height: 40px;
        }
        
        .total-row {
            background: #198754;
            color: white;
            font-weight: bold;
        }
        
        .summary-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }
        
        .summary-box {
            border: 1px solid #333;
            padding: 15px;
            border-radius: 5px;
        }
        
        .summary-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .summary-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #ccc;
        }
        
        .summary-line:last-child {
            border-bottom: none;
            font-weight: bold;
        }
        
        .notes-section {
            margin-top: 20px;
            border: 1px solid #333;
            padding: 15px;
            border-radius: 5px;
        }
        
        .notes-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .notes-lines {
            min-height: 60px;
            background-image: repeating-linear-gradient(
                transparent,
                transparent 19px,
                #ccc 19px,
                #ccc 20px
            );
        }
        
        .print-info {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        
        .no-print {
            text-align: center;
            margin: 20px 0;
        }
        
        .btn {
            background: #198754;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin: 0 10px;
            cursor: pointer;
        }
        
        .btn:hover {
            background: #157347;
            color: white;
            text-decoration: none;
        }
        
        .btn-secondary {
            background: #6c757d;
        }
        
        .btn-secondary:hover {
            background: #5c636a;
        }
    </style>
</head>

<body>
    <div class="scorecard">
        <!-- Header -->
        <div class="header">
            <div class="tournament-title">{{ $entry->tournament->name }}</div>
            <div class="tournament-details">
                {{ $entry->tournament->start_date->format('F j, Y') }} - {{ $entry->tournament->end_date->format('F j, Y') }}
                <br>
                {{ $entry->tournament->holes }} Holes • {{ ucfirst($entry->tournament->format) }}
            </div>
        </div>

        <!-- Player Info with QR Code -->
        <div class="player-info">
            <div class="player-details">
                <div class="player-name">{{ $entry->user->name }}</div>
                @if($entry->handicap)
                    <div class="player-handicap">Handicap: {{ $entry->handicap }}</div>
                @endif
                <div class="player-handicap">Entry Date: {{ $entry->created_at->format('M j, Y') }}</div>
            </div>
            
            <div class="qr-section">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode($mobileUrl) }}" 
                     alt="QR Code for Mobile Scoring" 
                     class="qr-code">
                <div class="qr-instructions">
                    <strong>Scan to Enter Scores</strong><br>
                    Use your phone to scan this code<br>
                    and enter scores live on the course
                </div>
                <div class="mobile-url">{{ $mobileUrl }}</div>
            </div>
        </div>

        <!-- Scorecard Table -->
        <table class="scorecard-table">
            <thead>
                <tr>
                    <th>Hole</th>
                    @for($hole = 1; $hole <= $entry->tournament->holes; $hole++)
                        <th class="hole-number">{{ $hole }}</th>
                    @endfor
                    <th class="total-row">OUT/IN</th>
                    <th class="total-row">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <!-- Par Row -->
                <tr class="par-row">
                    <td><strong>Par</strong></td>
                    @php $totalPar = 0; $frontNinePar = 0; @endphp
                    @for($hole = 1; $hole <= $entry->tournament->holes; $hole++)
                        @php 
                            $score = $scoresByHole[$hole] ?? null;
                            $par = $score->par ?? 4; // Default par 4
                            $totalPar += $par;
                            if ($hole <= 9) $frontNinePar += $par;
                        @endphp
                        <td>{{ $par }}</td>
                    @endfor
                    <td>{{ $frontNinePar }}</td>
                    <td>{{ $totalPar }}</td>
                </tr>
                
                <!-- Score Row -->
                <tr class="score-row">
                    <td><strong>Score</strong></td>
                    @php $totalScore = 0; $frontNineScore = 0; @endphp
                    @for($hole = 1; $hole <= $entry->tournament->holes; $hole++)
                        @php 
                            $score = $scoresByHole[$hole] ?? null;
                            if ($score) {
                                $totalScore += $score->strokes;
                                if ($hole <= 9) $frontNineScore += $score->strokes;
                            }
                        @endphp
                        <td>{{ $score ? $score->strokes : '' }}</td>
                    @endfor
                    <td>{{ $frontNineScore > 0 ? $frontNineScore : '' }}</td>
                    <td>{{ $totalScore > 0 ? $totalScore : '' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Summary Section -->
        <div class="summary-section">
            <div class="summary-box">
                <div class="summary-title">Score Summary</div>
                <div class="summary-line">
                    <span>Front 9:</span>
                    <span>{{ $frontNineScore > 0 ? $frontNineScore : '-' }}</span>
                </div>
                @if($entry->tournament->holes > 9)
                    <div class="summary-line">
                        <span>Back 9:</span>
                        <span>{{ $totalScore > $frontNineScore ? $totalScore - $frontNineScore : '-' }}</span>
                    </div>
                @endif
                <div class="summary-line">
                    <span>Total Score:</span>
                    <span>{{ $totalScore > 0 ? $totalScore : '-' }}</span>
                </div>
                <div class="summary-line">
                    <span>vs Par:</span>
                    <span>
                        @if($totalScore > 0)
                            @php $diff = $totalScore - $totalPar; @endphp
                            {{ $diff === 0 ? 'Even' : ($diff > 0 ? '+' . $diff : $diff) }}
                        @else
                            -
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="summary-box">
                <div class="summary-title">Tournament Info</div>
                <div class="summary-line">
                    <span>Format:</span>
                    <span>{{ ucfirst($entry->tournament->format) }}</span>
                </div>
                <div class="summary-line">
                    <span>Entry Fee:</span>
                    <span>${{ number_format($entry->tournament->entry_fee, 2) }}</span>
                </div>
                <div class="summary-line">
                    <span>Max Players:</span>
                    <span>{{ $entry->tournament->max_participants ?? 'Unlimited' }}</span>
                </div>
                <div class="summary-line">
                    <span>Status:</span>
                    <span>{{ ucfirst($entry->tournament->status) }}</span>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="notes-section">
            <div class="notes-title">Notes & Comments:</div>
            <div class="notes-lines"></div>
        </div>

        <!-- Print Info -->
        <div class="print-info">
            Printed on {{ now()->format('F j, Y \a\t g:i A') }} | 
            {{ config('app.name') }} | 
            Entry ID: {{ $entry->id }}
        </div>
    </div>

    <!-- Action Buttons (hidden when printing) -->
    <div class="no-print">
        <button onclick="window.print()" class="btn">
            🖨️ Print Scorecard
        </button>
        <a href="{{ route('scores.show', $entry) }}" class="btn btn-secondary">
            👁️ View Digital Scorecard
        </a>
        <a href="{{ route('scores.mobile', $entry) }}" class="btn">
            📱 Mobile Scoring
        </a>
        <a href="{{ route('tournaments.show', $entry->tournament) }}" class="btn btn-secondary">
            ⬅️ Back to Tournament
        </a>
    </div>

    <script>
        // Auto-print when accessed with print parameter
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('print') === '1') {
            window.onload = function() {
                setTimeout(() => {
                    window.print();
                }, 500);
            };
        }
    </script>
</body>
</html>