@extends('layouts.app')
@section('title', 'Edit User Type')
@section('content')
<div class="gh-card max-w-xl">
    <div class="gh-card-header">
        <h1 class="font-header" style="letter-spacing:0.1em;">Edit User Type</h1>
    </div>
    <div class="gh-card-body">
        <form method="POST" action="{{ route('user-types.update', $userType) }}">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="gh-label">Name</label>
                <input type="text" name="name" value="{{ old('name', $userType->name) }}" class="gh-input" required>
                @error('name')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="gh-label">Description</label>
                <textarea name="description" rows="3" class="gh-textarea">{{ old('description', $userType->description) }}</textarea>
                @error('description')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>
            <div class="mb-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $userType->is_active) ? 'checked' : '' }}
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
                <a href="{{ route('user-types.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
