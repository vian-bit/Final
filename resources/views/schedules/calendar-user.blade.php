@extends('layouts.app')

@section('title', 'My Work Schedule')

@section('content')
<div class="bg-white rounded-lg shadow p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 md:mb-6 gap-3">
        <h1 class="text-xl md:text-2xl font-bold">Work Schedule - {{ $date->format('F Y') }}</h1>
        
        <div class="flex gap-2 overflow-x-auto">
            <a href="{{ route('schedules.calendar', ['month' => $date->copy()->subMonth()->format('Y-m')]) }}" 
               class="bg-gray-300 text-gray-700 px-3 py-2 rounded hover:bg-gray-400 text-sm whitespace-nowrap">
                ← Previous
            </a>
            <a href="{{ route('schedules.calendar', ['month' => now()->format('Y-m')]) }}" 
               class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 text-sm whitespace-nowrap">
                This Month
            </a>
            <a href="{{ route('schedules.calendar', ['month' => $date->copy()->addMonth()->format('Y-m')]) }}" 
               class="bg-gray-300 text-gray-700 px-3 py-2 rounded hover:bg-gray-400 text-sm whitespace-nowrap">
                Next →
            </a>
        </div>
    </div>

    <div class="grid grid-cols-7 gap-1 md:gap-2">
        <!-- Header Hari -->
        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
        <div class="bg-blue-600 text-white text-center font-semibold py-2 rounded text-xs md:text-base">
            {{ $day }}
        </div>
        @endforeach

        <!-- Tanggal -->
        @php
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            $startDay = $startOfMonth->dayOfWeek;
            $daysInMonth = $startOfMonth->daysInMonth;
            $today = now()->format('Y-m-d');
        @endphp

        <!-- Empty cells sebelum tanggal 1 -->
        @for($i = 0; $i < $startDay; $i++)
        <div class="bg-gray-100 p-1 md:p-2 rounded min-h-16 md:min-h-24"></div>
        @endfor

        <!-- Tanggal dalam bulan -->
        @for($day = 1; $day <= $daysInMonth; $day++)
        @php
            $currentDate = $date->copy()->day($day);
            $dateKey = $currentDate->format('Y-m-d');
            $schedule = $schedules->get($dateKey);
            $isToday = $dateKey === $today;
            $isPast = $currentDate->lt(now()->startOfDay());
        @endphp
        <div class="border-2 {{ $isToday ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} p-1 md:p-2 rounded min-h-16 md:min-h-24 {{ $isPast ? 'bg-gray-50' : '' }}">
            <div class="font-semibold {{ $isToday ? 'text-blue-600' : 'text-gray-700' }} text-xs md:text-base">
                {{ $day }}
                @if($isToday)
                <span class="text-xs bg-blue-600 text-white px-1 rounded hidden md:inline">Today</span>
                @endif
            </div>
            
            @if($schedule)
            <div class="mt-1 md:mt-2 bg-green-100 border border-green-300 rounded p-1">
                <div class="text-xs font-semibold text-green-800 truncate">{{ $schedule->shift->name }}</div>
                <div class="text-xs text-green-700 hidden md:block">{{ $schedule->shift->start_time }} - {{ $schedule->shift->end_time }}</div>
            </div>
            @else
            <div class="mt-1 md:mt-2 text-center text-gray-400 text-xs">
                Off
            </div>
            @endif
        </div>
        @endfor

        <!-- Empty cells setelah akhir bulan -->
        @php
            $remainingCells = 7 - (($startDay + $daysInMonth) % 7);
            if ($remainingCells < 7) {
                for($i = 0; $i < $remainingCells; $i++) {
                    echo '<div class="bg-gray-100 p-1 md:p-2 rounded min-h-16 md:min-h-24"></div>';
                }
            }
        @endphp
    </div>

    <div class="mt-4 md:mt-6 bg-blue-50 border border-blue-200 rounded p-3 md:p-4">
        <h3 class="font-semibold mb-2 text-sm md:text-base">Legend:</h3>
        <div class="grid grid-cols-2 gap-2 text-xs md:text-sm">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-blue-500 border-2 border-blue-600 rounded"></div>
                <span>Today</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-green-100 border border-green-300 rounded"></div>
                <span>Scheduled</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-gray-50 border border-gray-200 rounded"></div>
                <span>Past Days</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-white border border-gray-200 rounded"></div>
                <span>Day Off</span>
            </div>
        </div>
    </div>
</div>
@endsection
