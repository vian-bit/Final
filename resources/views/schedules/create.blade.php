@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Tambah Jadwal Kerja</h1>

    <form method="POST" action="{{ route('schedules.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">User</label>
            <select name="user_id" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">Pilih User</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->department->name }}</option>
                @endforeach
            </select>
            @error('user_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Shift</label>
            <select name="shift_id" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">Pilih Shift</option>
                @foreach($shifts as $shift)
                <option value="{{ $shift->id }}">{{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }})</option>
                @endforeach
            </select>
            @error('shift_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Tanggal</label>
            <input type="date" name="date" value="{{ old('date') }}" 
                class="w-full px-4 py-2 border rounded-lg" required>
            @error('date')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Catatan (Opsional)</label>
            <textarea name="notes" rows="3" 
                class="w-full px-4 py-2 border rounded-lg">{{ old('notes') }}</textarea>
            @error('notes')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Simpan
            </button>
            <a href="{{ route('schedules.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
