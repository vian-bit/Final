@extends('layouts.app')
@section('title', 'Add User Type')
@section('content')
<div class="gh-card max-w-xl">
    <div class="gh-card-header">
        <h1 class="font-header" style="letter-spacing:0.1em;">Add User Type</h1>
    </div>
    <div class="gh-card-body">
        <form method="POST" action="{{ route('user-types.store') }}">
            @csrf
            <div class="mb-4">
                <label class="gh-label">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Intern" class="gh-input" required>
                @error('name')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>
            <div class="mb-6">
                <label class="gh-label">Description</label>
                <textarea name="description" rows="3" placeholder="Deskripsi singkat tipe user ini..." class="gh-textarea">{{ old('description') }}</textarea>
                @error('description')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save
                </button>
                <a href="{{ route('user-types.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
