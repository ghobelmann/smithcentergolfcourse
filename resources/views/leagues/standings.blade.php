@extends('layouts.app')

@section('title', $league->name . ' - Standings')

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
                            <i class="fas fa-trophy text-yellow-500 mr-3"></i>
                            {{ $league->name }}
                        </h1>
                        <p class="text-gray-600">Season Standings</p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Last Updated</div>
                        <div class="font-semibold text-gray-900">{{ now()->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Standings Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Team Standings</h2>
                <p class="text-gray-600 mt-1">2-Man Four Ball Format</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Position</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Team</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Weeks Played</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Points</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Best Score</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Avg Points/Week</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($teamStandings as $index => $team)
                            <tr class="hover:bg-gray-50 transition {{ $index < 3 ? 'bg-yellow-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg
                                            {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : '' }}
                                            {{ $index === 1 ? 'bg-gray-300 text-gray-700' : '' }}
                                            {{ $index === 2 ? 'bg-orange-400 text-orange-900' : '' }}
                                            {{ $index > 2 ? 'bg-gray-100 text-gray-600' : '' }}">
                                            @if($index === 0)
                                                <i class="fas fa-trophy"></i>
                                            @elseif($index === 1)
                                                <i class="fas fa-medal"></i>
                                            @elseif($index === 2)
                                                <i class="fas fa-award"></i>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $team['player1']->name }}</div>
                                            <div class="text-gray-600">{{ $team['player2']->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $team['weeks_played'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-2xl font-bold text-gray-900">{{ $team['total_points'] }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($team['best_score'])
                                        <span class="font-medium text-gray-900">{{ $team['best_score'] }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-medium text-gray-700">
                                        {{ $team['weeks_played'] > 0 ? number_format($team['total_points'] / $team['weeks_played'], 1) : '0.0' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-chart-line text-4xl mb-3"></i>
                                    <p class="text-lg">No standings available yet</p>
                                    <p class="text-sm">Standings will appear after the first week is completed</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Championship Standings (if applicable) -->
        @if($championshipStandings && $championshipStandings->count() > 0)
            <div class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-yellow-50 to-orange-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-crown text-yellow-500 mr-3"></i>
                                Championship Standings
                            </h2>
                            <p class="text-gray-600 mt-1">Based on best {{ $league->weeks_count_for_championship }} weeks</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Position</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Player</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Championship Points</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Weeks Counted</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Best Weeks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($championshipStandings as $index => $standing)
                                <tr class="hover:bg-gray-50 transition {{ $index === 0 ? 'bg-yellow-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg
                                            {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : 'bg-gray-100 text-gray-600' }}">
                                            @if($index === 0)
                                                <i class="fas fa-crown"></i>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $standing['user']->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="text-2xl font-bold text-yellow-600">{{ $standing['championship_points'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            {{ $standing['weeks_counted'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($standing['best_weeks'] as $week)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-700">
                                                    W{{ $week }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Weekly Results -->
        @if($league->tournaments->where('status', 'completed')->count() > 0)
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-calendar-week text-blue-600 mr-2"></i>
                    Weekly Results
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @foreach($league->tournaments->where('status', 'completed')->sortBy('week_number') as $tournament)
                        <a href="{{ route('leagues.weekly', [$league, $tournament->week_number]) }}" 
                           class="p-4 rounded-lg bg-gray-50 hover:bg-green-50 border-2 border-transparent hover:border-green-300 transition text-center">
                            <div class="font-bold text-gray-900">Week {{ $tournament->week_number }}</div>
                            <div class="text-xs text-gray-600 mt-1">{{ \Carbon\Carbon::parse($tournament->date)->format('M d') }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
