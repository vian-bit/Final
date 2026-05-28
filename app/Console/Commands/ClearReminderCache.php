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
                                {--all : Hapus cache reminder untuk 7 hari ke belakang}';
    protected $description = 'Hapus cache dedup reminder checkin & checkout';

    public function handle(): int
    {
        $all  = $this->option('all');
        $date = $this->option('date') ?? now('Asia/Jakarta')->format('Y-m-d');

        $dates = $all
            ? collect(range(0, 6))->map(fn($i) => Carbon::parse($date)->subDays($i)->format('Y-m-d'))
            : collect([$date]);

        $users   = User::pluck('id');
        $cleared = 0;

        foreach ($dates as $d) {
            foreach ($users as $id) {
                $ciKey = "checkin_reminder_{$id}_{$d}";
                $coKey = "checkout_reminder_{$id}_{$d}";

                if (Cache::has($ciKey)) { Cache::forget($ciKey); $cleared++; }
                if (Cache::has($coKey)) { Cache::forget($coKey); $cleared++; }
            }
        }

        if ($cleared === 0) {
            $this->line('Tidak ada cache reminder yang ditemukan.');
        } else {
            $this->info("✓ {$cleared} cache reminder berhasil dihapus.");
        }

        $this->table(
            ['Tanggal', 'Jumlah User'],
            $dates->map(fn($d) => [$d, $users->count()])
        );

        return self::SUCCESS;
    }
}
