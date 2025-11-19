@extends('layouts.app')

@section('title', $league->name)

@section('content')
<div class="py-12 bg-gradient-to-b from-green-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('leagues.index') }}" class="text-green-600 hover:text-green-700 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Leagues
                </a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="flex gap-2">
                            <a href="{{ route('leagues.edit', $league) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                            @if($league->tournaments->count() === 0)
                                <form action="{{ route('leagues.generate-tournaments', $league) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                        <i class="fas fa-calendar-plus mr-2"></i>Generate Tournaments
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                @endauth
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $league->type === 'mens' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $league->type === 'womens' ? 'bg-pink-100 text-pink-800' : '' }}
                                {{ $league->type === 'mixed' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ $league->getTypeLabel() }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $league->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $league->status === 'draft' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $league->status === 'completed' ? 'bg-gray-100 text-gray-600' : '' }}">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                {{ ucfirst($league->status) }}
                            </span>
                        </div>

                        <h1 class="text-4xl font-bold text-gray-900 mb-4">
                            {{ $league->name }}
                        </h1>

                        @if($league->description)
                            <p class="text-lg text-gray-600 mb-6">
                                {{ $league->description }}
                            </p>
                        @endif

                        <!-- League Info Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="flex items-center">
                                <div class="bg-green-100 rounded-lg p-3 mr-4">
                                    <i class="fas fa-calendar-alt text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Schedule</div>
                                    <div class="font-semibold text-gray-900">{{ $league->day_of_week }}s at {{ \Carbon\Carbon::parse($league->tee_time)->format('g:i A') }}</div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-lg p-3 mr-4">
                                    <i class="fas fa-flag text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Format</div>
                                    <div class="font-semibold text-gray-900">{{ $league->holes }} Holes - 2-Man Four Ball</div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="bg-purple-100 rounded-lg p-3 mr-4">
                                    <i class="fas fa-users text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Teams Enrolled</div>
                                    <div class="font-semibold text-gray-900">
                                        {{ intval($league->members->count() / 2) }}
                                        @if($league->max_members)
                                            / {{ intval($league->max_members / 2) }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Season Progress -->
                        @if($league->isActive())
                            <div class="mb-6">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Week {{ $currentWeek }} of {{ $totalWeeks }}</span>
                                    <span>{{ round(($currentWeek / $totalWeeks) * 100) }}% Complete</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-green-600 h-3 rounded-full" style="width: {{ ($currentWeek / $totalWeeks) * 100 }}%"></div>
                                </div>
                            </div>
                        @endif

                        <!-- Fees -->
                        @if($league->season_fee || $league->entry_fee_per_week)
                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                <h3 class="font-semibold text-gray-900 mb-2">League Fees</h3>
                                <div class="space-y-1 text-gray-700">
                                    @if($league->season_fee)
                                        <div class="flex justify-between">
                                            <span>Season Fee:</span>
                                            <span class="font-medium">${{ number_format($league->season_fee, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($league->entry_fee_per_week)
                                        <div class="flex justify-between">
                                            <span>Weekly Entry:</span>
                                            <span class="font-medium">${{ number_format($league->entry_fee_per_week, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                @auth
                    <div class="border-t pt-6 mt-6">
                        @if($isMember)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-green-600">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    <span class="font-medium">You're enrolled in this league</span>
                                    @if($teamPartner)
                                        <span class="ml-2 text-gray-600">with {{ $teamPartner->name }}</span>
                                    @endif
                                </div>
                                @if($league->isDraft() || $league->tournaments()->where('status', 'upcoming')->count() === 0)
                                    <form action="{{ route('leagues.unenroll', $league) }}" method="POST" onsubmit="return confirm('Are you sure you want to withdraw from this league?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition">
                                            <i class="fas fa-times mr-2"></i>Withdraw
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            @if($league->hasSpaceAvailable() && !$league->isCompleted())
                                <form action="{{ route('leagues.enroll', $league) }}" method="POST">
                                    @csrf
                                    <div class="flex items-end gap-4">
                                        <div class="flex-1">
                                            <label for="handicap" class="block text-sm font-medium text-gray-700 mb-2">
                                                Your Handicap (optional)
                                            </label>
                                            <input type="number" name="handicap" id="handicap" step="0.1" min="0" max="54" 
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                                placeholder="e.g., 12.5">
                                        </div>
                                        <button type="submit" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
                                            <i class="fas fa-user-plus mr-2"></i>Join League
                                        </button>
                                    </div>
                                </form>
                            @elseif($league->isCompleted())
                                <div class="text-gray-600 text-center">
                                    <i class="fas fa-flag-checkered mr-2"></i>
                                    This league has been completed
                                </div>
                            @else
                                <div class="text-red-600 text-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    This league is full
                                </div>
                            @endif
                        @endif
                    </div>
                @else
                    <div class="border-t pt-6 mt-6 text-center">
                        <p class="text-gray-600 mb-4">Please log in to join this league</p>
                        <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
                            Log In
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Current Week -->
                @if($league->isActive() && $currentWeek)
                    @php
                        $currentTournament = $league->tournaments->where('week_number', $currentWeek)->first();
                    @endphp
                    @if($currentTournament)
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                                <i class="fas fa-calendar-day text-green-600 mr-2"></i>
                                This Week - Week {{ $currentWeek }}
                            </h2>
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-lg font-semibold text-gray-900">{{ $currentTournament->name }}</div>
                                    <div class="text-gray-600">{{ \Carbon\Carbon::parse($currentTournament->date)->format('l, M d, Y') }}</div>
                                    <div class="text-gray-600">Tee Time: {{ \Carbon\Carbon::parse($currentTournament->tee_time)->format('g:i A') }}</div>
                                </div>
                                <a href="{{ route('tournaments.show', $currentTournament) }}" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                                    View Tournament
                                </a>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Season Schedule -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                        Season Schedule
                    </h2>
                    @if($league->tournaments->count() > 0)
                        <div class="space-y-3">
                            @foreach($league->tournaments as $tournament)
                                <div class="flex items-center justify-between p-4 rounded-lg {{ $tournament->week_number === $currentWeek ? 'bg-green-50 border-2 border-green-200' : 'bg-gray-50' }}">
                                    <div class="flex items-center">
                                        <div class="text-lg font-bold text-gray-700 mr-4 w-20">
                                            Week {{ $tournament->week_number }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($tournament->date)->format('M d, Y') }}</div>
                                            <div class="text-sm text-gray-600">{{ $tournament->status === 'completed' ? 'Completed' : 'Upcoming' }}</div>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        @if($tournament->status === 'completed')
                                            <a href="{{ route('leagues.weekly', [$league, $tournament->week_number]) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition text-sm">
                                                Results
                                            </a>
                                        @endif
                                        <a href="{{ route('tournaments.show', $tournament) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition text-sm">
                                            Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-calendar-times text-4xl mb-3"></i>
                            <p>No tournaments scheduled yet</p>
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <form action="{{ route('leagues.generate-tournaments', $league) }}" method="POST" class="mt-4">
                                        @csrf
                                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                            <i class="fas fa-calendar-plus mr-2"></i>Generate Schedule
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Current Standings -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900">
                            <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                            Top Teams
                        </h2>
                        <a href="{{ route('leagues.standings', $league) }}" class="text-green-600 hover:text-green-700 font-medium text-sm">
                            View All
                        </a>
                    </div>
                    @if($standings->count() > 0)
                        <div class="space-y-3">
                            @foreach($standings->take(5) as $index => $standing)
                                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold mr-3
                                            {{ $index === 0 ? 'bg-yellow-100 text-yellow-700' : '' }}
                                            {{ $index === 1 ? 'bg-gray-100 text-gray-700' : '' }}
                                            {{ $index === 2 ? 'bg-orange-100 text-orange-700' : '' }}
                                            {{ $index > 2 ? 'bg-gray-50 text-gray-600' : '' }}">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $standing->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $standing->weeks_played }} weeks</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-gray-900">{{ $standing->total_points }} pts</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-chart-line text-3xl mb-2"></i>
                            <p class="text-sm">No standings yet</p>
                        </div>
                    @endif
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Links</h2>
                    <div class="space-y-2">
                        <a href="{{ route('leagues.roster', $league) }}" class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                            <i class="fas fa-users w-5 text-gray-600"></i>
                            <span class="ml-3 text-gray-700 font-medium">View Roster</span>
                        </a>
                        <a href="{{ route('leagues.standings', $league) }}" class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                            <i class="fas fa-list-ol w-5 text-gray-600"></i>
                            <span class="ml-3 text-gray-700 font-medium">Full Standings</span>
                        </a>
                        @if($league->tournaments->count() > 0)
                            <a href="{{ route('tournaments.index') }}" class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                                <i class="fas fa-calendar-alt w-5 text-gray-600"></i>
                                <span class="ml-3 text-gray-700 font-medium">All Tournaments</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
