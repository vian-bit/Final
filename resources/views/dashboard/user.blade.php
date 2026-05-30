@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<!-- User Info -->
<div class="flex flex-wrap gap-3 mb-5">
    <div class="gh-card flex items-center gap-3 px-4 py-3" style="padding:12px 16px;">
        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,var(--brown-400),var(--brown-600));">
            <svg class="w-4 h-4" fill="none" stroke="var(--cream-50)" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <div>
            <div class="text-xs" style="color:var(--gray-300); letter-spacing:0.06em; text-transform:uppercase;">Department</div>
            <div class="text-sm font-bold" style="color:var(--brown-900);">{{ Auth::user()->department->name ?? '—' }}</div>
        </div>
    </div>
    <div class="gh-card flex items-center gap-3 px-4 py-3" style="padding:12px 16px;">
        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,var(--brown-300),#a8832a);">
            <svg class="w-4 h-4" fill="none" stroke="var(--brown-900)" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
        </div>
        <div>
            <div class="text-xs" style="color:var(--gray-300); letter-spacing:0.06em; text-transform:uppercase;">Type</div>
            <div class="text-sm font-bold" style="color:var(--brown-900);">
                @if(Auth::user()->user_type === 'trainee') Trainee
                @else {{ Auth::user()->user_type_label }}
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Early Checkout Notifications -->
@if($earlyCheckoutRequest)
    @if($earlyCheckoutRequest->status === 'pending')
    <div class="alert alert-info mb-4 flex items-start gap-3">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <div class="font-bold text-sm">Early Checkout Request Pending</div>
            <div class="text-xs mt-0.5">Request checkout jam {{ $earlyCheckoutRequest->requested_checkout_time }} sedang menunggu persetujuan admin.</div>
        </div>
    </div>
    @elseif($earlyCheckoutRequest->status === 'approved')
    <div class="alert alert-success mb-4 flex items-start gap-3">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <div class="font-bold text-sm">Early Checkout Approved</div>
            <div class="text-xs mt-0.5">Disetujui oleh {{ $earlyCheckoutRequest->approvedBy->name }}.
                @if($earlyCheckoutRequest->admin_notes) "{{ $earlyCheckoutRequest->admin_notes }}"@endif
            </div>
        </div>
    </div>
    @elseif($earlyCheckoutRequest->status === 'rejected')
    <div class="alert alert-error mb-4 flex items-start gap-3">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <div class="font-bold text-sm">Early Checkout Rejected</div>
            <div class="text-xs mt-0.5">Ditolak oleh {{ $earlyCheckoutRequest->approvedBy->name }}.
                @if($earlyCheckoutRequest->admin_notes) Alasan: "{{ $earlyCheckoutRequest->admin_notes }}"@endif
            </div>
        </div>
    </div>
    @endif
@endif

