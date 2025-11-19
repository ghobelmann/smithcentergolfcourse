@extends('layouts.app')

@section('title', $league->name . ' - Week ' . $weekNumber)

@section('content')
<div class="py-12 bg-gradient-to-b from-green-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('leagues.standings', $league) }}" class="text-green-600 hover:text-green-700 font-medium mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Back to Standings
            </a>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500 mb-1">{{ $league->name }}</div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">
                            Week {{ $weekNumber }} Results
                        </h1>
                        <p class="text-gray-600">{{ \Carbon\Carbon::parse($tournament->date)->format('l, F d, Y') }}</p>
                    </div>
                    <a href="{{ route('tournaments.show', $tournament) }}" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-golf-ball mr-2"></i>View Tournament
                    </a>
                </div>
            </div>
        </div>

        <!-- Weekly Results -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Team Results</h2>
                <p class="text-gray-600 mt-1">2-Man Four Ball Format</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Position</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Player</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Score</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Vs Par</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Points Earned</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($teamResults as $result)
                            <tr class="hover:bg-gray-50 transition {{ $result['position'] <= 3 ? 'bg-yellow-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg
                                            {{ $result['position'] === 1 ? 'bg-yellow-400 text-yellow-900' : '' }}
                                            {{ $result['position'] === 2 ? 'bg-gray-300 text-gray-700' : '' }}
                                            {{ $result['position'] === 3 ? 'bg-orange-400 text-orange-900' : '' }}
                                            {{ $result['position'] > 3 ? 'bg-gray-100 text-gray-600' : '' }}">
                                            @if($result['position'] === 1)
                                                <i class="fas fa-trophy"></i>
                                            @else
                                                {{ $result['position'] }}
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $result['user']->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-lg font-bold text-gray-900">{{ $result['score'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $vsPar = $result['vs_par'];
                                        $colorClass = $vsPar < 0 ? 'text-green-600' : ($vsPar > 0 ? 'text-red-600' : 'text-gray-900');
                                        $display = $vsPar == 0 ? 'E' : ($vsPar > 0 ? '+' . $vsPar : $vsPar);
                                    @endphp
                                    <span class="text-lg font-bold {{ $colorClass }}">{{ $display }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold bg-green-100 text-green-800">
                                        {{ $result['points'] }} pts
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-golf-ball text-4xl mb-3"></i>
                                    <p class="text-lg">No results available yet</p>
                                    <p class="text-sm">Results will appear after scores are entered</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Navigation to Other Weeks -->
        @if($league->tournaments->count() > 1)
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Other Weeks</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @foreach($league->tournaments->sortBy('week_number') as $otherTournament)
                        @if($otherTournament->status === 'completed')
                            <a href="{{ route('leagues.weekly', [$league, $otherTournament->week_number]) }}" 
                               class="p-4 rounded-lg text-center transition
                                      {{ $otherTournament->week_number === $weekNumber ? 'bg-green-100 border-2 border-green-500' : 'bg-gray-50 hover:bg-green-50 border-2 border-transparent hover:border-green-300' }}">
                                <div class="font-bold text-gray-900">Week {{ $otherTournament->week_number }}</div>
                                <div class="text-xs text-gray-600 mt-1">{{ \Carbon\Carbon::parse($otherTournament->date)->format('M d') }}</div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
