@extends('layouts.tournament')

@section('title', 'Combined Scorecard - ' . $tournament->name)

@section('content')
    <style>
        @page {
            size: landscape;
            margin: 0.5in;
        }
        
        @media print {
            .no-print { display: none !important; }
            .page-break { page-break-after: always; }
            
            html, body { 
                margin: 0; 
                padding: 0;
                font-size: 10px;
                line-height: 1.2;
                width: 100%;
                height: 100%;
            }
            
            .scorecard-page { 
                margin: 0;
                padding: 15px;
                width: 100%;
                height: 100%;
                box-sizing: border-box;
                border: 3px solid #000;
                display: block;
                background: white;
                page-break-inside: avoid;
            }
            
            .scorecard-header {
                text-align: center;
                font-size: 16px;
                font-weight: bold;
                margin-bottom: 15px;
                border: 2px solid #000;
                padding: 8px;
                background-color: #f0f0f0;
            }
            
            .course-info {
                display: flex;
                justify-content: space-between;
                font-size: 9px;
                margin-bottom: 10px;
                padding: 5px;
                border: 1px solid #000;
                background-color: #f8f9fa;
            }
            
            .score-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 8px;
                margin: 0;
                border: 2px solid #000;
            }
            
            .score-table th,
            .score-table td {
                border: 1px solid #000;
                padding: 3px 2px;
                text-align: center;
                font-size: 8px;
                height: 22px;
                min-width: 28px;
            }
            
            .score-table th {
                background-color: #e6e6e6;
                font-weight: bold;
            }
            
            .player-name-cell {
                text-align: left;
                font-weight: bold;
                min-width: 140px;
                background-color: #f0f0f0;
                padding-left: 5px;
            }
            
            .hole-header {
                background-color: #d4c3a0;
                color: #000;
                font-weight: bold;
                font-size: 9px;
            }
            
            .par-row {
                background-color: #e8e8e8;
                font-weight: bold;
                font-size: 8px;
            }
            
            .yardage-row {
                background-color: #f5f2ed;
                font-size: 7px;
            }
            
            .total-column {
                background-color: #b59f7a;
                color: white;
                font-weight: bold;
                min-width: 35px;
                font-size: 9px;
            }
            
            .signature-area {
                margin-top: 15px;
                display: flex;
                justify-content: space-between;
                border-top: 2px solid #000;
                padding-top: 8px;
                font-size: 8px;
            }
            
            .signature-box {
                border-bottom: 1px solid #000;
                width: 120px;
                height: 15px;
                margin-bottom: 3px;
            }
            
            .qr-section {
                margin-top: 10px;
                text-align: center;
                border: 1px solid #000;
                padding: 5px;
                background-color: #f9f9f9;
            }
        }
        
        @media screen {
            .scorecard-page {
                border: 2px solid #ddd;
                margin: 20px auto;
                padding: 30px;
                background: white;
                max-width: 1200px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            
            body {
                background: #f8f9fa;
                padding: 20px;
                font-family: 'Arial', sans-serif;
            }
            
            .scorecard-header {
                text-align: center;
                font-size: 28px;
                font-weight: bold;
                margin-bottom: 20px;
                border: 3px solid #333;
                padding: 15px;
                background: linear-gradient(135deg, #f0f0f0 0%, #e6e6e6 100%);
                border-radius: 8px;
            }
            
            .course-info {
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 14px;
                margin-bottom: 20px;
                padding: 10px 15px;
                border: 2px solid #333;
                background-color: #f8f9fa;
                border-radius: 6px;
            }
            
            .score-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
                margin: 15px 0;
                border: 3px solid #333;
            }
            
            .score-table th,
            .score-table td {
                border: 1px solid #333;
                padding: 8px 4px;
                text-align: center;
                min-width: 35px;
            }
            
            .score-table th {
                background-color: #e6e6e6;
                font-weight: bold;
            }
            
            .player-name-cell {
                text-align: left;
                font-weight: bold;
                min-width: 180px;
                background-color: #f0f0f0;
                padding-left: 10px;
            }
            
            .hole-header {
                background-color: #d4c3a0;
                color: #000;
                font-weight: bold;
                font-size: 13px;
            }
            
            .par-row {
                background-color: #e8e8e8;
                font-weight: bold;
            }
            
            .yardage-row {
                background-color: #f5f2ed;
                font-size: 11px;
            }
            
            .total-column {
                background-color: #b59f7a;
                color: white;
                font-weight: bold;
                min-width: 55px;
                font-size: 13px;
            }
            
            .signature-area {
                margin-top: 25px;
                display: flex;
                justify-content: space-between;
                border-top: 3px solid #333;
                padding-top: 15px;
            }
            
            .signature-box {
                border-bottom: 2px solid #333;
                width: 150px;
                height: 25px;
                margin-bottom: 5px;
            }
            
            .qr-section {
                margin-top: 15px;
                text-align: center;
                border: 2px solid #333;
                padding: 10px;
                background-color: #f9f9f9;
                border-radius: 6px;
            }
        }
        
        .signature-label {
            font-size: 10px;
            margin-top: 3px;
            font-weight: bold;
        }
        
        .print-controls {
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>

    <div class="print-controls no-print mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">Tournament Scorecard</h4>
                        <p class="text-muted mb-0">{{ $tournament->name }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button onclick="window.print()" class="btn btn-success">
                            <i class="fas fa-print me-2"></i>Print Scorecard
                        </button>
                        <a href="{{ route('tournaments.show', $tournament) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Tournament
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="scorecard-page bg-white">
        <div class="scorecard-header">
            <div class="h3 fw-bold mb-1">{{ $tournament->name }}</div>
            <div class="small">Official Tournament Scorecard</div>
        </div>
        
        <div class="course-info">
            <div class="d-flex align-items-center">
                <i class="fas fa-calendar me-2"></i>
                <strong>Date:</strong>&nbsp;{{ $tournament->start_date->format('F j, Y') }}
            </div>
            <div class="d-flex align-items-center">
                <i class="fas fa-golf-ball me-2"></i>
                <strong>Course:</strong>&nbsp;{{ $tournament->holes }} Holes
            </div>
            <div class="d-flex align-items-center">
                <i class="fas fa-users me-2"></i>
                <strong>Format:</strong>&nbsp;{{ ucfirst($tournament->format) }}
                @if($tournament->format === 'scramble')
                    ({{ $tournament->team_size }} Player Teams)
                @endif
            </div>
        </div>
        
        <table class="score-table">
            <thead>
                <!-- Hole Numbers Row -->
                <tr>
                    <th class="player-name-cell">Player/Team</th>
                    @for($hole = 1; $hole <= 9; $hole++)
                        <th class="hole-header">{{ $hole }}</th>
                    @endfor
                    <th class="total-column">OUT</th>
                    @if($tournament->holes > 9)
                        @for($hole = 10; $hole <= $tournament->holes; $hole++)
                            <th class="hole-header">{{ $hole }}</th>
                        @endfor
                        <th class="total-column">IN</th>
                    @endif
                    <th class="total-column">TOTAL</th>
                </tr>
                
                <!-- Par Row -->
                <tr>
                    <th class="par-row">PAR</th>
                    @php 
                        $frontNinePar = 0; 
                        $backNinePar = 0; 
                        $totalPar = 0;
                    @endphp
                    @for($hole = 1; $hole <= 9; $hole++)
                        @php 
                            // Default par values for now - can be customized later
                            $defaultPars = [1 => 4, 2 => 4, 3 => 3, 4 => 4, 5 => 5, 6 => 4, 7 => 4, 8 => 3, 9 => 4];
                            $par = $defaultPars[$hole] ?? 4;
                            $frontNinePar += $par;
                            $totalPar += $par;
                        @endphp
                        <td class="par-row">{{ $par }}</td>
                    @endfor
                    <td class="total-column">{{ $frontNinePar }}</td>
                    @if($tournament->holes > 9)
                        @for($hole = 10; $hole <= $tournament->holes; $hole++)
                            @php 
                                // Default par values for back nine
                                $defaultPars = [10 => 4, 11 => 3, 12 => 4, 13 => 5, 14 => 4, 15 => 4, 16 => 3, 17 => 4, 18 => 4];
                                $par = $defaultPars[$hole] ?? 4;
                                $backNinePar += $par;
                                $totalPar += $par;
                            @endphp
                            <td class="par-row">{{ $par }}</td>
                        @endfor
                        <td class="total-column">{{ $backNinePar }}</td>
                    @endif
                    <td class="total-column">{{ $totalPar }}</td>
                </tr>
                
                <!-- Yardage Row -->
                <tr>
                    <th class="yardage-row">YARDS</th>
                    @php 
                        $frontNineYards = 0; 
                        $backNineYards = 0; 
                        $totalYards = 0;
                    @endphp
                    @for($hole = 1; $hole <= 9; $hole++)
                        @php 
                            // Default yardage values for front nine
                            $defaultYards = [1 => 380, 2 => 420, 3 => 165, 4 => 395, 5 => 520, 6 => 410, 7 => 385, 8 => 175, 9 => 400];
                            $yards = $defaultYards[$hole] ?? 400;
                            $frontNineYards += $yards;
                            $totalYards += $yards;
                        @endphp
                        <td class="yardage-row">{{ $yards }}</td>
                    @endfor
                    <td class="total-column">{{ $frontNineYards }}</td>
                    @if($tournament->holes > 9)
                        @for($hole = 10; $hole <= $tournament->holes; $hole++)
                            @php 
                                // Default yardage values for back nine
                                $defaultYards = [10 => 415, 11 => 185, 12 => 390, 13 => 540, 14 => 405, 15 => 375, 16 => 195, 17 => 425, 18 => 450];
                                $yards = $defaultYards[$hole] ?? 400;
                                $backNineYards += $yards;
                                $totalYards += $yards;
                            @endphp
                            <td class="yardage-row">{{ $yards }}</td>
                        @endfor
                        <td class="total-column">{{ $backNineYards }}</td>
                    @endif
                    <td class="total-column">{{ $totalYards }}</td>
                </tr>
            </thead>
            <tbody>
                @if($tournament->format === 'scramble')
                    {{-- Show Teams --}}
                    @foreach($tournament->teams as $team)
                        <tr>
                            <td class="player-name-cell">
                                <strong>{{ $team->name }}</strong><br>
                                <small>{{ $team->members->pluck('name')->join(', ') }}</small>
                            </td>
                            @php 
                                $teamScores = $team->scores->keyBy('hole_number');
                                $frontNineScore = 0;
                                $backNineScore = 0;
                                $totalScore = 0;
                            @endphp
                            @for($hole = 1; $hole <= 9; $hole++)
                                @php 
                                    $score = $teamScores->get($hole)?->strokes ?? null;
                                    if ($score) {
                                        $frontNineScore += $score;
                                        $totalScore += $score;
                                    }
                                @endphp
                                <td>{{ $score ?? '' }}</td>
                            @endfor
                            <td class="total-column">{{ $frontNineScore > 0 ? $frontNineScore : '' }}</td>
                            @if($tournament->holes > 9)
                                @for($hole = 10; $hole <= $tournament->holes; $hole++)
                                    @php 
                                        $score = $teamScores->get($hole)?->strokes ?? null;
                                        if ($score) {
                                            $backNineScore += $score;
                                            $totalScore += $score;
                                        }
                                    @endphp
                                    <td>{{ $score ?? '' }}</td>
                                @endfor
                                <td class="total-column">{{ $backNineScore > 0 ? $backNineScore : '' }}</td>
                            @endif
                            <td class="total-column">{{ $totalScore > 0 ? $totalScore : '' }}</td>
                        </tr>
                    @endforeach
                @else
                    {{-- Show Individual Players --}}
                    @foreach($tournament->entries as $entry)
                        <tr>
                            <td class="player-name-cell">
                                <strong>{{ $entry->user->name }}</strong>
                                @if($entry->handicap)
                                    <br><small>HCP: {{ $entry->handicap }}</small>
                                @endif
                            </td>
                            @php 
                                $playerScores = $entry->scores->keyBy('hole_number');
                                $frontNineScore = 0;
                                $backNineScore = 0;
                                $totalScore = 0;
                            @endphp
                            @for($hole = 1; $hole <= 9; $hole++)
                                @php 
                                    $score = $playerScores->get($hole)?->strokes ?? null;
                                    if ($score) {
                                        $frontNineScore += $score;
                                        $totalScore += $score;
                                    }
                                @endphp
                                <td>{{ $score ?? '' }}</td>
                            @endfor
                            <td class="total-column">{{ $frontNineScore > 0 ? $frontNineScore : '' }}</td>
                            @if($tournament->holes > 9)
                                @for($hole = 10; $hole <= $tournament->holes; $hole++)
                                    @php 
                                        $score = $playerScores->get($hole)?->strokes ?? null;
                                        if ($score) {
                                            $backNineScore += $score;
                                            $totalScore += $score;
                                        }
                                    @endphp
                                    <td>{{ $score ?? '' }}</td>
                                @endfor
                                <td class="total-column">{{ $backNineScore > 0 ? $backNineScore : '' }}</td>
                            @endif
                            <td class="total-column">{{ $totalScore > 0 ? $totalScore : '' }}</td>
                        </tr>
                    @endforeach
                @endif
                
                {{-- Add blank rows for additional players --}}
                @for($i = 0; $i < 6; $i++)
                    <tr>
                        <td class="player-name-cell" style="height: 30px;"></td>
                        @for($hole = 1; $hole <= 9; $hole++)
                            <td></td>
                        @endfor
                        <td class="total-column"></td>
                        @if($tournament->holes > 9)
                            @for($hole = 10; $hole <= $tournament->holes; $hole++)
                                <td></td>
                            @endfor
                            <td class="total-column"></td>
                        @endif
                        <td class="total-column"></td>
                    </tr>
                @endfor
            </tbody>
        </table>
        
        <div class="signature-area">
            <div class="text-center">
                <div class="signature-box"></div>
                <div class="signature-label">Scorekeeper Signature</div>
            </div>
            <div class="text-center">
                <div class="signature-box"></div>
                <div class="signature-label">Date Completed</div>
            </div>
            <div class="text-center">
                <div class="signature-box"></div>
                <div class="signature-label">Tournament Official</div>
            </div>
        </div>
        
        <div class="qr-section">
            <div class="small fw-semibold mb-2">
                <i class="fas fa-qrcode me-1"></i>
                Live Scoring Available via QR Code
            </div>
            <div class="small text-muted">
                Scan QR code for real-time mobile scoring and leaderboard updates
            </div>
        </div>
    </div>
    
    <script>
        // Auto-print when page loads if requested
        if (window.location.search.includes('print=1')) {
            setTimeout(() => window.print(), 500);
        }
    </script>
@endsection