<!-- Today's Schedule & Attendance -->
@if($todaySchedule)
<div class="gh-card mb-5" style="padding:0; overflow:hidden;">
    <div class="gh-card-header">
        <h2 class="font-header" style="letter-spacing:0.1em;">Today's Schedule</h2>
    </div>
    <div class="p-5">
        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <div class="text-xs font-bold mb-1" style="color:var(--gray-300); letter-spacing:0.08em; text-transform:uppercase;">Shift</div>
                <div class="font-bold" style="color:var(--brown-900);">{{ $todaySchedule->shift->name }}</div>
            </div>
            <div>
                <div class="text-xs font-bold mb-1" style="color:var(--gray-300); letter-spacing:0.08em; text-transform:uppercase;">Working Hours</div>
                <div class="font-bold" style="color:var(--brown-900);">{{ $todaySchedule->shift->start_time }} — {{ $todaySchedule->shift->end_time }}</div>
            </div>
        </div>

        @if(!$todayAttendance || !$todayAttendance->check_in)
        <button onclick="confirmCheckIn()"
            class="btn btn-success w-full justify-center py-4 text-base" style="font-size:1rem;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Check In Now
        </button>
        <form method="POST" action="{{ route('attendances.checkin') }}" id="checkinForm" class="hidden">@csrf</form>

        @elseif(!$todayAttendance->check_out)
        <div class="p-3 rounded-lg mb-4 flex items-center gap-2" style="background:#d1fae5; border:1px solid #a7f3d0;">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#065f46" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm font-bold" style="color:#065f46;">Checked In: {{ $todayAttendance->check_in }}</span>
        </div>

        <div class="text-center mb-4">
            <div class="text-xs font-bold mb-1" style="color:var(--gray-300); letter-spacing:0.08em; text-transform:uppercase;">Working Time</div>
            <div class="text-2xl font-bold" id="work-duration" style="color:var(--brown-900); font-family:'Copperplate',serif;">00:00:00</div>
        </div>

        @if($earlyCheckoutRequest && $earlyCheckoutRequest->status === 'pending')
        <button disabled class="btn w-full justify-center py-4" style="background:#fef9c3; color:#854d0e; cursor:not-allowed; opacity:0.8; font-size:0.9rem;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Menunggu Persetujuan Admin...
        </button>
        @else
        <button onclick="showCheckOutModal()"
            class="btn btn-primary w-full justify-center py-4" style="font-size:1rem;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Check Out Now
        </button>
        @endif
        <form method="POST" action="{{ route('attendances.checkout') }}" id="checkoutForm" class="hidden">
            @csrf
            <input type="hidden" name="reason" id="checkoutReason">
        </form>

        @else
        <div class="p-4 rounded-lg text-center" style="background:var(--cream-100); border:1px solid var(--cream-200);">
            <div class="text-sm mb-1" style="color:var(--gray-500);">Check In: <span class="font-bold" style="color:var(--brown-900);">{{ $todayAttendance->check_in }}</span></div>
            <div class="text-sm mb-3" style="color:var(--gray-500);">Check Out: <span class="font-bold" style="color:var(--brown-900);">{{ $todayAttendance->check_out }}</span></div>
            <span class="badge badge-success">Attendance Complete</span>
        </div>
        @endif
    </div>
</div>
@elseif($todayAttendance && !$todayAttendance->check_out)
{{-- Tidak ada schedule hari ini tapi ada attendance overnight yang belum checkout --}}
<div class="gh-card mb-5" style="padding:0; overflow:hidden;">
    <div class="gh-card-header">
        <h2 class="font-header" style="letter-spacing:0.1em;">Overnight Shift</h2>
    </div>
    <div class="p-5">
        @php
            $overnightShift = $todayAttendance->schedule?->shift;
            $overnightShiftEnd = $overnightShift?->end_time;
        @endphp
        <div class="p-3 rounded-lg mb-4 flex items-center gap-2" style="background:#d1fae5; border:1px solid #a7f3d0;">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#065f46" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm font-bold" style="color:#065f46;">
                Checked In: {{ $todayAttendance->check_in }} ({{ $todayAttendance->date->format('d/m/Y') }})
                @if($overnightShift) — Shift {{ $overnightShift->name }} s/d {{ $overnightShiftEnd }} @endif
            </span>
        </div>

        <div class="text-center mb-4">
            <div class="text-xs font-bold mb-1" style="color:var(--gray-300); letter-spacing:0.08em; text-transform:uppercase;">Working Time</div>
            <div class="text-2xl font-bold" id="work-duration" style="color:var(--brown-900); font-family:'Copperplate',serif;">00:00:00</div>
        </div>

        <button onclick="showCheckOutModal()"
            class="btn btn-primary w-full justify-center py-4" style="font-size:1rem;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Check Out Now
        </button>
        <form method="POST" action="{{ route('attendances.checkout') }}" id="checkoutForm" class="hidden">
            @csrf
            <input type="hidden" name="reason" id="checkoutReason">
        </form>
    </div>
</div>
@else
<div class="gh-card mb-5 text-center py-8" style="color:var(--gray-300);">
    <svg class="w-10 h-10 mx-auto mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>
    <p class="text-sm font-bold">No schedule today</p>
</div>
@endif

