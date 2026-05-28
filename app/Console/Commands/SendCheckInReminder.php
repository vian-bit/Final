<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SendCheckInReminder extends Command
{
    protected $signature   = 'attendance:send-checkin-reminder {--force : Kirim ke semua user yang belum check-in hari ini tanpa cek waktu shift}';
    protected $description = 'Kirim notifikasi WA ke user 10 menit sebelum shift mulai';

    public function handle(WhatsAppService $wa): int
    {
        $now    = Carbon::now('Asia/Jakarta');
        $target = $now->copy()->addMinutes(10);
        $force  = $this->option('force');

        $query = Schedule::with(['user', 'shift'])
            ->whereDate('date', today())
            ->whereDoesntHave('attendance', function ($q) {
                $q->whereNotNull('check_in');
            });

        if (!$force) {
            // Hanya shift yang mulai dalam ~10 menit (toleransi ±1 menit)
            // Handle midnight shift (00:00): cek juga schedule besok
            $query->where(function ($q) use ($target) {
                $q->whereHas('shift', function ($q) use ($target) {
                    $q->whereBetween('start_time', [
                        $target->copy()->subMinute()->format('H:i:s'),
                        $target->copy()->addMinute()->format('H:i:s'),
                    ]);
                });
            });

            // Jika target melewati tengah malam (23:50 - 00:10),
            // cek juga schedule besok untuk shift yang mulai 00:00
            if ($target->format('H:i') < '00:10') {
                $query->orWhere(function ($q) use ($target) {
                    $q->whereDate('date', today()->addDay())
                      ->whereHas('shift', function ($q) use ($target) {
                          $q->whereBetween('start_time', [
                              $target->copy()->subMinute()->format('H:i:s'),
                              $target->copy()->addMinute()->format('H:i:s'),
                          ]);
                      })
                      ->whereDoesntHave('attendance', function ($q) {
                          $q->whereNotNull('check_in');
                      });
                });
            }
        }

        $schedules = $query->get();

        if ($schedules->isEmpty()) {
            $this->line('Tidak ada reminder yang perlu dikirim.');
            return self::SUCCESS;
        }

        $targets = [];
        foreach ($schedules as $schedule) {
            $user = $schedule->user;
            if (empty($user->phone) || !$user->is_active) continue;

            // Lewati cache check jika --force digunakan
            if (!$force) {
                $key = 'checkin_reminder_' . $user->id . '_' . $schedule->date->format('Y-m-d');
                if (!Cache::add($key, true, $schedule->date->copy()->endOfDay())) {
                    continue;
                }
            }

            $shiftStart = Carbon::createFromFormat('H:i:s', $schedule->shift->start_time)->format('H:i');

            $msg  = "🏨 *Grandhika Intern and Daily Worker Attendance*\n\n";
            $msg .= "Halo *{$user->name}*,\n\n";
            $msg .= "⏰ Shift kamu (*{$schedule->shift->name}*) dimulai pukul *{$shiftStart}* — 10 menit lagi!\n\n";
            $msg .= "Jangan lupa *Check In* ya. 😊";

            $targets[] = ['phone' => $user->phone, 'message' => $msg];
            $this->line("→ Reminder ke {$user->name} ({$user->phone}) shift {$shiftStart}");
        }

        if (!empty($targets)) {
            // Kirim dalam batch 50 agar tidak overload WA server & RAM
            foreach (array_chunk($targets, 50) as $batch) {
                $wa->sendBulkPublic($batch);
            }
            $this->info("✓ " . count($targets) . " reminder dikirim.");
        }

        return self::SUCCESS;
    }
}
