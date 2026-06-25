@extends('layouts.app')
@section('title', 'Attendance Data')
@section('content')
<div class="gh-card">
    <div class="gh-card-header flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <h1 class="font-header" style="letter-spacing:0.1em;">Attendance Data</h1>
        @if(Auth::user()->isSuperuser() || Auth::user()->isAdmin())
        <a href="{{ route('attendances.export') }}" class="btn btn-gold text-xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Export Report
        </a>
        @endif
    </div>

    <!-- Filters -->
    <div class="px-6 py-4" style="border-bottom:1px solid var(--cream-200);">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold" style="color:var(--gray-500); letter-spacing:0.06em;">DARI</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="gh-input" style="width:auto; min-width:150px;">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold" style="color:var(--gray-500); letter-spacing:0.06em;">SAMPAI</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="gh-input" style="width:auto; min-width:150px;">
            </div>
            @if(Auth::user()->isSuperuser() || Auth::user()->isAdmin())
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold" style="color:var(--gray-500); letter-spacing:0.06em;">USER</label>
                <select name="user_id" class="gh-select" style="width:auto; min-width:180px;">
                    <option value="">— Semua User —</option>
                    @foreach($filterUsers as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="gh-table">
            <thead><tr>
                <th>Date</th><th>User</th>
                <th class="hidden lg:table-cell">Shift</th>
                <th>Check In</th><th>Check Out</th>
                <th class="hidden md:table-cell">Duration</th>
                <th>Status</th>
            </tr></thead>
            <tbody>
                @forelse($attendances as $attendance)
                <tr>
                    <td style="color:var(--gray-500);">{{ $attendance->date->format('d/m/Y') }}</td>
                    <td class="font-bold" style="color:var(--brown-900);">{{ $attendance->user->name }}</td>
                    <td class="hidden lg:table-cell" style="color:var(--gray-500);">{{ $attendance->schedule->shift->name }}</td>
                    <td>{{ $attendance->check_in ?? '—' }}</td>
                    <td>{{ $attendance->check_out ?? '—' }}</td>
                    <td class="hidden md:table-cell" style="color:var(--gray-500);">
                        @if($attendance->check_in && $attendance->check_out)
                            @php
                                $checkIn  = \Carbon\Carbon::parse($attendance->date->format('Y-m-d') . ' ' . $attendance->check_in);
                                $checkOut = \Carbon\Carbon::parse($attendance->date->format('Y-m-d') . ' ' . $attendance->check_out);
                                if ($checkOut->lessThan($checkIn)) $checkOut->addDay();
                                $diff = $checkIn->diff($checkOut);
                            @endphp
                            {{ $diff->h + ($diff->days * 24) }}j {{ $diff->i }}m
                        @else —
                        @endif
                    </td>
                    <td>
                        <span class="badge
                            @if($attendance->status == 'present') badge-success
                            @elseif($attendance->status == 'late') badge-warning
                            @else badge-danger @endif">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-10" style="color:var(--gray-300);">
                        <svg class="w-8 h-8 mx-auto mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        No attendance data found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4">{{ $attendances->links() }}</div>
</div>
@endsection
