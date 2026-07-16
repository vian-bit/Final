@extends('layouts.app')
@section('title', 'Edit Attendance')
@section('content')
<div class="gh-card max-w-xl">
    <div class="gh-card-header">
        <h1 class="font-header" style="letter-spacing:0.1em;">Edit Attendance</h1>
    </div>
    <div class="gh-card-body">

        {{-- Info attendance --}}
        <div class="mb-5 p-4 rounded-lg" style="background:var(--cream-100); border:1px solid var(--cream-200);">
            <p class="font-bold" style="color:var(--brown-900);">{{ $attendance->user->name }}</p>
            <p class="text-sm mt-1" style="color:var(--gray-500);">
                {{ $attendance->date->format('l, d F Y') }}
                &mdash; Shift: <strong>{{ $attendance->schedule->shift->name }}</strong>
                ({{ $attendance->schedule->shift->start_time }} - {{ $attendance->schedule->shift->end_time }})
            </p>

            {{-- History jika sudah pernah diedit --}}
            @if($attendance->edited_at)
            <div class="mt-3 pt-3" style="border-top:1px solid var(--cream-200);">
                <p class="text-xs font-bold mb-1" style="color:var(--gray-400); letter-spacing:0.06em; text-transform:uppercase;">Edit History</p>
                <p class="text-xs" style="color:var(--gray-400);">
                    Diedit oleh <strong>{{ $attendance->editor?->name ?? 'Unknown' }}</strong>
                    pada {{ $attendance->edited_at->format('d/m/Y H:i') }}
                </p>
                @if($attendance->original_check_in || $attendance->original_check_out)
                <p class="text-xs mt-1" style="color:var(--gray-400);">
                    Data asli:
                    CI {{ $attendance->original_check_in ?? '—' }}
                    / CO {{ $attendance->original_check_out ?? '—' }}
                </p>
                @endif
                @if($attendance->edit_reason)
                <p class="text-xs mt-1" style="color:var(--gray-400);">
                    Alasan: {{ $attendance->edit_reason }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <form method="POST" action="{{ route('attendances.update', $attendance) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="gh-label">Check In</label>
                    <input type="time" name="check_in"
                           value="{{ old('check_in', $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '') }}"
                           class="gh-input">
                    @error('check_in')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="gh-label">Check Out</label>
                    <input type="time" name="check_out"
                           value="{{ old('check_out', $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '') }}"
                           class="gh-input">
                    @error('check_out')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="gh-label">Status</label>
                <select name="status" class="gh-select" required>
                    <option value="present"  {{ old('status', $attendance->status) === 'present'  ? 'selected' : '' }}>✅ Present (On Time)</option>
                    <option value="late"     {{ old('status', $attendance->status) === 'late'     ? 'selected' : '' }}>⏰ Late</option>
                    <option value="absent"   {{ old('status', $attendance->status) === 'absent'   ? 'selected' : '' }}>❌ Absent</option>
                </select>
                @error('status')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="gh-label">Alasan Edit <span style="color:var(--gray-300);">(opsional)</span></label>
                <input type="text" name="edit_reason"
                       value="{{ old('edit_reason') }}"
                       placeholder="cth: koreksi keterlambatan input, lupa checkout, dll"
                       class="gh-input">
                @error('edit_reason')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="gh-label">Catatan <span style="color:var(--gray-300);">(opsional)</span></label>
                <textarea name="notes" rows="2" class="gh-textarea"
                          placeholder="Catatan tambahan...">{{ old('notes', $attendance->notes) }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
