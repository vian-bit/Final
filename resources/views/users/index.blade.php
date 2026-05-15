@extends('layouts.app')
@section('title', 'User Management')
@section('content')
<div class="gh-card">
    <div class="gh-card-header flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <h1 class="font-header" style="letter-spacing:0.1em;">User Management</h1>
        <a href="{{ route('users.create') }}" class="btn btn-gold text-xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add User
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="gh-table">
            <thead><tr>
                <th>Name</th>
                <th class="hidden md:table-cell">Email</th>
                <th>Role</th>
                <th class="hidden lg:table-cell">Department</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr></thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="font-bold" style="color:var(--brown-900);">{{ $user->name }}</td>
                    <td class="hidden md:table-cell" style="color:var(--gray-500);">{{ $user->email }}</td>
                    <td><span class="badge badge-brown">{{ ucfirst($user->role) }}</span></td>
                    <td class="hidden lg:table-cell" style="color:var(--gray-500);">{{ $user->department->name ?? '—' }}</td>
                    <td>
                        @if($user->user_type)
                            <span class="badge badge-gray">{{ $user->user_type === 'magang' ? 'Intern' : ($user->user_type === 'daily_worker' ? 'Daily Worker' : ucfirst($user->user_type)) }}</span>
                        @else <span style="color:var(--gray-300);">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="whitespace-nowrap">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-edit">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this user?')">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-10" style="color:var(--gray-300);">
                        <svg class="w-8 h-8 mx-auto mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        No users found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
