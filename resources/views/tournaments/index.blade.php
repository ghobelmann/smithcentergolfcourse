@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 py-20">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80" 
             alt="Golf Course" 
             class="w-full h-full object-cover opacity-40">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl sm:text-6xl font-display text-white mb-6">Tournaments</h1>
        <p class="text-xl text-gray-200 max-w-3xl mx-auto">
            Join our competitive golf tournaments
        </p>
    </div>
</section>

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-display">Upcoming Tournaments</h2>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('tournaments.create') }}" class="px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                        <i class="fas fa-plus mr-2"></i>Create Tournament
                    </a>
                @endif
            @endauth
        </div>

        @if($tournaments->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tournaments as $tournament)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col">
                        <div class="bg-emerald-600 text-white p-6">
                            <h3 class="text-xl font-display mb-2">{{ $tournament->name }}</h3>
                            <div>
                                @if($tournament->status === 'upcoming')
                                    <span class="inline-block px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full">Upcoming</span>
                                @elseif($tournament->status === 'active')
                                    <span class="inline-block px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">Active</span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-gray-500 text-white text-xs font-semibold rounded-full">Completed</span>
                                @endif
                            </div>
                        </div>
                        <div class="p-6 flex-grow">
                            @if($tournament->description)
                                <p class="text-gray-600 mb-4">{{ Str::limit($tournament->description, 100) }}</p>
                            @endif
                            
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar mr-2 text-emerald-600"></i>
                                    {{ $tournament->start_date->format('M j, Y') }}
                                    @if($tournament->start_date->format('Y-m-d') !== $tournament->end_date->format('Y-m-d'))
                                        - {{ $tournament->end_date->format('M j, Y') }}
                                    @endif
                                </div>
                                
                                <div class="flex items-center">
                                    <i class="fas fa-users mr-2 text-emerald-600"></i>
                                    {{ $tournament->entries_count }} 
                                    @if($tournament->max_participants)
                                        / {{ $tournament->max_participants }}
                                    @endif
                                    participants
                                </div>

                                <div class="flex items-center">
                                    <i class="fas fa-golf-ball mr-2 text-emerald-600"></i>
                                    {{ $tournament->holes }} holes - {{ $tournament->getFormatDescription() }}
                                </div>

                                @if($tournament->entry_fee > 0)
                                    <div class="flex items-center">
                                        <i class="fas fa-dollar-sign mr-2 text-emerald-600"></i>
                                        Entry Fee: ${{ number_format($tournament->entry_fee, 2) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="p-6 bg-gray-50 border-t border-gray-200">
                            <div class="flex gap-2">
                                <a href="{{ route('tournaments.show', $tournament) }}" class="flex-1 text-center px-4 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                @if($tournament->status !== 'upcoming')
                                    <a href="{{ route('tournaments.leaderboard', $tournament) }}" class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                        <i class="fas fa-list-ol mr-1"></i>Leaderboard
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-center mt-8">
                {{ $tournaments->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-trophy text-6xl text-gray-300 mb-6"></i>
                <h3 class="text-2xl font-display text-gray-600 mb-2">No tournaments yet</h3>
                <p class="text-gray-500 mb-6">Be the first to create a tournament!</p>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('tournaments.create') }}" class="inline-block px-8 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                            <i class="fas fa-plus mr-2"></i>Create Tournament
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</section>
@endsection