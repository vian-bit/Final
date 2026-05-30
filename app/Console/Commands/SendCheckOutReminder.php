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
            ->whereIn('date', [today(), today()->subDay()])
            ->whereNotNull('check_in')
            ->whereNull('check_out');

        if (!$force) {
            // Kirim ke user yang shift-nya sudah selesai dalam 10 menit terakhir
            // Handle shift selesai 00:00: end_time = '00:00:00' berarti tengah malam
            $query->whereHas('schedule.shift', function ($q) use ($now) {
                $q->where(function ($q) use ($now) {
                    // Shift normal: end_time antara (now-10 menit) sampai now
                    $q->where('end_time', '!=', '00:00:00')
                      ->whereBetween('end_time', [
                          $now->copy()->subMinutes(10)->format('H:i:s'),
                          $now->format('H:i:s'),
                      ]);
                })->orWhere(function ($q) use ($now) {
                    // Shift selesai tengah malam (00:00): kirim saat jam 00:00 - 00:10
                    $q->where('end_time', '00:00:00')
                      ->whereBetween(\DB::raw("TIME(NOW())"), ['00:00:00', '00:10:00']);
                });
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

            // Dedup: hanya kirim sekali per user per hari (bypass jika --force)
            if (!$force) {
                $key = 'checkout_reminder_' . $user->id . '_' . $attendance->date->format('Y-m-d');
                // Untuk shift selesai 00:00, tambah 1 jam agar cache tidak expired sebelum waktunya
                $ttl = $attendance->schedule->shift->end_time === '00:00:00'
                    ? $attendance->date->copy()->endOfDay()->addHours(1)
                    : $attendance->date->copy()->endOfDay();
                if (!Cache::add($key, true, $ttl)) {
                    $this->line("→ Skip {$user->name} (sudah dikirim hari ini)");
                    continue;
                }
            }

            $shiftEnd    = Carbon::createFromFormat('H:i:s', $attendance->schedule->shift->end_time)->format('H:i');
            $shiftEndDt  = Carbon::createFromFormat('H:i:s', $attendance->schedule->shift->end_time)->setDateFrom($now);
            $menitSetelah = (int) $shiftEndDt->diffInMinutes($now);

            $msg  = "🏨 *Grandhika Intern and Daily Worker Attendance*\n\n";
            $msg .= "Halo *{$user->name}*,\n\n";
            $msg .= "⏰ Shift kamu (*{$attendance->schedule->shift->name}*) sudah selesai pukul *{$shiftEnd}* — *{$menitSetelah} menit yang lalu.*\n\n";
            $msg .= "Kamu belum *Check Out*. Jangan lupa ya! 😊";

            // Gunakan phone jika ada, fallback ke wa_lid
            $phoneTarget = !empty($user->phone) ? $user->phone : $user->wa_lid;
            $targets[] = ['phone' => $phoneTarget, 'message' => $msg];
            $this->line("→ Reminder checkout ke {$user->name} ({$phoneTarget}) shift ended {$shiftEnd}");
        }

        if (!empty($targets)) {
            // Kirim dalam batch 50 agar tidak overload WA server & RAM
            foreach (array_chunk($targets, 50) as $batch) {
                $wa->sendBulkPublic($batch);
            }
            $this->info("✓ " . count($targets) . " reminder checkout dikirim.");
        }

        return self::SUCCESS;
    }
}
