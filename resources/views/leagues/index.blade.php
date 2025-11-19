@extends('layouts.app')

@section('title', 'Leagues')

@section('content')
<div class="py-12 bg-gradient-to-b from-green-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Golf Leagues
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Join our competitive and fun leagues! 2-man four ball format.
            </p>
            @auth
                @if(auth()->user()->isAdmin())
                    <div class="mt-6">
                        <a href="{{ route('leagues.create') }}" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
                            <i class="fas fa-plus mr-2"></i>
                            Create New League
                        </a>
                    </div>
                @endif
            @endauth
        </div>

        <!-- Active Leagues -->
        @if($activeLeagues->count() > 0)
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-trophy text-yellow-500 mr-3"></i>
                    Active Leagues
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activeLeagues as $league)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            <div class="p-6">
                                <!-- League Type Badge -->
                                <div class="flex items-center justify-between mb-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $league->type === 'mens' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $league->type === 'womens' ? 'bg-pink-100 text-pink-800' : '' }}
                                        {{ $league->type === 'mixed' ? 'bg-purple-100 text-purple-800' : '' }}">
                                        <i class="fas fa-users mr-1"></i>
                                        {{ $league->getTypeLabel() }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-circle text-green-500 mr-1 text-xs"></i>
                                        Active
                                    </span>
                                </div>

                                <!-- League Name -->
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                    {{ $league->name }}
                                </h3>

                                <!-- Description -->
                                @if($league->description)
                                    <p class="text-gray-600 mb-4 line-clamp-2">
                                        {{ $league->description }}
                                    </p>
                                @endif

                                <!-- Schedule Info -->
                                <div class="space-y-2 mb-4 text-sm text-gray-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt w-5 text-gray-400"></i>
                                        <span class="ml-2">{{ $league->day_of_week }}s at {{ \Carbon\Carbon::parse($league->tee_time)->format('g:i A') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-flag w-5 text-gray-400"></i>
                                        <span class="ml-2">{{ $league->holes }} Holes</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-users w-5 text-gray-400"></i>
                                        <span class="ml-2">{{ $league->members_count }} Members</span>
                                        @if($league->max_members)
                                            <span class="text-gray-500">/ {{ $league->max_members }} max</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Season Dates -->
                                <div class="text-xs text-gray-500 mb-4">
                                    {{ \Carbon\Carbon::parse($league->season_start)->format('M d') }} - 
                                    {{ \Carbon\Carbon::parse($league->season_end)->format('M d, Y') }}
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('leagues.show', $league) }}" class="flex-1 text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                                        View Details
                                    </a>
                                    <a href="{{ route('leagues.standings', $league) }}" class="flex-1 text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                                        Standings
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Upcoming Leagues -->
        @if($upcomingLeagues->count() > 0)
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-clock text-blue-500 mr-3"></i>
                    Upcoming Leagues
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($upcomingLeagues as $league)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $league->type === 'mens' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $league->type === 'womens' ? 'bg-pink-100 text-pink-800' : '' }}
                                        {{ $league->type === 'mixed' ? 'bg-purple-100 text-purple-800' : '' }}">
                                        {{ $league->getTypeLabel() }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Coming Soon
                                    </span>
                                </div>

                                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                    {{ $league->name }}
                                </h3>

                                @if($league->description)
                                    <p class="text-gray-600 mb-4 line-clamp-2">
                                        {{ $league->description }}
                                    </p>
                                @endif

                                <div class="space-y-2 mb-4 text-sm text-gray-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt w-5 text-gray-400"></i>
                                        <span class="ml-2">Starts {{ \Carbon\Carbon::parse($league->season_start)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-users w-5 text-gray-400"></i>
                                        <span class="ml-2">{{ $league->members_count }} Registered</span>
                                    </div>
                                </div>

                                <a href="{{ route('leagues.show', $league) }}" class="block text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                                    Register Now
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Completed Leagues -->
        @if($completedLeagues->count() > 0)
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-check-circle text-gray-500 mr-3"></i>
                    Past Leagues
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($completedLeagues as $league)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition opacity-90">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $league->type === 'mens' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $league->type === 'womens' ? 'bg-pink-100 text-pink-800' : '' }}
                                        {{ $league->type === 'mixed' ? 'bg-purple-100 text-purple-800' : '' }}">
                                        {{ $league->getTypeLabel() }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        Completed
                                    </span>
                                </div>

                                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                    {{ $league->name }}
                                </h3>

                                <div class="text-sm text-gray-500 mb-4">
                                    Ended {{ \Carbon\Carbon::parse($league->season_end)->format('M d, Y') }}
                                </div>

                                <a href="{{ route('leagues.standings', $league) }}" class="block text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                                    Final Standings
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Empty State -->
        @if($activeLeagues->count() === 0 && $upcomingLeagues->count() === 0 && $completedLeagues->count() === 0)
            <div class="text-center py-16">
                <i class="fas fa-golf-ball text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-2xl font-semibold text-gray-700 mb-2">No Leagues Yet</h3>
                <p class="text-gray-500 mb-6">Check back soon for upcoming league information!</p>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('leagues.create') }}" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
                            <i class="fas fa-plus mr-2"></i>
                            Create First League
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection
