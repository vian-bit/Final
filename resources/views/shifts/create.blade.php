@extends('layouts.app')
@section('title', 'Add Shift')
@section('content')
<div class="gh-card max-w-xl">
    <div class="gh-card-header">
        <h1 class="font-header" style="letter-spacing:0.1em;">Add New Shift</h1>
    </div>
    <div class="gh-card-body">
        <form method="POST" action="{{ route('shifts.store') }}">
            @csrf

            <div class="mb-4">
                <label class="gh-label">Department</label>
                <select name="department_id" class="gh-select" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
                @error('department_id')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="gh-label">Shift Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="gh-input" required>
                @error('name')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="gh-label">Start Time</label>
                <input type="time" name="start_time" value="{{ old('start_time') }}" class="gh-input" required>
                @error('start_time')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="gh-label">End Time</label>
                <input type="time" name="end_time" value="{{ old('end_time') }}" class="gh-input" required>
                @error('end_time')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="gh-label">Late Tolerance (minutes)</label>
                <input type="number" name="tolerance_minutes" value="{{ old('tolerance_minutes', 15) }}" class="gh-input" required>
                @error('tolerance_minutes')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save
                </button>
                <a href="{{ route('shifts.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
