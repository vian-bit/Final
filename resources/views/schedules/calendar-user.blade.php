@extends('layouts.app')
@section('title', 'My Work Schedule')
@section('content')
<div class="gh-card" style="padding:0; overflow:hidden;">
    <div class="gh-card-header flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <h1 class="font-header" style="letter-spacing:0.1em;">Work Schedule — {{ $date->format('F Y') }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('schedules.calendar', ['month' => $date->copy()->subMonth()->format('Y-m')]) }}"
               class="btn btn-secondary text-xs px-3 py-1.5">← Prev</a>
            <a href="{{ route('schedules.calendar', ['month' => now()->format('Y-m')]) }}"
               class="btn btn-gold text-xs px-3 py-1.5">This Month</a>
            <a href="{{ route('schedules.calendar', ['month' => $date->copy()->addMonth()->format('Y-m')]) }}"
               class="btn btn-secondary text-xs px-3 py-1.5">Next →</a>
        </div>
    </div>

    <div class="p-4">
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
                $today = now()->format('Y-m-d');
            @endphp

            @for($i = 0; $i < $startDay; $i++)
            <div class="rounded min-h-16 md:min-h-24" style="background:var(--cream-200);"></div>
            @endfor

            @for($day = 1; $day <= $daysInMonth; $day++)
            @php
                $currentDate = $date->copy()->day($day);
                $dateKey = $currentDate->format('Y-m-d');
                $schedule = $schedules->get($dateKey);
                $isToday = $dateKey === $today;
                $isPast = $currentDate->lt(now()->startOfDay());
            @endphp
            <div class="p-1 md:p-2 rounded min-h-16 md:min-h-24"
                style="border:2px solid {{ $isToday ? 'var(--brown-300)' : 'var(--cream-200)' }};
                       background:{{ $isToday ? 'rgba(201,168,76,0.08)' : ($isPast ? 'var(--cream-200)' : 'var(--cream-50)') }};">
                <div class="text-xs md:text-sm font-bold mb-1"
                    style="color:{{ $isToday ? 'var(--brown-300)' : 'var(--brown-900)' }};">
                    {{ $day }}
                    @if($isToday)
                    <span class="hidden md:inline text-xs px-1 rounded" style="background:var(--brown-300); color:var(--brown-900);">Today</span>
                    @endif
                </div>
                @if($schedule)
                <div class="rounded p-1" style="background:#d1fae5; border:1px solid #a7f3d0;">
                    <div class="text-xs font-bold truncate" style="color:#065f46;">{{ $schedule->shift->name }}</div>
                    <div class="text-xs hidden md:block" style="color:#065f46;">{{ $schedule->shift->start_time }} - {{ $schedule->shift->end_time }}</div>
                </div>
                @else
                <div class="text-center text-xs mt-1" style="color:var(--gray-300);">Off</div>
                @endif
            </div>
            @endfor

            @php
                $remainingCells = 7 - (($startDay + $daysInMonth) % 7);
                if ($remainingCells < 7) {
                    for($i = 0; $i < $remainingCells; $i++) {
                        echo '<div class="rounded min-h-16 md:min-h-24" style="background:var(--cream-200);"></div>';
                    }
                }
            @endphp
        </div>

        <!-- Legend -->
        <div class="mt-4 p-3 rounded-lg" style="background:rgba(201,168,76,0.06); border:1px solid var(--cream-200);">
            <div class="text-xs font-bold mb-2" style="color:var(--gray-500); letter-spacing:0.08em; text-transform:uppercase;">Legend</div>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded" style="background:rgba(201,168,76,0.08); border:2px solid var(--brown-300);"></div>
                    <span style="color:var(--gray-500);">Today</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded" style="background:#d1fae5; border:1px solid #a7f3d0;"></div>
                    <span style="color:var(--gray-500);">Scheduled</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded" style="background:var(--cream-200);"></div>
                    <span style="color:var(--gray-500);">Past / Off</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
