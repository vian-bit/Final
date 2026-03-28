@extends('layouts.app')

@section('title', 'Manual Attendance')

@section('content')
<div class="bg-white rounded-lg shadow p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 md:mb-6 gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Manual Attendance Management</h1>
            <p class="text-sm text-gray-600 mt-1">Bypass check-in/check-out for human error cases</p>
        </div>
        <div class="text-sm text-gray-600">
            <span class="font-semibold">Date:</span> {{ now()->format('d/m/Y') }}
        </div>
    </div>

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

    <!-- Bulk Actions -->
    <div class="mb-6 bg-blue-50 border-2 border-blue-200 rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-3">Bulk Actions</h2>
        <div class="flex flex-col md:flex-row gap-3">
            <button onclick="confirmBulkCheckIn()" 
                class="flex-1 bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 font-semibold flex items-center justify-center gap-2">
                <span class="text-xl">✓</span>
                <span>Check In All Users</span>
            </button>
            <button onclick="confirmBulkCheckOut()" 
                class="flex-1 bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 font-semibold flex items-center justify-center gap-2">
                <span class="text-xl">✓</span>
                <span>Check Out All Users</span>
            </button>
        </div>
        <p class="text-xs text-gray-600 mt-2">
            ⚠️ Bulk actions will process all users with schedule today in your department
        </p>
    </div>

    <!-- Users List -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm md:text-base">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 md:px-4 py-2 text-left">User</th>
                    <th class="px-2 md:px-4 py-2 text-left hidden lg:table-cell">Department</th>
                    <th class="px-2 md:px-4 py-2 text-left">Shift</th>
                    <th class="px-2 md:px-4 py-2 text-left">Check In</th>
                    <th class="px-2 md:px-4 py-2 text-left">Check Out</th>
                    <th class="px-2 md:px-4 py-2 text-left">Status</th>
                    <th class="px-2 md:px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                @php
                    $schedule = $user->schedules->first();
                    $attendance = $attendances->get($user->id);
                @endphp
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-2 md:px-4 py-3">
                        <div class="font-semibold">{{ $user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $user->user_type === 'magang' ? 'Intern' : 'Daily Worker' }}</div>
                    </td>
                    <td class="px-2 md:px-4 py-3 hidden lg:table-cell">{{ $user->department->name }}</td>
                    <td class="px-2 md:px-4 py-3">
                        @if($schedule)
                        <div class="text-sm">
                            <div class="font-semibold">{{ $schedule->shift->name }}</div>
                            <div class="text-xs text-gray-500">{{ $schedule->shift->start_time }} - {{ $schedule->shift->end_time }}</div>
                        </div>
                        @else
                        <span class="text-gray-400 text-sm">No schedule</span>
                        @endif
                    </td>
                    <td class="px-2 md:px-4 py-3">
                        @if($attendance && $attendance->check_in)
                        <span class="text-green-600 font-semibold">{{ $attendance->check_in }}</span>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-2 md:px-4 py-3">
                        @if($attendance && $attendance->check_out)
                        <span class="text-blue-600 font-semibold">{{ $attendance->check_out }}</span>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-2 md:px-4 py-3">
                        @if($attendance)
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @if($attendance->status == 'present') bg-green-100 text-green-800
                            @elseif($attendance->status == 'late') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($attendance->status) }}
                        </span>
                        @else
                        <span class="text-gray-400 text-xs">Not checked in</span>
                        @endif
                    </td>
                    <td class="px-2 md:px-4 py-3">
                        @if($schedule)
                        <div class="flex flex-col md:flex-row gap-2">
                            @if(!$attendance || !$attendance->check_in)
                            <button onclick="showCheckInModal({{ $user->id }}, '{{ $user->name }}')" 
                                class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600 whitespace-nowrap">
                                Check In
                            </button>
                            @elseif(!$attendance->check_out)
                            <button onclick="showCheckOutModal({{ $user->id }}, '{{ $user->name }}')" 
                                class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 whitespace-nowrap">
                                Check Out
                            </button>
                            @else
                            <span class="text-green-600 text-xs font-semibold">✓ Complete</span>
                            @endif
                        </div>
                        @else
                        <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-2 md:px-4 py-4 text-center text-gray-500">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Check In Modal -->
<div id="checkInModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-xl font-bold mb-4">Manual Check In</h3>
        
        <p class="mb-4">Check in for <span id="checkInUserName" class="font-semibold"></span>?</p>

        <form method="POST" action="{{ route('manual-attendance.checkin') }}" id="checkInForm">
            @csrf
            <input type="hidden" name="user_id" id="checkInUserId">
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Check In Time:</label>
                <input type="time" name="check_in_time" id="checkInTime" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="flex gap-3">
                <button type="submit" 
                    class="flex-1 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    Confirm Check In
                </button>
                <button type="button" onclick="closeCheckInModal()" 
                    class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Check Out Modal -->
<div id="checkOutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-xl font-bold mb-4">Manual Check Out</h3>
        
        <p class="mb-4">Check out for <span id="checkOutUserName" class="font-semibold"></span>?</p>

        <form method="POST" action="{{ route('manual-attendance.checkout') }}" id="checkOutForm">
            @csrf
            <input type="hidden" name="user_id" id="checkOutUserId">
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Check Out Time:</label>
                <input type="time" name="check_out_time" id="checkOutTime" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="flex gap-3">
                <button type="submit" 
                    class="flex-1 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Confirm Check Out
                </button>
                <button type="button" onclick="closeCheckOutModal()" 
                    class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Check In Form -->
<form method="POST" action="{{ route('manual-attendance.bulk-checkin') }}" id="bulkCheckInForm" class="hidden">
    @csrf
</form>

<!-- Bulk Check Out Form -->
<form method="POST" action="{{ route('manual-attendance.bulk-checkout') }}" id="bulkCheckOutForm" class="hidden">
    @csrf
</form>

<script>
// Set current time as default
function setCurrentTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    return `${hours}:${minutes}`;
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
    if (confirm('Are you sure you want to check in ALL users with schedule today?\n\nThis will use current time for all check-ins.')) {
        document.getElementById('bulkCheckInForm').submit();
    }
}

function confirmBulkCheckOut() {
    if (confirm('Are you sure you want to check out ALL users who have checked in today?\n\nThis will use current time for all check-outs.')) {
        document.getElementById('bulkCheckOutForm').submit();
    }
}
</script>
@endsection
