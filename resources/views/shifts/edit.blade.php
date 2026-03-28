@extends('layouts.app')

@section('title', 'Edit Shift')

@section('content')
<div class="bg-white rounded-lg shadow p-4 md:p-6">
    <h1 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Edit Shift</h1>

    <form method="POST" action="{{ route('shifts.update', $shift) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Department</label>
            <select name="department_id" class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
                <option value="">Select Department</option>
                @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ $shift->department_id == $dept->id ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
                @endforeach
            </select>
            @error('department_id')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Shift Name</label>
            <input type="text" name="name" value="{{ old('name', $shift->name) }}" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
            @error('name')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Start Time</label>
            <input type="time" name="start_time" value="{{ old('start_time', $shift->start_time) }}" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
            @error('start_time')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">End Time</label>
            <input type="time" name="end_time" value="{{ old('end_time', $shift->end_time) }}" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
            @error('end_time')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Late Tolerance (minutes)</label>
            <input type="number" name="tolerance_minutes" value="{{ old('tolerance_minutes', $shift->tolerance_minutes) }}" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
            @error('tolerance_minutes')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ $shift->is_active ? 'checked' : '' }} class="mr-2 w-4 h-4">
                <span class="text-gray-700 text-sm md:text-base">Active</span>
            </label>
        </div>

        <div class="flex flex-col md:flex-row gap-3 md:gap-4">
            <button type="submit" class="bg-blue-600 text-white px-4 md:px-6 py-2 rounded-lg hover:bg-blue-700 text-sm md:text-base">
                Update
            </button>
            <a href="{{ route('shifts.index') }}" class="bg-gray-300 text-gray-700 px-4 md:px-6 py-2 rounded-lg hover:bg-gray-400 text-center text-sm md:text-base">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
