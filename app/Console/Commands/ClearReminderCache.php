<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearReminderCache extends Command
{
    protected $signature   = 'reminder:clear-cache
                                {--date= : Tanggal yang ingin dihapus cache-nya (format: YYYY-MM-DD), default hari ini}
                                {--all : Hapus cache reminder untuk 7 hari ke belakang}
                                {--check : Hanya cek status cache tanpa menghapus}';
    protected $description = 'Hapus atau cek cache dedup reminder checkin & checkout';

    public function handle(): int
    {
        $all   = $this->option('all');
        $check = $this->option('check');
        $date  = $this->option('date') ?? now('Asia/Jakarta')->format('Y-m-d');

        $dates = $all
            ? collect(range(0, 6))->map(fn($i) => Carbon::parse($date)->subDays($i)->format('Y-m-d'))
            : collect([$date]);

        $users   = User::with('schedules')->pluck('id', 'id');
        $cleared = 0;
        $rows    = [];

        foreach ($dates as $d) {
            foreach ($users as $id) {
                $ciKey    = "checkin_reminder_{$id}_{$d}";
                $coKey    = "checkout_reminder_{$id}_{$d}";
                $hasCi    = Cache::has($ciKey);
                $hasCo    = Cache::has($coKey);

                if ($hasCi || $hasCo) {
                    $user   = User::find($id);
                    $rows[] = [
                        $d,
                        $user?->name ?? "User #{$id}",
                        $hasCi ? '✅ Ada' : '—',
                        $hasCo ? '✅ Ada' : '—',
                    ];

                    if (!$check) {
                        if ($hasCi) { Cache::forget($ciKey); $cleared++; }
                        if ($hasCo) { Cache::forget($coKey); $cleared++; }
                    }
                }
            }
        }

        if (empty($rows)) {
            $this->line('Tidak ada cache reminder yang ditemukan.');
            return self::SUCCESS;
        }

        $this->table(
            ['Tanggal', 'User', 'Cache Check-In', 'Cache Check-Out'],
            $rows
        );

        if ($check) {
            $this->info('Mode --check: cache tidak dihapus.');
        } else {
            $this->info("✓ {$cleared} cache reminder berhasil dihapus.");
        }

        return self::SUCCESS;
    }
}
