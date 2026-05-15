@extends('layouts.app')
@section('title', 'Departments')
@section('content')
<div class="gh-card">
    <div class="gh-card-header flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <h1 class="font-header" style="letter-spacing:0.1em;">Departments</h1>
        <a href="{{ route('departments.create') }}" class="btn btn-gold text-xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Department
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="gh-table">
            <thead><tr>
                <th>Name</th><th>Code</th>
                <th class="hidden md:table-cell">Description</th>
                <th>Users</th><th>Status</th><th>Actions</th>
            </tr></thead>
            <tbody>
                @forelse($departments as $dept)
                <tr>
                    <td class="font-bold" style="color:var(--brown-900);">{{ $dept->name }}</td>
                    <td><span class="badge badge-gold font-mono">{{ $dept->code }}</span></td>
                    <td class="hidden md:table-cell" style="color:var(--gray-500);">{{ $dept->description ?? '—' }}</td>
                    <td style="color:var(--gray-500);">{{ $dept->users_count }}</td>
                    <td>
                        <span class="badge {{ $dept->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $dept->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="whitespace-nowrap">
                        <a href="{{ route('departments.edit', $dept) }}" class="btn btn-edit">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('departments.destroy', $dept) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this department?')">
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
                    <td colspan="6" class="text-center py-10" style="color:var(--gray-300);">
                        <svg class="w-8 h-8 mx-auto mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        No departments found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
