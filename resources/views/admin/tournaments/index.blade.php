@extends('layouts.app')

@section('content')
<!-- Admin Header -->
<section class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-emerald-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-emerald-200 hover:text-white mb-2 inline-block">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
                <h1 class="text-4xl font-display text-white mb-2">Manage Tournaments</h1>
                <p class="text-emerald-200">View, create, edit, and delete tournaments</p>
            </div>
            <a href="{{ route('admin.tournaments.create') }}" class="px-6 py-3 bg-white text-emerald-700 rounded-lg font-semibold hover:bg-emerald-50 transition">
                <i class="fas fa-plus mr-2"></i>Create Tournament
            </a>
        </div>
    </div>
</section>

<!-- Success Message -->
@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded">
            <div class="flex">
                <i class="fas fa-check-circle text-emerald-500 mt-0.5 mr-3"></i>
                <p class="text-emerald-700">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

<!-- Tournaments List -->
<section class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($tournaments->count() > 0)
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tournament
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Entries
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Entry Fee
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tournaments as $tournament)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-trophy text-emerald-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $tournament->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $tournament->holes }} holes • {{ $tournament->format }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($tournament->start_date)->format('M j, Y') }}
                                    </div>
                                    @if($tournament->start_date !== $tournament->end_date)
                                        <div class="text-xs text-gray-500">
                                            to {{ \Carbon\Carbon::parse($tournament->end_date)->format('M j, Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($tournament->status === 'upcoming')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Upcoming
                                        </span>
                                    @elseif($tournament->status === 'active')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Completed
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $tournament->entries->count() }}
                                    @if($tournament->max_participants)
                                        <span class="text-gray-500">/ {{ $tournament->max_participants }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($tournament->entry_fee, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('tournaments.show', $tournament) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.tournaments.edit', $tournament) }}" class="text-emerald-600 hover:text-emerald-900 mr-3" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.tournaments.destroy', $tournament) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this tournament?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $tournaments->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <i class="fas fa-trophy text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Tournaments Yet</h3>
                <p class="text-gray-600 mb-6">Get started by creating your first tournament</p>
                <a href="{{ route('admin.tournaments.create') }}" class="inline-block px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                    <i class="fas fa-plus mr-2"></i>Create Tournament
                </a>
            </div>
        @endif

    </div>
</section>
@endsection
