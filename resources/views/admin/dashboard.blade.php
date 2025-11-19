@extends('layouts.app')

@section('content')
<!-- Admin Header -->
<section class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-display text-white mb-2">Admin Dashboard</h1>
                <p class="text-gray-300">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <div class="text-right">
                <p class="text-gray-400 text-sm">Last login</p>
                <p class="text-white">{{ now()->format('F j, Y g:i A') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Cards -->
<section class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Total Users -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold uppercase">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-4">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold mt-4 inline-block">
                    Manage Users →
                </a>
            </div>

            <!-- Tournaments -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-emerald-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold uppercase">Upcoming Tournaments</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['upcoming_tournaments'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">of {{ $stats['total_tournaments'] }} total</p>
                    </div>
                    <div class="bg-emerald-100 rounded-full p-4">
                        <i class="fas fa-trophy text-emerald-600 text-2xl"></i>
                    </div>
                </div>
                <a href="{{ route('admin.tournaments.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-semibold mt-4 inline-block">
                    Manage Tournaments →
                </a>
            </div>

            <!-- Active Leagues -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold uppercase">Active Leagues</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['active_leagues'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">of {{ $stats['total_leagues'] }} total</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-4">
                        <i class="fas fa-calendar-alt text-purple-600 text-2xl"></i>
                    </div>
                </div>
                <a href="{{ route('admin.leagues.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-semibold mt-4 inline-block">
                    Manage Leagues →
                </a>
            </div>

        </div>
    </div>
</section>

<!-- Quick Actions -->
<section class="py-8 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-display text-gray-900 mb-6">Quick Actions</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <a href="{{ route('admin.tournaments.create') }}" class="bg-gradient-to-br from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-xl p-6 shadow-lg transition group">
                <div class="flex items-center justify-between mb-3">
                    <i class="fas fa-plus-circle text-3xl"></i>
                    <i class="fas fa-arrow-right opacity-0 group-hover:opacity-100 transition"></i>
                </div>
                <h3 class="text-lg font-semibold">Create Tournament</h3>
                <p class="text-emerald-100 text-sm mt-1">Set up a new tournament</p>
            </a>

            <a href="{{ route('admin.leagues.create') }}" class="bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-xl p-6 shadow-lg transition group">
                <div class="flex items-center justify-between mb-3">
                    <i class="fas fa-plus-circle text-3xl"></i>
                    <i class="fas fa-arrow-right opacity-0 group-hover:opacity-100 transition"></i>
                </div>
                <h3 class="text-lg font-semibold">Create League</h3>
                <p class="text-purple-100 text-sm mt-1">Start a new league</p>
            </a>

            <a href="{{ route('admin.users.index') }}" class="bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl p-6 shadow-lg transition group">
                <div class="flex items-center justify-between mb-3">
                    <i class="fas fa-users-cog text-3xl"></i>
                    <i class="fas fa-arrow-right opacity-0 group-hover:opacity-100 transition"></i>
                </div>
                <h3 class="text-lg font-semibold">Manage Users</h3>
                <p class="text-blue-100 text-sm mt-1">View and edit users</p>
            </a>

            <a href="{{ route('tournaments.index') }}" class="bg-gradient-to-br from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-xl p-6 shadow-lg transition group">
                <div class="flex items-center justify-between mb-3">
                    <i class="fas fa-eye text-3xl"></i>
                    <i class="fas fa-arrow-right opacity-0 group-hover:opacity-100 transition"></i>
                </div>
                <h3 class="text-lg font-semibold">View Public Site</h3>
                <p class="text-gray-300 text-sm mt-1">See tournaments page</p>
            </a>

        </div>
    </div>
</section>

<!-- Recent Activity -->
<section class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Upcoming Tournaments -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-display text-gray-900">Upcoming Tournaments</h2>
                    <a href="{{ route('admin.tournaments.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-semibold">
                        View All →
                    </a>
                </div>
                
                @if($upcoming_tournaments->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcoming_tournaments as $tournament)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-emerald-100 rounded-lg p-3">
                                        <i class="fas fa-trophy text-emerald-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $tournament->name }}</h3>
                                        <p class="text-sm text-gray-600">
                                            <i class="far fa-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($tournament->start_date)->format('M j, Y') }}
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.tournaments.edit', $tournament) }}" class="text-gray-600 hover:text-emerald-600">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-trophy text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">No upcoming tournaments</p>
                        <a href="{{ route('admin.tournaments.create') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-semibold mt-2 inline-block">
                            Create One →
                        </a>
                    </div>
                @endif
            </div>

            <!-- Recent Users -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-display text-gray-900">Recent Users</h2>
                    <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                        View All →
                    </a>
                </div>
                
                @if($recent_users->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_users as $user)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-blue-100 rounded-full p-3">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($user->is_admin)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Admin
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-users text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">No users yet</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

<!-- Active Leagues -->
@if($active_leagues->count() > 0)
<section class="py-8 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-display text-gray-900">Active Leagues</h2>
            <a href="{{ route('admin.leagues.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-semibold">
                Manage All →
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($active_leagues as $league)
                <div class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-purple-500 transition">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-purple-100 rounded-lg p-3">
                            <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                            Active
                        </span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $league->name }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $league->type }}</p>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">
                            <i class="fas fa-users mr-1"></i>
                            {{ $league->members_count }} members
                        </span>
                        <a href="{{ route('admin.leagues.edit', $league) }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                            Manage →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
