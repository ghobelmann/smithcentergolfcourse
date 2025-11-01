<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Scorecards - {{ $tournament->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @page {
            size: portrait;
            margin: 0.3in;
        }
        
        @media print {
            .no-print { display: none !important; }
            .page-break { page-break-after: always; }
            
            html, body { 
                margin: 0; 
                padding: 0;
                font-size: 8px;
                line-height: 1.1;
                width: 100%;
                height: 100%;
            }
            
            .scorecard { 
                margin: 0 0 10px 0;
                padding: 5px;
                width: 100%;
                height: 32%;
                box-sizing: border-box;
                border: 1px solid #000;
                display: block;
            }
            
            .scorecard:nth-child(4n) {
                page-break-after: always;
            }
            
            .score-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 7px;
                margin: 0;
            }
            
            .score-table th,
            .score-table td {
                border: 1px solid #000;
                padding: 1px 2px;
                text-align: center;
                font-size: 7px;
                height: 15px;
            }
            
            .score-table th {
                background-color: #f0f0f0;
                font-weight: bold;
            }
            
            .player-name {
                font-size: 8px;
                font-weight: bold;
                text-align: left;
                margin-bottom: 2px;
            }
            
            .tournament-info {
                font-size: 6px;
                text-align: center;
                margin-bottom: 3px;
            }
        }
        
        @media screen {
            .scorecard {
                border: 1px solid #ddd;
                margin-bottom: 20px;
                padding: 15px;
                background: white;
            }
            body {
                background: #f8f9fa;
                padding: 20px;
            }
            
            .score-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 10px;
                margin: 5px 0;
            }
            
            .score-table th,
            .score-table td {
                border: 1px solid #000;
                padding: 4px;
                text-align: center;
            }
            
            .score-table th {
                background-color: #f0f0f0;
                font-weight: bold;
            }
            
            .player-name {
                font-size: 14px;
                font-weight: bold;
                margin-bottom: 5px;
            }
            
            .tournament-info {
                font-size: 10px;
                text-align: center;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="no-print mb-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2>All Scorecards - {{ $tournament->name }}</h2>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print me-2"></i>Print All Scorecards
                    </button>
                    <a href="{{ route('tournaments.show', $tournament) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Tournament
                    </a>
                </div>
            </div>
        </div>
    </div>

    @foreach($entries as $index => $entry)
        <div class="scorecard">
            <div class="tournament-info">{{ $tournament->name }} - {{ $tournament->start_date->format('M j, Y') }}</div>
            <div class="player-name">{{ $entry->user->name }}@if($entry->team) ({{ $entry->team->name }})@endif</div>
            
            <table class="score-table">
                <tr>
                    <th>Hole</th>
                    @for($hole = 1; $hole <= 18; $hole++)
                        <th>{{ $hole }}</th>
                    @endfor
                    <th>Total</th>
                </tr>
                <tr>
                    <th>Par</th>
                    @php $totalPar = 0; @endphp
                    @for($hole = 1; $hole <= 18; $hole++)
                        @php 
                            $par = $tournament->course_par[$hole] ?? 4;
                            $totalPar += $par;
                        @endphp
                        <td>{{ $par }}</td>
                    @endfor
                    <td><strong>{{ $totalPar }}</strong></td>
                </tr>
                <tr>
                    <th>Score</th>
                    @php 
                        $existingScores = $entry->scores->keyBy('hole_number');
                        $totalScore = 0;
                    @endphp
                    @for($hole = 1; $hole <= 18; $hole++)
                        @php
                            $score = $existingScores->get($hole)?->strokes ?? null;
                            if ($score) $totalScore += $score;
                        @endphp
                        <td style="height: 20px;">{{ $score ?? '' }}</td>
                    @endfor
                    <td><strong>{{ $totalScore > 0 ? $totalScore : '' }}</strong></td>
                </tr>
            </table>
        </div>
    @endforeach

    <script>
        // Auto-print when page loads if requested
        if (window.location.search.includes('print=1')) {
            setTimeout(() => window.print(), 500);
        }
    </script>
</body>
</html>