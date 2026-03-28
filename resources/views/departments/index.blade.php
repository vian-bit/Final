@extends('layouts.app')

@section('title', 'Departments')

@section('content')
<div class="bg-white rounded-lg shadow p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 md:mb-6 gap-3">
        <h1 class="text-xl md:text-2xl font-bold">Departments</h1>
        <a href="{{ route('departments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center text-sm md:text-base">
            Add Department
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm md:text-base">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 md:px-4 py-2 text-left">Name</th>
                    <th class="px-2 md:px-4 py-2 text-left">Code</th>
                    <th class="px-2 md:px-4 py-2 text-left hidden md:table-cell">Description</th>
                    <th class="px-2 md:px-4 py-2 text-left">Users</th>
                    <th class="px-2 md:px-4 py-2 text-left">Status</th>
                    <th class="px-2 md:px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $dept)
                <tr class="border-b">
                    <td class="px-2 md:px-4 py-2">{{ $dept->name }}</td>
                    <td class="px-2 md:px-4 py-2">{{ $dept->code }}</td>
                    <td class="px-2 md:px-4 py-2 hidden md:table-cell">{{ $dept->description }}</td>
                    <td class="px-2 md:px-4 py-2">{{ $dept->users_count }}</td>
                    <td class="px-2 md:px-4 py-2">
                        <span class="px-2 py-1 rounded text-xs md:text-sm {{ $dept->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $dept->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-2 md:px-4 py-2">
                        <a href="{{ route('departments.edit', $dept) }}" class="text-blue-600 hover:underline mr-2 text-sm">Edit</a>
                        <form method="POST" action="{{ route('departments.destroy', $dept) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Are you sure you want to delete this department?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-2 md:px-4 py-4 text-center text-gray-500">No departments found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
