# Integrasi WhatsApp API

## Deskripsi

Sistem ini terintegrasi dengan WhatsApp API untuk mengirimkan rekap absensi harian secara otomatis kepada HR atau pihak terkait.

## Fitur WhatsApp

1. **Rekap Absensi Harian**
   - Jumlah hadir
   - Jumlah terlambat
   - Jumlah tidak hadir
   - Daftar user yang belum absen

2. **Pengiriman Otomatis**
   - Dapat dijadwalkan via cron job
   - Dapat difilter per departemen
   - Format pesan terstruktur dan mudah dibaca

## Konfigurasi

### 1. Setup Environment

Tambahkan ke file `.env`:

```env
WHATSAPP_API_URL=https://api.whatsapp.com
WHATSAPP_API_KEY=your_api_key_here
WHATSAPP_PHONE_NUMBER=628123456789
```

### 2. Provider WhatsApp API

Sistem ini kompatibel dengan berbagai provider WhatsApp API:

#### A. Fonnte (Rekomendasi)
- Website: https://fonnte.com
- Mudah digunakan
- Harga terjangkau
- Support Indonesia

Konfigurasi:
```env
WHATSAPP_API_URL=https://api.fonnte.com
WHATSAPP_API_KEY=your_fonnte_token
WHATSAPP_PHONE_NUMBER=628123456789
```

#### B. Wablas
- Website: https://wablas.com
- Fitur lengkap
- Support Indonesia

Konfigurasi:
```env
WHATSAPP_API_URL=https://console.wablas.com
WHATSAPP_API_KEY=your_wablas_token
WHATSAPP_PHONE_NUMBER=628123456789
```

#### C. WhatsApp Business API (Official)
- Untuk enterprise
- Memerlukan verifikasi Facebook Business

### 3. Testing

Test pengiriman pesan:

```bash
php artisan attendance:send-daily-report
```

Test untuk departemen tertentu:

```bash
php artisan attendance:send-daily-report --department=1
```

## Format Pesan

Contoh pesan yang dikirim:

```
*REKAP ABSENSI HARIAN*
Tanggal: 09/03/2024

📊 *Ringkasan:*
✅ Hadir: 15
⏰ Terlambat: 3
❌ Tidak Hadir: 2
📋 Total Jadwal: 20

⚠️ *Belum Absen:*
- John Doe (Shift Pagi)
- Jane Smith (Shift Siang)
```

## Automasi dengan Cron Job

### Windows (Task Scheduler)

1. Buka Task Scheduler
2. Create Basic Task
3. Trigger: Daily, jam 17:00
4. Action: Start a program
5. Program: `C:\laragon\bin\php\php-8.x\php.exe`
6. Arguments: `artisan attendance:send-daily-report`
7. Start in: `C:\laragon\www\hotel-absensi`

### Linux/Mac (Crontab)

Edit crontab:
```bash
crontab -e
```

Tambahkan:
```bash
# Kirim rekap absensi setiap hari jam 17:00
0 17 * * * cd /path/to/hotel-absensi && php artisan attendance:send-daily-report
```

## Customisasi

### Ubah Format Pesan

Edit file `app/Services/WhatsAppService.php` method `sendDailyReport()`:

```php
$message = "*REKAP ABSENSI HARIAN*\n";
$message .= "Tanggal: " . $date->format('d/m/Y') . "\n\n";
// Tambahkan customisasi di sini
```

### Kirim ke Multiple Nomor

Modifikasi method `sendDailyReport()` untuk loop multiple nomor:

```php
$phoneNumbers = ['628123456789', '628987654321'];
foreach ($phoneNumbers as $phone) {
    $this->sendMessage($phone, $message);
}
```

### Tambah Fitur Notifikasi

Buat command baru untuk notifikasi lain:
- Reminder check-in pagi
- Notifikasi keterlambatan
- Laporan mingguan/bulanan

## Troubleshooting

### Pesan tidak terkirim
- Cek koneksi internet
- Verifikasi API key valid
- Cek format nomor telepon (62xxx)
- Lihat log: `storage/logs/laravel.log`

### Error 401 Unauthorized
- API key salah atau expired
- Regenerate API key dari provider

### Error 400 Bad Request
- Format nomor telepon salah
- Pesan terlalu panjang
- Parameter tidak sesuai

## Biaya

Estimasi biaya per bulan (tergantung provider):
- Fonnte: Rp 50.000 - 200.000 (paket unlimited)
- Wablas: Rp 100.000 - 500.000
- Official API: Mulai dari $40/bulan

## Support

Untuk bantuan integrasi WhatsApp, hubungi:
- Provider API yang Anda gunakan
- Developer sistem
