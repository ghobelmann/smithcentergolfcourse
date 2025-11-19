@extends('layouts.app')

@section('title', 'Edit League')

@section('content')
<div class="py-12 bg-gradient-to-b from-green-50 to-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('leagues.show', $league) }}" class="text-green-600 hover:text-green-700 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Back to League
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">
                <i class="fas fa-edit text-blue-600 mr-3"></i>
                Edit League
            </h1>

            <form action="{{ route('leagues.update', $league) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Basic Information</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                League Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" required
                                   value="{{ old('name', $league->name) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('description', $league->description) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                    League Type <span class="text-red-500">*</span>
                                </label>
                                <select name="type" id="type" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="mens" {{ old('type', $league->type) === 'mens' ? 'selected' : '' }}>Men's League</option>
                                    <option value="womens" {{ old('type', $league->type) === 'womens' ? 'selected' : '' }}>Women's League</option>
                                    <option value="mixed" {{ old('type', $league->type) === 'mixed' ? 'selected' : '' }}>Mixed League</option>
                                </select>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="draft" {{ old('status', $league->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="active" {{ old('status', $league->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ old('status', $league->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>

                            <div>
                                <label for="max_members" class="block text-sm font-medium text-gray-700 mb-2">
                                    Max Members (Players)
                                </label>
                                <input type="number" name="max_members" id="max_members" min="4" step="2"
                                       value="{{ old('max_members', $league->max_members) }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Season Dates -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Season Schedule</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="season_start" class="block text-sm font-medium text-gray-700 mb-2">
                                Season Start Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="season_start" id="season_start" required
                                   value="{{ old('season_start', $league->season_start->format('Y-m-d')) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <div>
                            <label for="season_end" class="block text-sm font-medium text-gray-700 mb-2">
                                Season End Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="season_end" id="season_end" required
                                   value="{{ old('season_end', $league->season_end->format('Y-m-d')) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <div>
                            <label for="day_of_week" class="block text-sm font-medium text-gray-700 mb-2">
                                League Day <span class="text-red-500">*</span>
                            </label>
                            <select name="day_of_week" id="day_of_week" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                    <option value="{{ $day }}" {{ old('day_of_week', $league->day_of_week) === $day ? 'selected' : '' }}>{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="tee_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Tee Time <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="tee_time" id="tee_time" required
                                   value="{{ old('tee_time', \Carbon\Carbon::parse($league->tee_time)->format('H:i')) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <div>
                            <label for="holes" class="block text-sm font-medium text-gray-700 mb-2">
                                Number of Holes <span class="text-red-500">*</span>
                            </label>
                            <select name="holes" id="holes" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="9" {{ old('holes', $league->holes) == 9 ? 'selected' : '' }}>9 Holes</option>
                                <option value="18" {{ old('holes', $league->holes) == 18 ? 'selected' : '' }}>18 Holes</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Fees -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">League Fees</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="season_fee" class="block text-sm font-medium text-gray-700 mb-2">
                                Season Fee (per player)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" name="season_fee" id="season_fee" min="0" step="0.01"
                                       value="{{ old('season_fee', $league->season_fee) }}"
                                       class="w-full pl-7 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                        </div>

                        <div>
                            <label for="entry_fee_per_week" class="block text-sm font-medium text-gray-700 mb-2">
                                Weekly Entry Fee (per player)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" name="entry_fee_per_week" id="entry_fee_per_week" min="0" step="0.01"
                                       value="{{ old('entry_fee_per_week', $league->entry_fee_per_week) }}"
                                       class="w-full pl-7 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Points System -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Points System</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="points_system" class="block text-sm font-medium text-gray-700 mb-2">
                                Points System <span class="text-red-500">*</span>
                            </label>
                            <select name="points_system" id="points_system" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="placement" {{ old('points_system', $league->points_system) === 'placement' ? 'selected' : '' }}>
                                    Placement-Based (1st=10pts, 2nd=9pts, etc.)
                                </option>
                                <option value="custom" {{ old('points_system', $league->points_system) === 'custom' ? 'selected' : '' }}>
                                    Custom Points Structure
                                </option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="participation_points" id="participation_points" value="1"
                                   {{ old('participation_points', $league->participation_points) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="participation_points" class="ml-2 text-sm text-gray-700">
                                Award participation points
                            </label>
                        </div>

                        <div id="participation_value_wrapper" class="ml-6" style="display: {{ old('participation_points', $league->participation_points) ? 'block' : 'none' }};">
                            <label for="participation_points_value" class="block text-sm font-medium text-gray-700 mb-2">
                                Participation Points Value
                            </label>
                            <input type="number" name="participation_points_value" id="participation_points_value" min="0"
                                   value="{{ old('participation_points_value', $league->participation_points_value) }}"
                                   class="w-32 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <div>
                            <label for="weeks_count_for_championship" class="block text-sm font-medium text-gray-700 mb-2">
                                Championship Qualification (Best X Weeks)
                            </label>
                            <input type="number" name="weeks_count_for_championship" id="weeks_count_for_championship" min="1"
                                   value="{{ old('weeks_count_for_championship', $league->weeks_count_for_championship) }}"
                                   class="w-32 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                   placeholder="Leave empty to count all weeks">
                        </div>
                    </div>
                </div>

                <!-- Flights -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Flight Settings</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="number_of_flights" class="block text-sm font-medium text-gray-700 mb-2">
                                Number of Flights
                            </label>
                            <select name="number_of_flights" id="number_of_flights"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="1" {{ old('number_of_flights', $league->number_of_flights) == 1 ? 'selected' : '' }}>1 Flight</option>
                                <option value="2" {{ old('number_of_flights', $league->number_of_flights) == 2 ? 'selected' : '' }}>2 Flights</option>
                                <option value="3" {{ old('number_of_flights', $league->number_of_flights) == 3 ? 'selected' : '' }}>3 Flights</option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="flight_prizes" id="flight_prizes" value="1"
                                   {{ old('flight_prizes', $league->flight_prizes) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="flight_prizes" class="ml-2 text-sm text-gray-700">
                                Award prizes by flight
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-between pt-6 border-t">
                    <form action="{{ route('leagues.destroy', $league) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this league? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-lg transition">
                            <i class="fas fa-trash mr-2"></i>Delete League
                        </button>
                    </form>
                    
                    <div class="flex gap-4">
                        <a href="{{ route('leagues.show', $league) }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
                            <i class="fas fa-check mr-2"></i>Update League
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const participationCheckbox = document.getElementById('participation_points');
    const participationValueWrapper = document.getElementById('participation_value_wrapper');
    
    function toggleParticipationValue() {
        if (participationCheckbox.checked) {
            participationValueWrapper.style.display = 'block';
        } else {
            participationValueWrapper.style.display = 'none';
        }
    }
    
    participationCheckbox.addEventListener('change', toggleParticipationValue);
});
</script>
@endsection
