@extends('layouts.app')
@section('title', 'Manual Attendance')
@section('content')
<div class="gh-card">
    <div class="gh-card-header flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <div>
            <h1 class="font-header" style="letter-spacing:0.1em;">Manual Attendance</h1>
            <p class="text-xs mt-1" style="color:rgba(250,248,245,0.6);">Bypass check-in/check-out for human error cases</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Filter tanggal --}}
            <form method="GET" class="flex items-center gap-2">
                <input type="date" name="date" value="{{ request('date', today()->format('Y-m-d')) }}"
                    class="gh-input text-xs" style="width:auto; color:var(--brown-900);">
                <button type="submit" class="btn btn-gold text-xs px-3 py-1.5">Filter</button>
                @if(request('date') && request('date') !== today()->format('Y-m-d'))
                <a href="{{ route('manual-attendance.index') }}" class="btn btn-secondary text-xs px-3 py-1.5">Today</a>
                @endif
            </form>
            <div class="text-xs" style="color:rgba(250,248,245,0.7); letter-spacing:0.06em;">
                {{ \Carbon\Carbon::parse(request('date', today()))->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="px-6 py-4" style="background:rgba(201,168,76,0.06); border-bottom:1px solid var(--cream-200);">
        <div class="text-xs font-bold mb-3" style="color:var(--gray-500); letter-spacing:0.08em; text-transform:uppercase;">Bulk Actions</div>
        <div class="flex flex-col sm:flex-row gap-3">
            <button onclick="confirmBulkCheckIn()"
                class="btn btn-success flex-1 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Check In All Users
            </button>
            <button onclick="confirmBulkCheckOut()"
                class="btn btn-danger flex-1 justify-center" style="background:linear-gradient(135deg,#dc2626,#991b1b); color:#fff; padding:9px 20px;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Check Out All Users
            </button>
        </div>
        <p class="text-xs mt-2" style="color:var(--gray-300);">Bulk actions will process all users with schedule today in your department</p>
    </div>

    <div class="overflow-x-auto">
        <table class="gh-table">
            <thead><tr>
                <th>User</th>
                <th class="hidden lg:table-cell">Department</th>
                <th>Shift</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
                <th>Actions</th>
            </tr></thead>
            <tbody>
                @forelse($users as $user)
                @php
                    $schedule = $user->schedules->first();
                    $attendance = $attendances->get($user->id);
                @endphp
                <tr>
                    <td>
                        <div class="font-bold" style="color:var(--brown-900);">{{ $user->name }}</div>
                        <div class="text-xs" style="color:var(--gray-300);">{{ $user->user_type_label }}</div>
                    </td>
                    <td class="hidden lg:table-cell" style="color:var(--gray-500);">{{ $user->department->name }}</td>
                    <td>
                        @if($schedule)
                        <div class="font-bold text-sm" style="color:var(--brown-900);">{{ $schedule->shift->name }}</div>
                        <div class="text-xs" style="color:var(--gray-300);">{{ $schedule->shift->start_time }} - {{ $schedule->shift->end_time }}</div>
                        @else
                        <span style="color:var(--gray-300);">—</span>
                        @endif
                    </td>
                    <td>
                        @if($attendance && $attendance->check_in)
                        <span class="font-bold" style="color:#065f46;">{{ $attendance->check_in }}</span>
                        @else <span style="color:var(--gray-300);">—</span>
                        @endif
                    </td>
                    <td>
                        @if($attendance && $attendance->check_out)
                        <span class="font-bold" style="color:var(--brown-600);">{{ $attendance->check_out }}</span>
                        @else <span style="color:var(--gray-300);">—</span>
                        @endif
                    </td>
                    <td>
                        @if($attendance)
                        <span class="badge
                            @if($attendance->status == 'present') badge-success
                            @elseif($attendance->status == 'late') badge-warning
                            @else badge-danger @endif">
                            {{ ucfirst($attendance->status) }}
                        </span>
                        @else
                        <span class="badge badge-gray">Not in</span>
                        @endif
                    </td>
                    <td>
                        @if($schedule)
                        @if(!$attendance || !$attendance->check_in)
                        <button onclick="showCheckInModal({{ $user->id }}, '{{ $user->name }}')" class="btn btn-success text-xs px-3 py-1.5">
                            Check In
                        </button>
                        @elseif(!$attendance->check_out)
                        <button onclick="showCheckOutModal({{ $user->id }}, '{{ $user->name }}')" class="btn btn-danger text-xs px-3 py-1.5" style="background:#dc2626; color:#fff;">
                            Check Out
                        </button>
                        @else
                        <span class="badge badge-success">Complete</span>
                        @endif
                        @else
                        <span style="color:var(--gray-300);">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-10" style="color:var(--gray-300);">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Check In Modal -->
<div id="checkInModal" class="fixed inset-0 hidden items-center justify-center z-50 p-4" style="background:rgba(58,42,26,0.6);">
    <div class="gh-card w-full max-w-md">
        <div class="gh-card-header">
            <h3 class="font-header" style="letter-spacing:0.1em;">Manual Check In</h3>
        </div>
        <div class="gh-card-body">
            <p class="mb-4 text-sm" style="color:var(--gray-500);">Check in for <span id="checkInUserName" class="font-bold" style="color:var(--brown-900);"></span>?</p>
            <form method="POST" action="{{ route('manual-attendance.checkin') }}" id="checkInForm">
                @csrf
                <input type="hidden" name="user_id" id="checkInUserId">
                <input type="hidden" name="date" value="{{ request('date', today()->format('Y-m-d')) }}">
                <div class="mb-5">
                    <label class="gh-label">Check In Time</label>
                    <input type="time" name="check_in_time" id="checkInTime" required class="gh-input">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn btn-success flex-1 justify-center">Confirm</button>
                    <button type="button" onclick="closeCheckInModal()" class="btn btn-secondary flex-1 justify-center">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Check Out Modal -->
<div id="checkOutModal" class="fixed inset-0 hidden items-center justify-center z-50 p-4" style="background:rgba(58,42,26,0.6);">
    <div class="gh-card w-full max-w-md">
        <div class="gh-card-header">
            <h3 class="font-header" style="letter-spacing:0.1em;">Manual Check Out</h3>
        </div>
        <div class="gh-card-body">
            <p class="mb-4 text-sm" style="color:var(--gray-500);">Check out for <span id="checkOutUserName" class="font-bold" style="color:var(--brown-900);"></span>?</p>
            <form method="POST" action="{{ route('manual-attendance.checkout') }}" id="checkOutForm">
                @csrf
                <input type="hidden" name="user_id" id="checkOutUserId">
                <input type="hidden" name="date" value="{{ request('date', today()->format('Y-m-d')) }}">
                <div class="mb-5">
                    <label class="gh-label">Check Out Time</label>
                    <input type="time" name="check_out_time" id="checkOutTime" required class="gh-input">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn btn-primary flex-1 justify-center">Confirm</button>
                    <button type="button" onclick="closeCheckOutModal()" class="btn btn-secondary flex-1 justify-center">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('manual-attendance.bulk-checkin') }}" id="bulkCheckInForm" class="hidden">@csrf</form>
