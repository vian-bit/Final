<?php

namespace App\Console\Commands;

use App\Services\WhatsAppService;
use Illuminate\Console\Command;

class SendDailyAttendanceReport extends Command
{
    protected $signature   = 'attendance:send-daily-report {--phone= : Kirim ke nomor tertentu} {--department= : Filter per department ID}';
    protected $description = 'Kirim rekap absensi harian via WhatsApp ke semua admin';

    public function handle(WhatsAppService $wa): int
    {
        $this->info('Mengirim rekap absensi harian...');

        $phone  = $this->option('phone');
        $deptId = $this->option('department') ? (int) $this->option('department') : null;

        if ($phone) {
            // Kirim ke nomor spesifik (manual) dengan department tertentu
            $deptName = $deptId
                ? (\App\Models\Department::find($deptId)?->name ?? 'Unknown')
                : 'Semua Departemen';

            $message = $wa->buildPublicReportMessage($deptId, $deptName);
            $result  = $wa->sendMessagePublic($phone, $message);
            $this->line($result ? '✓ Berhasil dikirim!' : '✗ Gagal mengirim.');
            return $result ? self::SUCCESS : self::FAILURE;
        }

        // Kirim ke semua admin per departemen (otomatis)
        $wa->sendDailyReportToAllAdmins();
        $this->info('✓ Rekap dikirim ke semua admin yang memiliki nomor WA.');

        return self::SUCCESS;
    }
}
