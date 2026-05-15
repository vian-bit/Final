@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')

<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
    @php
    $stats = [
        ['label' => 'Total Users',       'value' => $totalUsers,      'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['label' => "Today's Schedule",  'value' => $todaySchedules,  'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['label' => 'Present',           'value' => $todayPresent,    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Late',              'value' => $todayLate,       'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];
    @endphp
    @foreach($stats as $stat)
    <div class="gh-card" style="padding:0; overflow:hidden;">
        <div style="background:linear-gradient(135deg,var(--brown-900),var(--brown-600)); padding:16px 20px; border-bottom:2px solid var(--brown-300);">
            <svg class="w-5 h-5 mb-1" fill="none" stroke="rgba(201,168,76,0.8)" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
            </svg>
            <div class="text-2xl font-bold" style="color:var(--cream-50);">{{ $stat['value'] }}</div>
        </div>
        <div style="padding:10px 20px;">
            <div class="text-xs font-bold" style="color:var(--gray-500); letter-spacing:0.08em; text-transform:uppercase;">{{ $stat['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

@if($pendingEarlyCheckouts > 0)
<div class="gh-card mb-5" style="border-left:3px solid var(--brown-300); padding:0; overflow:hidden;">
    <div class="flex items-center justify-between px-5 py-4">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="var(--brown-300)" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <div>
                <div class="font-bold text-sm" style="color:var(--brown-900);">Pending Early Checkout Requests</div>
                <div class="text-xs" style="color:var(--gray-500);">{{ $pendingEarlyCheckouts }} request(s) waiting for approval</div>
            </div>
        </div>
        <a href="{{ route('early-checkout.index') }}" class="btn btn-gold text-xs">View Requests</a>
    </div>
</div>
@endif

<!-- Quick Menu -->
<div class="gh-card mb-5" style="padding:0; overflow:hidden;">
    <div class="gh-card-header">
        <h2 class="font-header" style="letter-spacing:0.1em;">Quick Menu</h2>
    </div>
    <div class="p-5 grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
        $menus = [
            ['href' => route('users.create'),        'label' => 'Add User',       'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'],
            ['href' => route('shifts.index'),        'label' => 'Manage Shifts',  'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['href' => route('schedules.calendar'),  'label' => 'Schedule',       'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['href' => route('attendances.export'),  'label' => 'Export Report',  'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4'],
        ];
        @endphp
        @foreach($menus as $menu)
        <a href="{{ $menu['href'] }}" class="flex flex-col items-center gap-3 p-5 rounded-xl transition-all duration-200 text-center group"
            style="background:var(--cream-100); border:1px solid var(--cream-200);"
            onmouseover="this.style.background='var(--warm-200)'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(139,99,64,0.18)';"
            onmouseout="this.style.background='var(--cream-100)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,var(--brown-400),var(--brown-600)); box-shadow:0 3px 10px rgba(139,99,64,0.3);">
                <svg class="w-6 h-6" fill="none" stroke="#FAF8F5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $menu['icon'] }}"/>
                </svg>
            </div>
            <span class="text-xs font-bold tracking-wide" style="color:var(--brown-700);">{{ $menu['label'] }}</span>
        </a>
        @endforeach
    </div>
</div>

<!-- WhatsApp Status -->
<div class="gh-card" style="padding:0; overflow:hidden;">
    <div class="gh-card-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="rgba(201,168,76,0.8)" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <h2 class="font-header" style="letter-spacing:0.1em;">WhatsApp Status</h2>
            <span id="wa-badge" class="badge badge-gray">...</span>
        </div>
        <div class="flex gap-2">
            <a href="#" id="wa-qr-link" target="_blank" class="hidden btn btn-secondary text-xs">Scan QR</a>
            <form method="POST" action="{{ route('whatsapp.send-report') }}">
                @csrf
                <button type="submit" id="wa-send-btn" class="btn btn-success text-xs" disabled>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Rekap
                </button>
            </form>
        </div>
    </div>
    <div class="px-6 py-3">
        <p class="text-sm" id="wa-status-text" style="color:var(--gray-500);">Mengecek koneksi...</p>
    </div>
</div>

<script>
async function checkWAStatus() {
    try {
        const res  = await fetch('{{ route("whatsapp.status") }}');
        const data = await res.json();
        const badge  = document.getElementById('wa-badge');
        const text   = document.getElementById('wa-status-text');
        const btn    = document.getElementById('wa-send-btn');
        const qrLink = document.getElementById('wa-qr-link');

        if (!data.server_running) {
            badge.className = 'badge badge-danger'; badge.textContent = 'Server Mati';
            text.textContent = 'Jalankan START-WA-SERVER.bat terlebih dahulu';
        } else if (data.wa_connected) {
            badge.className = 'badge badge-success'; badge.textContent = 'Terhubung';
            text.textContent = 'WhatsApp siap mengirim pesan';
            btn.disabled = false; qrLink.classList.add('hidden');
        } else if (data.has_qr) {
            badge.className = 'badge badge-warning'; badge.textContent = 'Perlu Scan QR';
            text.textContent = 'Klik "Scan QR" untuk menghubungkan WhatsApp';
            qrLink.href = data.qr_url; qrLink.classList.remove('hidden');
        } else {
            badge.className = 'badge badge-warning'; badge.textContent = 'Menghubungkan...';
            text.textContent = 'Sedang menghubungkan ke WhatsApp';
        }
    } catch(e) {
        document.getElementById('wa-status-text').textContent = 'Tidak dapat mengecek status';
    }
}
checkWAStatus();
setInterval(checkWAStatus, 10000);
</script>
@endsection
