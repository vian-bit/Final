@extends('layouts.app')

@section('title', 'Manage Work Schedule')

@section('content')
<div class="bg-white rounded-lg shadow p-4 md:p-6">
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 md:mb-6 gap-3">
        <h1 class="text-xl md:text-2xl font-bold">Manage Work Schedule - {{ $date->format('F Y') }}</h1>
        
        <div class="flex gap-2 overflow-x-auto">
            <a href="{{ route('schedules.calendar', ['month' => $date->copy()->subMonth()->format('Y-m'), 'user_id' => $selectedUserId]) }}" 
               class="bg-gray-300 text-gray-700 px-3 py-2 rounded hover:bg-gray-400 text-sm whitespace-nowrap">
                ← Previous
            </a>
            <a href="{{ route('schedules.calendar', ['month' => now()->format('Y-m'), 'user_id' => $selectedUserId]) }}" 
               class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 text-sm whitespace-nowrap">
                This Month
            </a>
            <a href="{{ route('schedules.calendar', ['month' => $date->copy()->addMonth()->format('Y-m'), 'user_id' => $selectedUserId]) }}" 
               class="bg-gray-300 text-gray-700 px-3 py-2 rounded hover:bg-gray-400 text-sm whitespace-nowrap">
                Next →
            </a>
        </div>
    </div>

    <!-- Pilih User -->
    <div class="mb-4 md:mb-6 bg-gray-50 p-3 md:p-4 rounded">
        <form method="GET" class="flex flex-col md:flex-row gap-3 md:gap-4 md:items-end">
            <input type="hidden" name="month" value="{{ $date->format('Y-m') }}">
            <div class="flex-1">
                <label class="block text-gray-700 mb-2 font-semibold text-sm md:text-base">Select User:</label>
                <select name="user_id" class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base" onchange="this.form.submit()">
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $selectedUserId == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} - {{ $user->user_type === 'magang' ? 'Intern' : 'Daily Worker' }}
                    </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <form method="POST" action="{{ route('schedules.bulk-store') }}" id="scheduleForm">
        @csrf
        <input type="hidden" name="user_id" value="{{ $selectedUserId }}">
        <input type="hidden" name="month" value="{{ $date->format('Y-m') }}">

        <!-- Quick Actions -->
        <div class="mb-4 bg-blue-50 border border-blue-200 rounded p-3 md:p-4">
            <div class="flex gap-2 items-center flex-wrap">
                <span class="font-semibold text-sm md:text-base">Quick Setup:</span>
                @foreach($shifts as $shift)
                <button type="button" onclick="applyShiftToAll('{{ $shift->id }}')" 
                    class="bg-blue-600 text-white px-2 md:px-3 py-1 rounded text-xs md:text-sm hover:bg-blue-700 whitespace-nowrap">
                    All {{ $shift->name }}
                </button>
                @endforeach
                <button type="button" onclick="applyShiftToWeekdays()" 
                    class="bg-green-600 text-white px-2 md:px-3 py-1 rounded text-xs md:text-sm hover:bg-green-700 whitespace-nowrap">
                    Mon-Fri
                </button>
                <button type="button" onclick="clearAll()" 
                    class="bg-red-600 text-white px-2 md:px-3 py-1 rounded text-xs md:text-sm hover:bg-red-700 whitespace-nowrap">
                    Clear All
                </button>
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
            <div class="bg-gray-100 p-1 md:p-2 rounded min-h-20 md:min-h-32"></div>
            @endfor

            <!-- Tanggal dalam bulan -->
            @for($day = 1; $day <= $daysInMonth; $day++)
            @php
                $currentDate = $date->copy()->day($day);
                $dateKey = $currentDate->format('Y-m-d');
                $schedule = $schedules->get($dateKey);
                $isToday = $dateKey === $today;
                $dayOfWeek = $currentDate->dayOfWeek;
            @endphp
            <div class="border-2 {{ $isToday ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} p-1 md:p-2 rounded min-h-20 md:min-h-32" 
                 data-date="{{ $dateKey }}" data-day="{{ $dayOfWeek }}">
                <div class="font-semibold {{ $isToday ? 'text-blue-600' : 'text-gray-700' }} mb-1 md:mb-2 text-xs md:text-base">
                    {{ $day }}
                </div>
                
                <select name="schedules[{{ $dateKey }}][shift_id]" 
                        class="w-full px-1 md:px-2 py-1 border rounded text-xs md:text-sm shift-select"
                        data-date="{{ $dateKey }}">
                    <option value="">Off</option>
                    @foreach($shifts as $shift)
                    <option value="{{ $shift->id }}" {{ $schedule && $schedule->shift_id == $shift->id ? 'selected' : '' }}>
                        {{ $shift->name }}
                    </option>
                    @endforeach
                </select>
                
                <input type="hidden" name="schedules[{{ $dateKey }}][date]" value="{{ $dateKey }}">
                
                @if($schedule)
                <div class="mt-1 text-xs text-gray-600 hidden md:block">
                    {{ $schedule->shift->start_time }} - {{ $schedule->shift->end_time }}
                </div>
                @endif
            </div>
            @endfor

            <!-- Empty cells setelah akhir bulan -->
            @php
                $remainingCells = 7 - (($startDay + $daysInMonth) % 7);
                if ($remainingCells < 7) {
                    for($i = 0; $i < $remainingCells; $i++) {
                        echo '<div class="bg-gray-100 p-1 md:p-2 rounded min-h-20 md:min-h-32"></div>';
                    }
                }
            @endphp
        </div>

        <div class="mt-4 md:mt-6 flex flex-col md:flex-row gap-3 md:gap-4">
            <button type="submit" class="bg-green-600 text-white px-4 md:px-6 py-3 rounded-lg hover:bg-green-700 font-semibold text-sm md:text-base">
                💾 Save All Schedules
            </button>
            <a href="{{ route('schedules.index') }}" class="bg-gray-300 text-gray-700 px-4 md:px-6 py-3 rounded-lg hover:bg-gray-400 text-center text-sm md:text-base">
                Back
            </a>
        </div>
    </form>
</div>

<script>
function applyShiftToAll(shiftId) {
    if (!confirm('Set all days with this shift?')) return;
    
    document.querySelectorAll('.shift-select').forEach(select => {
        select.value = shiftId;
    });
}

function applyShiftToWeekdays() {
    const shiftId = prompt('Enter shift ID for Monday-Friday (see dropdown):');
    if (!shiftId) return;
    
    document.querySelectorAll('[data-day]').forEach(cell => {
        const day = parseInt(cell.dataset.day);
        if (day >= 1 && day <= 5) { // Monday-Friday
            const select = cell.querySelector('.shift-select');
            if (select) select.value = shiftId;
        }
    });
}

function clearAll() {
    if (!confirm('Clear all schedules?')) return;
    
    document.querySelectorAll('.shift-select').forEach(select => {
        select.value = '';
    });
}

// Auto-submit prevention
document.getElementById('scheduleForm').addEventListener('submit', function(e) {
    const button = this.querySelector('button[type="submit"]');
    button.disabled = true;
    button.textContent = 'Saving...';
});
</script>
@endsection
