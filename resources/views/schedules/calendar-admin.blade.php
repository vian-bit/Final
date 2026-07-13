@extends('layouts.app')
@section('title', 'Manage Work Schedule')
@section('content')
<div class="gh-card" style="padding:0; overflow:hidden;">
    <div class="gh-card-header flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <h1 class="font-header" style="letter-spacing:0.1em;">Manage Schedule — {{ $date->format('F Y') }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('schedules.calendar', ['month' => $date->copy()->subMonth()->format('Y-m'), 'user_id' => $selectedUserId]) }}"
               class="btn btn-secondary text-xs px-3 py-1.5">← Prev</a>
            <a href="{{ route('schedules.calendar', ['month' => now()->format('Y-m'), 'user_id' => $selectedUserId]) }}"
               class="btn btn-gold text-xs px-3 py-1.5">This Month</a>
            <a href="{{ route('schedules.calendar', ['month' => $date->copy()->addMonth()->format('Y-m'), 'user_id' => $selectedUserId]) }}"
               class="btn btn-secondary text-xs px-3 py-1.5">Next →</a>
        </div>
    </div>

    <div class="p-4">
        <!-- Select User -->
        <div class="mb-4 p-3 rounded-lg" style="background:var(--cream-100); border:1px solid var(--cream-200);">
            <form method="GET">
                <input type="hidden" name="month" value="{{ $date->format('Y-m') }}">
                <div class="flex flex-col sm:flex-row gap-3 sm:items-end">
                    <div class="flex-1">
                        <label class="gh-label">Select User</label>
                        <select name="user_id" class="gh-select" onchange="this.form.submit()">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $selectedUserId == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} — {{ $user->user_type_label }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <form method="POST" action="{{ route('schedules.bulk-store') }}" id="scheduleForm">
            @csrf
            <input type="hidden" name="user_id" value="{{ $selectedUserId }}">
            <input type="hidden" name="month" value="{{ $date->format('Y-m') }}">

            <!-- Quick Actions -->
            <div class="mb-4 p-3 rounded-lg flex flex-wrap gap-2 items-center" style="background:rgba(201,168,76,0.06); border:1px solid var(--cream-200);">
                <span class="text-xs font-bold" style="color:var(--gray-500); letter-spacing:0.06em; text-transform:uppercase;">Quick Setup:</span>
                @foreach($shifts as $shift)
                <button type="button" onclick="applyShiftToAll('{{ $shift->id }}')"
                    class="btn btn-primary text-xs px-3 py-1.5">{{ $shift->name }} All</button>
                @endforeach
                <button type="button" onclick="applyShiftToWeekdays()"
                    class="btn btn-gold text-xs px-3 py-1.5">Mon–Fri</button>
                <button type="button" onclick="clearAll()"
                    class="btn btn-danger text-xs px-3 py-1.5" style="background:#dc2626; color:#fff;">Clear All</button>
            </div>

            <div class="grid grid-cols-7 gap-1 md:gap-2">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div class="text-center py-2 rounded text-xs font-bold" style="background:linear-gradient(135deg,var(--brown-900),var(--brown-600)); color:var(--cream-50); letter-spacing:0.06em;">
                    {{ $day }}
                </div>
                @endforeach

                @php
                    $startOfMonth = $date->copy()->startOfMonth();
                    $startDay = $startOfMonth->dayOfWeek;
                    $daysInMonth = $startOfMonth->daysInMonth;
                    $today = now('Asia/Jakarta')->format('Y-m-d');
                @endphp

                @for($i = 0; $i < $startDay; $i++)
                <div class="rounded min-h-20 md:min-h-32" style="background:var(--cream-200);"></div>
                @endfor

                @for($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $currentDate = $date->copy()->day($day);
                    $dateKey = $currentDate->format('Y-m-d');
                    $schedule = $schedules->get($dateKey);
                    $isToday = $dateKey === $today;
                    $isPast  = $dateKey < $today;
                    $hasAttendance = $schedule && $schedule->attendance()->exists();
                    $dayOfWeek = $currentDate->dayOfWeek;
                @endphp
                <div class="p-1 md:p-2 rounded min-h-20 md:min-h-32"
                    style="border:2px solid {{ $isToday ? 'var(--brown-300)' : 'var(--cream-200)' }};
                           background:{{ $isPast ? 'var(--cream-200)' : ($isToday ? 'rgba(201,168,76,0.08)' : 'var(--cream-50)') }};
                           opacity:{{ $isPast ? '0.6' : '1' }};"
                    data-date="{{ $dateKey }}" data-day="{{ $dayOfWeek }}">
                    <div class="text-xs md:text-sm font-bold mb-1"
                        style="color:{{ $isToday ? 'var(--brown-300)' : 'var(--brown-900)' }};">
                        {{ $day }}
                        @if($hasAttendance)
                        <span class="text-xs ml-1" style="color:#d97706;" title="Sudah check-in">✓</span>
                        @endif
                    </div>
                    <select name="schedules[{{ $dateKey }}][shift_id]"
                            class="w-full px-1 py-1 rounded text-xs shift-select"
                            style="border:1px solid var(--cream-200); background:var(--cream-50); color:var(--brown-900);"
                            data-date="{{ $dateKey }}"
                            {{ $isPast ? 'disabled' : '' }}>
                        <option value="">Off</option>
                        @foreach($shifts as $shift)
                        <option value="{{ $shift->id }}" {{ $schedule && $schedule->shift_id == $shift->id ? 'selected' : '' }}>
                            {{ $shift->name }}
                        </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="schedules[{{ $dateKey }}][date]" value="{{ $dateKey }}">
                    @if($schedule)
                    <div class="mt-1 text-xs hidden md:block" style="color:var(--gray-300);">
                        {{ $schedule->shift->start_time }} - {{ $schedule->shift->end_time }}
                    </div>
                    @endif
                </div>
                @endfor

                @php
                    $remainingCells = 7 - (($startDay + $daysInMonth) % 7);
                    if ($remainingCells < 7) {
                        for($i = 0; $i < $remainingCells; $i++) {
                            echo '<div class="rounded min-h-20 md:min-h-32" style="background:var(--cream-200);"></div>';
                        }
                    }
                @endphp
            </div>

            <div class="mt-5 flex flex-col sm:flex-row gap-3">
                <button type="submit" class="btn btn-success flex-1 justify-center py-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Save All Schedules
                </button>
                <a href="{{ route('schedules.index') }}" class="btn btn-secondary flex-1 justify-center py-3">Back</a>
            </div>
        </form>
    </div>
</div>

<script>
function applyShiftToAll(shiftId) {
    if (!confirm('Set all days with this shift?')) return;
    document.querySelectorAll('.shift-select').forEach(s => s.value = shiftId);
}
function applyShiftToWeekdays() {
    const shiftId = prompt('Enter shift ID for Monday-Friday:');
    if (!shiftId) return;
    document.querySelectorAll('[data-day]').forEach(cell => {
        const day = parseInt(cell.dataset.day);
        if (day >= 1 && day <= 5) {
            const sel = cell.querySelector('.shift-select');
            if (sel) sel.value = shiftId;
        }
    });
}
function clearAll() {
    if (!confirm('Clear all schedules?')) return;
    document.querySelectorAll('.shift-select').forEach(s => s.value = '');
}
document.getElementById('scheduleForm').addEventListener('submit', function() {
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true; btn.textContent = 'Saving...';
});
</script>
@endsection
