@extends('layouts.app')
@section('title', 'Edit Jadwal')
@section('content')
<div class="gh-card max-w-xl">
    <div class="gh-card-header">
        <h1 class="font-header" style="letter-spacing:0.1em;">Edit Jadwal Kerja</h1>
    </div>
    <div class="gh-card-body">

        {{-- Info jadwal yang sedang diedit --}}
        <div class="mb-5 p-4 rounded-lg" style="background:var(--cream-100); border:1px solid var(--cream-200);">
            <p class="text-sm" style="color:var(--gray-500);">
                <span class="font-bold" style="color:var(--brown-900);">{{ $schedule->user->name }}</span>
                &mdash; {{ $schedule->date->format('d/m/Y') }}
            </p>
            @if($schedule->attendance && $schedule->attendance->check_in)
            <p class="text-xs mt-1" style="color:#b45309;">
                ⚠️ User sudah check-in pukul {{ \Carbon\Carbon::parse($schedule->attendance->check_in)->format('H:i') }}.
                Perubahan shift akan tetap disimpan.
            </p>
            @endif
        </div>

        <form method="POST" action="{{ route('schedules.update', $schedule) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="gh-label">Shift</label>
                <select name="shift_id" class="gh-select" required>
                    <option value="">Pilih Shift</option>
                    @foreach($shifts as $shift)
                    <option value="{{ $shift->id }}" {{ $schedule->shift_id == $shift->id ? 'selected' : '' }}>
                        {{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }})
                    </option>
                    @endforeach
                </select>
                @error('shift_id')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="gh-label">Catatan (Opsional)</label>
                <textarea name="notes" rows="3" class="gh-textarea">{{ old('notes', $schedule->notes) }}</textarea>
                @error('notes')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
