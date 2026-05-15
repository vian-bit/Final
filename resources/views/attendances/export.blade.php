@extends('layouts.app')
@section('title', 'Export Attendance Report')
@section('content')
<div class="gh-card">
    <div class="gh-card-header">
        <h1 class="font-header" style="letter-spacing:0.1em;">Export Attendance Report</h1>
    </div>

    <div class="px-6 py-4" style="border-bottom:1px solid var(--cream-200);">
        <form method="GET" action="{{ route('attendances.export') }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label class="gh-label">Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="gh-input">
                </div>
                <div>
                    <label class="gh-label">End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="gh-input">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-1 justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('attendances.export') }}" class="btn btn-secondary flex-1 justify-center">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="px-6 py-4" style="background:rgba(201,168,76,0.06); border-bottom:1px solid var(--cream-200);">
        <div class="text-sm font-bold mb-3" style="color:var(--brown-900);">
            Period: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}
            @if($startDate !== $endDate) — {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }} @endif
        </div>
        <div class="flex flex-wrap gap-3">
            <button onclick="window.print()" class="btn btn-success">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print / Save as PDF
            </button>
            <a href="{{ route('attendances.export', ['start_date' => $startDate, 'end_date' => $endDate, 'format' => 'xlsx']) }}"
               class="btn btn-gold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download Excel (.xlsx)
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="gh-table">
            <thead><tr>
                <th>No</th><th>Date</th><th>Name</th>
                <th class="hidden lg:table-cell">Department</th>
                <th class="hidden md:table-cell">Type</th>
                <th>Shift</th><th>Check In</th><th>Check Out</th>
                <th class="hidden md:table-cell">Durasi</th>
                <th>Status</th>
            </tr></thead>
            <tbody>
                @forelse($attendances as $index => $attendance)
                <tr>
                    <td style="color:var(--gray-300);">{{ $index + 1 }}</td>
                    <td style="color:var(--gray-500);">{{ $attendance->date->format('d/m/Y') }}</td>
                    <td class="font-bold" style="color:var(--brown-900);">{{ $attendance->user->name }}</td>
                    <td class="hidden lg:table-cell" style="color:var(--gray-500);">{{ $attendance->user->department->name }}</td>
                    <td class="hidden md:table-cell" style="color:var(--gray-500);">
                        @if($attendance->user->user_type)
                            {{ $attendance->user->user_type === 'magang' ? 'Intern' : 'Daily Worker' }}
                        @else —
                        @endif
                    </td>
                    <td><span class="badge badge-brown">{{ $attendance->schedule->shift->name }}</span></td>
                    <td>{{ $attendance->check_in ?? '—' }}</td>
                    <td>{{ $attendance->check_out ?? '—' }}</td>
                    <td class="hidden md:table-cell" style="color:var(--gray-500);">
                        @if($attendance->check_in && $attendance->check_out)
                            @php
                                $in  = \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_in);
                                $out = \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_out);
                                $diff = $in->diff($out);
                            @endphp
                            {{ $diff->h }}j {{ $diff->i }}m
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
                <tr><td colspan="10" class="text-center py-10" style="color:var(--gray-300);">No data found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Summary -->
    <div class="px-6 py-5 grid grid-cols-3 gap-4" style="border-top:1px solid var(--cream-200);">
        <div class="text-center p-4 rounded-lg" style="background:#d1fae5; border:1px solid #a7f3d0;">
            <div class="text-2xl font-bold" style="color:#065f46;">{{ $attendances->where('status', 'present')->count() }}</div>
            <div class="text-xs font-bold mt-1" style="color:#065f46; letter-spacing:0.06em; text-transform:uppercase;">Present</div>
        </div>
        <div class="text-center p-4 rounded-lg" style="background:#fef9c3; border:1px solid #fde68a;">
            <div class="text-2xl font-bold" style="color:#854d0e;">{{ $attendances->where('status', 'late')->count() }}</div>
            <div class="text-xs font-bold mt-1" style="color:#854d0e; letter-spacing:0.06em; text-transform:uppercase;">Late</div>
        </div>
        <div class="text-center p-4 rounded-lg" style="background:#fee2e2; border:1px solid #fca5a5;">
            <div class="text-2xl font-bold" style="color:#991b1b;">{{ $attendances->where('status', 'absent')->count() }}</div>
            <div class="text-xs font-bold mt-1" style="color:#991b1b; letter-spacing:0.06em; text-transform:uppercase;">Absent</div>
        </div>
    </div>
</div>

<style>
@media print {
    nav, aside, .gh-card-header button, form, .no-print { display: none !important; }
    body { background: white; }
}
</style>
@endsection
