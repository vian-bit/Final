@extends('layouts.app')
@section('title', 'Edit Shift')
@section('content')
<div class="gh-card max-w-xl">
    <div class="gh-card-header">
        <h1 class="font-header" style="letter-spacing:0.1em;">Edit Shift</h1>
    </div>
    <div class="gh-card-body">
        <form method="POST" action="{{ route('shifts.update', $shift) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="gh-label">Department</label>
                <select name="department_id" class="gh-select" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ $shift->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
                @error('department_id')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="gh-label">Shift Name</label>
                <input type="text" name="name" value="{{ old('name', $shift->name) }}" class="gh-input" required>
                @error('name')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="gh-label">Start Time</label>
                <input type="time" name="start_time" value="{{ old('start_time', $shift->start_time) }}" class="gh-input" required>
                @error('start_time')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="gh-label">End Time</label>
                <input type="time" name="end_time" value="{{ old('end_time', $shift->end_time) }}" class="gh-input" required>
                @error('end_time')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="gh-label">Late Tolerance (minutes)</label>
                <input type="number" name="tolerance_minutes" value="{{ old('tolerance_minutes', $shift->tolerance_minutes) }}" class="gh-input" required>
                @error('tolerance_minutes')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ $shift->is_active ? 'checked' : '' }}
                        class="w-4 h-4 rounded" style="accent-color:var(--brown-600);">
                    <span class="text-sm font-bold" style="color:var(--gray-500); letter-spacing:0.04em;">Active</span>
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update
                </button>
                <a href="{{ route('shifts.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