<!-- Recent Attendance -->
<div class="gh-card" style="padding:0; overflow:hidden;">
    <div class="gh-card-header">
        <h2 class="font-header" style="letter-spacing:0.1em;">Recent Attendance</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="gh-table">
            <thead><tr>
                <th>Date</th><th>Check In</th><th>Check Out</th><th>Durasi</th><th>Status</th>
            </tr></thead>
            <tbody>
                @forelse($recentAttendances as $attendance)
                <tr>
                    <td style="color:var(--gray-500);">{{ $attendance->date->format('d/m/Y') }}</td>
                    <td>{{ $attendance->check_in ?? '—' }}</td>
                    <td>{{ $attendance->check_out ?? '—' }}</td>
                    <td style="color:var(--gray-500);">
                        @if($attendance->check_in && $attendance->check_out)
                            @php $diff = \Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_in)->diff(\Carbon\Carbon::createFromFormat('H:i:s', $attendance->check_out)); @endphp
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
                <tr><td colspan="5" class="text-center py-8" style="color:var(--gray-300);">No attendance history yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Check Out Modal -->
<div id="checkoutModal" class="fixed inset-0 hidden items-center justify-center z-50 p-4" style="background:rgba(58,42,26,0.6);">
    <div class="gh-card w-full max-w-md">
        <div class="gh-card-header">
            <h3 class="font-header" style="letter-spacing:0.1em;">Check Out Confirmation</h3>
        </div>
        <div class="gh-card-body">
            <div id="earlyCheckoutWarning" class="hidden alert alert-info mb-4">
                Anda checkout sebelum jam shift berakhir. Ini memerlukan persetujuan admin.
            </div>
            <div class="mb-5">
                <label class="gh-label">Reason (optional)</label>
                <textarea id="reasonInput" rows="3" class="gh-textarea" placeholder="Masukkan alasan jika checkout lebih awal..."></textarea>
            </div>
            <div class="flex gap-3">
                <button onclick="submitCheckOut()" class="btn btn-primary flex-1 justify-center">Confirm Check Out</button>
                <button onclick="closeCheckOutModal()" class="btn btn-secondary flex-1 justify-center">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
@if($todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out)
const checkInTimestamp = {{ \Carbon\Carbon::parse($todayAttendance->date->format('Y-m-d') . ' ' . $todayAttendance->check_in)->timestamp }};
@endif

function updateTime() {
    const el = document.getElementById('work-duration');
    if (el && typeof checkInTimestamp !== 'undefined') {
        const diff = Math.max(0, Math.floor(Date.now() / 1000) - checkInTimestamp);
        const h = String(Math.floor(diff / 3600)).padStart(2, '0');
        const m = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
        const s = String(diff % 60).padStart(2, '0');
        el.textContent = `${h}:${m}:${s}`;
    }
}
function confirmCheckIn() {
    if (confirm('Check in sekarang?')) document.getElementById('checkinForm').submit();
}
function showCheckOutModal() {
    document.getElementById('checkoutModal').classList.remove('hidden');
    document.getElementById('checkoutModal').classList.add('flex');
    @if($todaySchedule)
    const now = new Date();
    const cur = now.getHours() * 60 + now.getMinutes();
    const [eh, em] = '{{ $todaySchedule->shift->end_time }}'.split(':').map(Number);
    if (cur < eh * 60 + em) document.getElementById('earlyCheckoutWarning').classList.remove('hidden');
    @elseif($todayAttendance && !$todayAttendance->check_out && $todayAttendance->schedule?->shift)
    const now = new Date();
    const cur = now.getHours() * 60 + now.getMinutes();
    const [eh, em] = '{{ $todayAttendance->schedule?->shift?->end_time ?? "00:00" }}'.split(':').map(Number);
    // Overnight: end_time lebih kecil dari start_time, jadi cek apakah belum lewat end_time hari ini
    if (cur < eh * 60 + em) document.getElementById('earlyCheckoutWarning').classList.remove('hidden');
    @endif
}
function closeCheckOutModal() {
    document.getElementById('checkoutModal').classList.add('hidden');
    document.getElementById('checkoutModal').classList.remove('flex');
    document.getElementById('reasonInput').value = '';
    document.getElementById('earlyCheckoutWarning').classList.add('hidden');
}
function submitCheckOut() {
    document.getElementById('checkoutReason').value = document.getElementById('reasonInput').value;
    document.getElementById('checkoutForm').submit();
}
setInterval(updateTime, 1000);
updateTime();
</script>
@endsection