<form method="POST" action="{{ route('manual-attendance.bulk-checkout') }}" id="bulkCheckOutForm" class="hidden">@csrf</form>

<script>
function setCurrentTime() {
    const now = new Date();
    return `${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}`;
}
function showCheckInModal(userId, userName) {
    document.getElementById('checkInUserId').value = userId;
    document.getElementById('checkInUserName').textContent = userName;
    document.getElementById('checkInTime').value = setCurrentTime();
    document.getElementById('checkInModal').classList.remove('hidden');
    document.getElementById('checkInModal').classList.add('flex');
}
function closeCheckInModal() {
    document.getElementById('checkInModal').classList.add('hidden');
    document.getElementById('checkInModal').classList.remove('flex');
}
function showCheckOutModal(userId, userName) {
    document.getElementById('checkOutUserId').value = userId;
    document.getElementById('checkOutUserName').textContent = userName;
    document.getElementById('checkOutTime').value = setCurrentTime();
    document.getElementById('checkOutModal').classList.remove('hidden');
    document.getElementById('checkOutModal').classList.add('flex');
}
function closeCheckOutModal() {
    document.getElementById('checkOutModal').classList.add('hidden');
    document.getElementById('checkOutModal').classList.remove('flex');
}
function confirmBulkCheckIn() {
    if (confirm('Check in ALL users with schedule today?\n\nThis will use current time for all check-ins.')) {
        document.getElementById('bulkCheckInForm').submit();
    }
}
function confirmBulkCheckOut() {
    if (confirm('Check out ALL users who have checked in today?\n\nThis will use current time for all check-outs.')) {
        document.getElementById('bulkCheckOutForm').submit();
    }
}
</script>
@endsection
