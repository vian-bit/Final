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
        <div class="flex items-center gap-2">
            {{-- Countdown + Refresh QR (hanya muncul saat QR tersedia) --}}
            <div id="wa-qr-countdown-wrap" class="hidden flex items-center gap-2">
                <span class="text-xs" style="color:var(--gray-500);">QR expired dalam</span>
                <span id="wa-qr-countdown" class="text-xs font-bold" style="color:var(--brown-300);">30</span>
                <span class="text-xs" style="color:var(--gray-500);">detik</span>
            </div>
            <button id="wa-qr-refresh" class="hidden btn btn-secondary text-xs" onclick="refreshQR()">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh QR
            </button>
            <a href="#" id="wa-qr-link" target="_blank" class="hidden btn btn-secondary text-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a.5.5 0 11-1 0 .5.5 0 011 0zM6 20h4"/>
                </svg>
                Scan QR
            </a>
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
let qrCountdownInterval = null;
let qrCountdownValue    = 30;
let qrUrl               = '#';

function startQRCountdown() {
    qrCountdownValue = 30;
    const wrap      = document.getElementById('wa-qr-countdown-wrap');
    const countEl   = document.getElementById('wa-qr-countdown');
    const refreshBtn = document.getElementById('wa-qr-refresh');
    const qrLink    = document.getElementById('wa-qr-link');

    wrap.classList.remove('hidden');
    refreshBtn.classList.add('hidden');
    countEl.style.color = 'var(--brown-300)';

    clearInterval(qrCountdownInterval);
    qrCountdownInterval = setInterval(() => {
        qrCountdownValue--;
        countEl.textContent = qrCountdownValue;

        if (qrCountdownValue <= 10) {
            countEl.style.color = '#dc2626';
        }

        if (qrCountdownValue <= 0) {
            clearInterval(qrCountdownInterval);
            wrap.classList.add('hidden');
            qrLink.classList.add('hidden');
            refreshBtn.classList.remove('hidden');
        }
    }, 1000);
}

async function refreshQR() {
    const btn = document.getElementById('wa-qr-refresh');
    btn.disabled = true;
    btn.textContent = 'Loading...';
    await checkWAStatus();
    btn.disabled = false;
    btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Refresh QR`;
}

async function checkWAStatus() {
    try {
        const res  = await fetch('{{ route("whatsapp.status") }}');
        const data = await res.json();
        const badge      = document.getElementById('wa-badge');
        const text       = document.getElementById('wa-status-text');
        const btn        = document.getElementById('wa-send-btn');
        const qrLink     = document.getElementById('wa-qr-link');
        const refreshBtn = document.getElementById('wa-qr-refresh');
        const wrap       = document.getElementById('wa-qr-countdown-wrap');

        if (!data.server_running) {
            badge.className = 'badge badge-danger';
            badge.textContent = 'Server Mati';
            text.textContent = 'WA Server tidak berjalan';
            clearInterval(qrCountdownInterval);
            wrap.classList.add('hidden');
            qrLink.classList.add('hidden');
            refreshBtn.classList.add('hidden');

        } else if (data.wa_connected) {
            badge.className = 'badge badge-success';
            badge.textContent = 'Terhubung';
            text.textContent = 'WhatsApp siap mengirim pesan';
            btn.disabled = false;
            clearInterval(qrCountdownInterval);
            wrap.classList.add('hidden');
            qrLink.classList.add('hidden');
            refreshBtn.classList.add('hidden');

        } else if (data.has_qr) {
            badge.className = 'badge badge-warning';
            badge.textContent = 'Perlu Scan QR';
            text.textContent = 'Scan QR code untuk menghubungkan WhatsApp';
            qrLink.href = data.qr_url;
            qrLink.classList.remove('hidden');
            refreshBtn.classList.add('hidden');
            // Mulai countdown hanya jika belum berjalan
            if (qrUrl !== data.qr_url) {
                qrUrl = data.qr_url;
                startQRCountdown();
            }

        } else {
            badge.className = 'badge badge-warning';
            badge.textContent = 'Menghubungkan...';
            text.textContent = 'Sedang menghubungkan ke WhatsApp';
        }
    } catch(e) {
        document.getElementById('wa-status-text').textContent = 'Tidak dapat mengecek status';
    }
}

checkWAStatus();
setInterval(checkWAStatus, 10000);
</script>
