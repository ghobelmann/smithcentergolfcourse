@extends('layouts.app')

@section('content')
<!-- Admin Header -->
<section class="bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('admin.users.index') }}" class="text-blue-200 hover:text-white mb-2 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Back to Users
        </a>
        <h1 class="text-4xl font-display text-white mb-2">Edit User</h1>
        <p class="text-blue-200">Update user information and permissions</p>
    </div>
</section>

<!-- Edit Form -->
<section class="py-8 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-md p-8">
            
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Admin Status -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="is_admin" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                               {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <label for="is_admin" class="ml-2 block text-sm text-gray-900">
                            <span class="font-semibold">Admin Access</span>
                            @if($user->id === auth()->id())
                                <span class="text-gray-500 text-xs ml-2">(You cannot change your own admin status)</span>
                            @endif
                        </label>
                    </div>
                    <p class="text-gray-600 text-sm mt-1 ml-6">Admin users can create tournaments, manage leagues, and access the admin dashboard</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                </div>
            </form>

        </div>
    </div>
</section>
@endsection
