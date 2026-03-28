@extends('layouts.app')

@section('title', 'Add Department')

@section('content')
<div class="bg-white rounded-lg shadow p-4 md:p-6">
    <h1 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Add New Department</h1>

    <form method="POST" action="{{ route('departments.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Department Name</label>
            <input type="text" name="name" value="{{ old('name') }}" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
            @error('name')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Code</label>
            <input type="text" name="code" value="{{ old('code') }}" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
            @error('code')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Description</label>
            <textarea name="description" rows="3" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
            @error('description')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col md:flex-row gap-3 md:gap-4">
            <button type="submit" class="bg-blue-600 text-white px-4 md:px-6 py-2 rounded-lg hover:bg-blue-700 text-sm md:text-base">
                Save
            </button>
            <a href="{{ route('departments.index') }}" class="bg-gray-300 text-gray-700 px-4 md:px-6 py-2 rounded-lg hover:bg-gray-400 text-center text-sm md:text-base">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
