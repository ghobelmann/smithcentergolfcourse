@extends('layouts.print')

@section('content')
    <div class="print-controls no-print mb-4 flex gap-4">
        <button onclick="window.print()" class="px-4 py-2 bg-green-800 text-white rounded">Print</button>
        @if($tournament->number_of_rounds > 1)
            <div class="px-4 py-2 bg-blue-100 text-blue-800 rounded">
                Round {{ $selectedRound }} of {{ $tournament->number_of_rounds }}
            </div>
        @endif
    </div>

    @foreach ($groupedPlayers as $cardKey => $players)
        @php
            // Parse cardKey for display: e.g. "1-A" => Card 1, Sub-Group A
            $parts = explode('-', $cardKey);
            $cardNum = $parts[0];
            $subGroup = $parts[1] ?? null;
        @endphp
        
        {{-- Print scorecards: for Practice rounds or KSHSAA tournaments print one card per group, otherwise print one per player --}}
        @php
            $isPractice = isset($tournament->type) && strtolower($tournament->type) === 'practice';
            $isKSHSAA = stripos($tournament->title, 'KSHSAA') !== false && stripos($tournament->title, 'State') !== false;
            $printOneCardPerGroup = $isPractice || $isKSHSAA;
        @endphp
        
        @if ($printOneCardPerGroup)
            <div class="scorecard-page bg-white">
                @include('tournaments.print-cards-table', [
                    'players' => $players,
                    'tournament' => $tournament,
                    'cardId' => $cardNum,
                    'subGroup' => $subGroup ?? null,
                    'highlightedPlayerId' => null,
                    'selectedRound' => $selectedRound ?? $tournament->current_round,
                    'startingHole' => $startingHoles[$cardKey] ?? $cardNum,
                    'isTeeTime' => $isTeeTime ?? false
                ])
            </div>
        @else
            @foreach ($players as $highlightedPlayer)
                <div class="scorecard-page bg-white">
                    @include('tournaments.print-cards-table', [
                        'players' => $players,
                        'tournament' => $tournament,
                        'cardId' => $cardNum,
                        'subGroup' => $subGroup ?? null,
                        'highlightedPlayerId' => $highlightedPlayer->player_id,
                        'selectedRound' => $selectedRound ?? $tournament->current_round,
                        'startingHole' => $startingHoles[$cardKey] ?? $cardNum,
                        'isTeeTime' => $isTeeTime ?? false
                    ])
                </div>
            @endforeach
        @endif
    @endforeach

    {{-- QR Codes Section - Print after all scorecards --}}
    @php
        // Check if the host school has Pro access (is_paid = 1)
        $hostSchool = \Illuminate\Support\Facades\DB::table('schools')
            ->where('id', $tournament->school_id)
            ->first();
        $hostHasProAccess = $hostSchool && $hostSchool->is_paid;
    @endphp
    
    @if($hostHasProAccess)
    <div class="qr-codes-section bg-white" style="page-break-before: always;">
        <h2 class="text-2xl font-bold text-center mb-6">
            Live Scoring QR Codes
            @if($tournament->number_of_rounds > 1)
                <br><span class="text-lg text-blue-600">Round {{ $selectedRound ?? $tournament->current_round ?? 1 }}</span>
            @endif
        </h2>
        
        <div class="grid grid-cols-5 gap-4">
            @foreach ($groupedPlayers as $cardKey => $players)
                @php
                    $parts = explode('-', $cardKey);
                    $cardNum = $parts[0];
                    $subGroup = $parts[1] ?? null;
                    
                    // Build the live scoring URL
                    $liveUrl = url("/live-scores/{$tournament->id}/{$cardNum}");
                    if ($subGroup) {
                        $liveUrl .= "/{$subGroup}";
                    }
                    
                    // Add round parameter for multi-round tournaments
                    if ($tournament->number_of_rounds > 1) {
                        $roundParam = $selectedRound ?? $tournament->current_round ?? 1;
                        $liveUrl .= "?round={$roundParam}";
                    }
                    
                    // Use QR Server API for QR code generation
                    $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($liveUrl);
                @endphp
                
                <div class="text-center border border-gray-300 p-3 rounded qr-panel">
                    <h3 class="font-bold text-base mb-2">
                        Card {{ $cardNum }}
                        @if($subGroup) {{ $subGroup }} @endif
                        @if($tournament->number_of_rounds > 1)
                            <br><span class="text-sm text-blue-600">Round {{ $selectedRound ?? $tournament->current_round ?? 1 }}</span>
                        @endif
                    </h3>
                    <img src="{{ $qrCodeUrl }}" alt="QR Code for Card {{ $cardNum }}" class="mx-auto mb-2" style="width: 80px; height: 80px;">
                    <div class="text-xs text-gray-500">
                        <strong>Players:</strong><br>
                        @foreach($players as $index => $player)
                            {{ $player->player_name }}@if(!$loop->last), @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @else
    {{-- Pro Feature Notice for QR Codes --}}
    <div class="qr-codes-section bg-white" style="page-break-before: always;">
        <div class="text-center p-8">
            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-yellow-400 to-orange-500 text-white mb-4">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                PRO FEATURE
            </div>
            
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Live Scoring QR Codes</h2>
            <div class="max-w-md mx-auto bg-gray-100 rounded-lg p-6 border-2 border-dashed border-gray-300">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <p class="text-gray-600 text-sm mb-4">
                    QR codes for live mobile scoring are only available for tournaments hosted by Pro schools.
                </p>

                <!-- Pro Features List -->
                <div class="text-left mb-6">
                    <h4 class="font-semibold text-gray-900 mb-3">Pro Features Include:</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Live Mobile Scoring with QR Codes
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Auto Email Roster Entry
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Practice Rounds & Player Stats
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Individual State Rankings for KGCA All-State
                        </li>
                    </ul>
                </div>

                <p class="text-gray-600 text-sm mb-4">
                    Click on the KGCA Button to obtain a membership.
                </p>
            </div>
        </div>
    </div>
    @endif

    <style>
    @media print {
        .no-print { display: none !important; }
        
        body {
            font-size: 10px;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .scorecard-page {
            margin: 0 !important;
            padding: 0 !important;
            page-break-inside: avoid;
            width: 100%;
        }
        
        .qr-codes-section {
            page-break-before: always !important;
            padding: 20px !important;
            font-size: 12px !important;
        }
        
        .qr-codes-section h2 {
            font-size: 24px !important;
            margin-bottom: 20px !important;
        }
        
        .qr-codes-section .grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr !important;
            gap: 15px !important;
        }
        
        .qr-panel {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
    }
    </style>
@endsection
