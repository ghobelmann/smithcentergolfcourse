@extends('layouts.app')

@section('title', $league->name . ' - Roster')

@section('content')
<div class="py-12 bg-gradient-to-b from-green-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('leagues.show', $league) }}" class="text-green-600 hover:text-green-700 font-medium mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Back to League
            </a>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">
                            <i class="fas fa-users text-blue-600 mr-3"></i>
                            League Roster
                        </h1>
                        <p class="text-gray-600">{{ $league->name }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900">{{ intval($members->count() / 2) }}</div>
                        <div class="text-sm text-gray-500">Teams Enrolled</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teams List -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($teams as $index => $team)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-3">
                        <h3 class="text-white font-bold text-lg">Team {{ $index + 1 }}</h3>
                    </div>
                    <div class="p-6">
                        <!-- Player 1 -->
                        <div class="mb-4 pb-4 border-b border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                        <i class="fas fa-user text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-lg">{{ $team['player1']->user->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $team['player1']->user->email }}</div>
                                    </div>
                                </div>
                                @if($team['player1']->handicap)
                                    <div class="text-right">
                                        <div class="text-xs text-gray-500">Handicap</div>
                                        <div class="font-bold text-gray-900">{{ number_format($team['player1']->handicap, 1) }}</div>
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center text-sm text-gray-600 mt-2">
                                <i class="fas fa-calendar-check w-4 mr-2"></i>
                                <span>Joined {{ \Carbon\Carbon::parse($team['player1']->joined_date)->format('M d, Y') }}</span>
                            </div>
                            @if($team['player1']->weeks_played > 0)
                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                    <i class="fas fa-golf-ball w-4 mr-2"></i>
                                    <span>{{ $team['player1']->weeks_played }} weeks played</span>
                                </div>
                            @endif
                            @if($team['player1']->season_fee_paid >= $league->season_fee)
                                <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-2">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Season Fee Paid
                                </div>
                            @else
                                <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-2">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Fee: ${{ number_format($team['player1']->season_fee_paid, 2) }} / ${{ number_format($league->season_fee, 2) }}
                                </div>
                            @endif
                        </div>

                        <!-- Player 2 -->
                        @if($team['player2'])
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                            <i class="fas fa-user text-green-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 text-lg">{{ $team['player2']->user->name }}</div>
                                            <div class="text-sm text-gray-600">{{ $team['player2']->user->email }}</div>
                                        </div>
                                    </div>
                                    @if($team['player2']->handicap)
                                        <div class="text-right">
                                            <div class="text-xs text-gray-500">Handicap</div>
                                            <div class="font-bold text-gray-900">{{ number_format($team['player2']->handicap, 1) }}</div>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center text-sm text-gray-600 mt-2">
                                    <i class="fas fa-calendar-check w-4 mr-2"></i>
                                    <span>Joined {{ \Carbon\Carbon::parse($team['player2']->joined_date)->format('M d, Y') }}</span>
                                </div>
                                @if($team['player2']->weeks_played > 0)
                                    <div class="flex items-center text-sm text-gray-600 mt-1">
                                        <i class="fas fa-golf-ball w-4 mr-2"></i>
                                        <span>{{ $team['player2']->weeks_played }} weeks played</span>
                                    </div>
                                @endif
                                @if($team['player2']->season_fee_paid >= $league->season_fee)
                                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-2">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Season Fee Paid
                                    </div>
                                @else
                                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-2">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        Fee: ${{ number_format($team['player2']->season_fee_paid, 2) }} / ${{ number_format($league->season_fee, 2) }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4 text-gray-500">
                                <i class="fas fa-user-plus text-2xl mb-2"></i>
                                <p class="text-sm">Looking for partner</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-2 bg-white rounded-lg shadow-lg p-12 text-center">
                    <i class="fas fa-users-slash text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-2xl font-semibold text-gray-700 mb-2">No Members Yet</h3>
                    <p class="text-gray-500 mb-6">Be the first to join this league!</p>
                    @auth
                        @if(!$league->hasMember(auth()->user()))
                            <a href="{{ route('leagues.show', $league) }}" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
                                <i class="fas fa-user-plus mr-2"></i>
                                Join League
                            </a>
                        @endif
                    @endauth
                </div>
            @endforelse
        </div>

        <!-- Summary Stats -->
        @if($members->count() > 0)
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">League Statistics</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $members->count() }}</div>
                        <div class="text-sm text-gray-600">Total Players</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ intval($members->count() / 2) }}</div>
                        <div class="text-sm text-gray-600">Teams</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600">
                            {{ $members->where('season_fee_paid', '>=', $league->season_fee)->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Fees Paid</div>
                    </div>
                    <div class="text-center">
                        @php
                            $avgHandicap = $members->whereNotNull('handicap')->avg('handicap');
                        @endphp
                        <div class="text-3xl font-bold text-orange-600">
                            {{ $avgHandicap ? number_format($avgHandicap, 1) : 'N/A' }}
                        </div>
                        <div class="text-sm text-gray-600">Avg Handicap</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
