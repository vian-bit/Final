@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="bg-white rounded-lg shadow p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 md:mb-6 gap-3">
        <h1 class="text-xl md:text-2xl font-bold">User Management</h1>
        <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center text-sm md:text-base">
            Add User
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm md:text-base">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 md:px-4 py-2 text-left">Name</th>
                    <th class="px-2 md:px-4 py-2 text-left hidden md:table-cell">Email</th>
                    <th class="px-2 md:px-4 py-2 text-left">Role</th>
                    <th class="px-2 md:px-4 py-2 text-left hidden lg:table-cell">Department</th>
                    <th class="px-2 md:px-4 py-2 text-left">Type</th>
                    <th class="px-2 md:px-4 py-2 text-left">Status</th>
                    <th class="px-2 md:px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b">
                    <td class="px-2 md:px-4 py-2">{{ $user->name }}</td>
                    <td class="px-2 md:px-4 py-2 hidden md:table-cell">{{ $user->email }}</td>
                    <td class="px-2 md:px-4 py-2">{{ ucfirst($user->role) }}</td>
                    <td class="px-2 md:px-4 py-2 hidden lg:table-cell">{{ $user->department->name ?? '-' }}</td>
                    <td class="px-2 md:px-4 py-2">
                        @if($user->user_type)
                            {{ $user->user_type === 'magang' ? 'Intern' : 'Daily Worker' }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-2 md:px-4 py-2">
                        <span class="px-2 py-1 rounded text-xs md:text-sm {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-2 md:px-4 py-2">
                        <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:underline mr-2 text-sm">Edit</a>
                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-2 md:px-4 py-4 text-center text-gray-500">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
