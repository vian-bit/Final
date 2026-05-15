@extends('layouts.app')
@section('title', 'Tambah Jadwal')
@section('content')
<div class="gh-card max-w-xl">
    <div class="gh-card-header">
        <h1 class="font-header" style="letter-spacing:0.1em;">Tambah Jadwal Kerja</h1>
    </div>
    <div class="gh-card-body">
        <form method="POST" action="{{ route('schedules.store') }}">
            @csrf

            <div class="mb-4">
                <label class="gh-label">User</label>
                <select name="user_id" class="gh-select" required>
                    <option value="">Pilih User</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} — {{ $user->department->name }}</option>
                    @endforeach
                </select>
                @error('user_id')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="gh-label">Shift</label>
                <select name="shift_id" class="gh-select" required>
                    <option value="">Pilih Shift</option>
                    @foreach($shifts as $shift)
                    <option value="{{ $shift->id }}">{{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }})</option>
                    @endforeach
                </select>
                @error('shift_id')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="gh-label">Tanggal</label>
                <input type="date" name="date" value="{{ old('date') }}" class="gh-input" required>
                @error('date')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="gh-label">Catatan (Opsional)</label>
                <textarea name="notes" rows="3" class="gh-textarea">{{ old('notes') }}</textarea>
                @error('notes')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
