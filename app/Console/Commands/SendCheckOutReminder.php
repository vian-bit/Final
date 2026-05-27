<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SendCheckOutReminder extends Command
{
    protected $signature   = 'attendance:send-checkout-reminder {--force : Kirim ke semua user yang sudah check-in tapi belum check-out}';
    protected $description = 'Kirim notifikasi WA ke user 5 menit setelah shift selesai (jika belum check-out)';

    public function handle(WhatsAppService $wa): int
    {
        $now   = Carbon::now('Asia/Jakarta');
        $force = $this->option('force');

        $query = Attendance::with(['user', 'schedule.shift'])
            ->whereDate('date', today())
            ->whereNotNull('check_in')
            ->whereNull('check_out');

        if (!$force) {
            // Kirim ke user yang shift-nya sudah selesai dalam 10 menit terakhir (toleransi lebih longgar)
            // end_time antara (now - 10 menit) sampai (now)
            $query->whereHas('schedule.shift', function ($q) use ($now) {
                $q->whereBetween('end_time', [
                    $now->copy()->subMinutes(10)->format('H:i:s'),
                    $now->format('H:i:s'),
                ]);
            });
        }

        $attendances = $query->get();

        if ($attendances->isEmpty()) {
            $this->line('Tidak ada reminder checkout yang perlu dikirim.');
            return self::SUCCESS;
        }

        $targets = [];
        foreach ($attendances as $attendance) {
            $user = $attendance->user;
            if (!$user->is_active) continue;
            if (empty($user->phone) && empty($user->wa_lid)) continue;

            // Dedup: hanya kirim sekali per user per hari
            $key = 'checkout_reminder_' . $user->id . '_' . $now->format('Y-m-d');
            if (!Cache::add($key, true, $now->copy()->endOfDay())) {
                $this->line("→ Skip {$user->name} (sudah dikirim hari ini)");
                continue;
            }

            $shiftEnd = Carbon::createFromFormat('H:i:s', $attendance->schedule->shift->end_time)->format('H:i');

            $msg  = "🏨 *Grandhika Intern and Daily Worker Attendance*\n\n";
            $msg .= "Halo *{$user->name}*,\n\n";
            $msg .= "⏰ Shift kamu (*{$attendance->schedule->shift->name}*) sudah selesai pukul *{$shiftEnd}*.\n\n";
            $msg .= "Kamu belum *Check Out*. Jangan lupa ya! 😊";

            // Gunakan phone jika ada, fallback ke wa_lid
            $phoneTarget = !empty($user->phone) ? $user->phone : $user->wa_lid;
            $targets[] = ['phone' => $phoneTarget, 'message' => $msg];
            $this->line("→ Reminder checkout ke {$user->name} ({$phoneTarget}) shift ended {$shiftEnd}");
        }

        if (!empty($targets)) {
            $wa->sendBulkPublic($targets);
            $this->info("✓ " . count($targets) . " reminder checkout dikirim.");
        }

        return self::SUCCESS;
    }
}
