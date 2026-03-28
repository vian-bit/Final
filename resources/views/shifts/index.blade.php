@extends('layouts.app')

@section('title', 'Work Shifts')

@section('content')
<div class="bg-white rounded-lg shadow p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 md:mb-6 gap-3">
        <h1 class="text-xl md:text-2xl font-bold">Work Shifts</h1>
        <a href="{{ route('shifts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center text-sm md:text-base">
            Add Shift
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm md:text-base">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 md:px-4 py-2 text-left">Shift Name</th>
                    <th class="px-2 md:px-4 py-2 text-left hidden lg:table-cell">Department</th>
                    <th class="px-2 md:px-4 py-2 text-left">Start Time</th>
                    <th class="px-2 md:px-4 py-2 text-left">End Time</th>
                    <th class="px-2 md:px-4 py-2 text-left hidden md:table-cell">Tolerance</th>
                    <th class="px-2 md:px-4 py-2 text-left">Status</th>
                    <th class="px-2 md:px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shifts as $shift)
                <tr class="border-b">
                    <td class="px-2 md:px-4 py-2">{{ $shift->name }}</td>
                    <td class="px-2 md:px-4 py-2 hidden lg:table-cell">{{ $shift->department->name }}</td>
                    <td class="px-2 md:px-4 py-2">{{ $shift->start_time }}</td>
                    <td class="px-2 md:px-4 py-2">{{ $shift->end_time }}</td>
                    <td class="px-2 md:px-4 py-2 hidden md:table-cell">{{ $shift->tolerance_minutes }} min</td>
                    <td class="px-2 md:px-4 py-2">
                        <span class="px-2 py-1 rounded text-xs md:text-sm {{ $shift->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $shift->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-2 md:px-4 py-2">
                        <a href="{{ route('shifts.edit', $shift) }}" class="text-blue-600 hover:underline mr-2 text-sm">Edit</a>
                        <form method="POST" action="{{ route('shifts.destroy', $shift) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Are you sure you want to delete this shift?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-2 md:px-4 py-4 text-center text-gray-500">No shifts found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
