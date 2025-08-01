@extends('layouts.app-external')

@section('content')
<div class="mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Profile</h1>
            <a href="{{ route('external.profile.edit', 1) }}"
                class="px-4 py-2 button-primary">
                Edit Profile
            </a>
        </div>

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-600">Username</label>
                <p class="text-lg text-gray-800">{{ $user->username }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Name</label>
                <p class="text-lg text-gray-800">{{ $user->first_name }} {{ $user->last_name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Email</label>
                <p class="text-lg text-gray-800">{{ $user->email }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Member Since</label>
                <p class="text-lg text-gray-800">{{ $user->created_at->format('F d, Y') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Status</label>
                <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full {{ !$user->is_active ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Last Logged In</label>
                <p class="text-lg text-gray-800">{{ $user->last_logged_in_at->format('F d, Y') }}</p>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('external.profile.change-password') }}"
                class="button-secondary font-medium">
                Change Password
            </a>
        </div>
    </div>
</div>
@endsection