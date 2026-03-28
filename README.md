# Sistem Absensi Hotel

Sistem absensi untuk anak magang dan daily worker di hotel dengan multiple departemen.

## Fitur Utama

- **3 Role User**: Superuser, Admin Departemen, User (Magang/Daily Worker)
- **4 Departemen**: Front Office, Housekeeping, F&B, Engineering
- **Manajemen User**: CRUD user dengan role-based access
- **Manajemen Shift**: Buat dan kelola jam shift kerja
- **Penjadwalan**: Assign shift ke user berdasarkan tanggal
- **Absensi**: Check-in/Check-out dengan deteksi keterlambatan
- **Laporan**: Export laporan absensi
- **Integrasi WhatsApp**: Kirim rekap absensi otomatis

## Instalasi

### 1. Clone atau Setup Project
```bash
cd path/to/project
composer install
```

### 2. Konfigurasi Database (Laragon)
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_absensi
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Buat Database
Buka Laragon, klik "Database" > "Open" untuk membuka HeidiSQL atau phpMyAdmin.
Buat database baru dengan nama `hotel_absensi`.

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Jalankan Migration dan Seeder
```bash
php artisan migrate
php artisan db:seed
```

### 6. Konfigurasi WhatsApp API (Opsional)
Tambahkan ke `.env`:
```env
WHATSAPP_API_URL=https://api.whatsapp.com
WHATSAPP_API_KEY=your_api_key_here
WHATSAPP_PHONE_NUMBER=628123456789
```

### 7. Jalankan Server
```bash
php artisan serve
```

Akses: http://localhost:8000


## Akun Demo

Setelah menjalankan seeder, gunakan akun berikut:

| Role | Email | Password |
|------|-------|----------|
| Superuser | superadmin@hotel.com | password |
| Admin FO | admin.fo@hotel.com | password |
| Admin HK | admin.hk@hotel.com | password |
| User Magang | john@hotel.com | password |
| User Daily Worker | jane@hotel.com | password |

## Struktur Database

### Tables
- `users` - Data user dengan role dan departemen
- `departments` - Data departemen hotel
- `shifts` - Jam shift kerja per departemen
- `schedules` - Jadwal kerja user
- `attendances` - Data absensi check-in/check-out

## Penggunaan

### Superuser
1. Login sebagai superuser
2. Kelola departemen di menu "Departemen"
3. Buat akun admin untuk setiap departemen
4. Monitor semua aktivitas absensi

### Admin Departemen
1. Login sebagai admin
2. Buat akun user (magang/daily worker) di menu "Manajemen User"
3. Buat shift kerja di menu "Shift Kerja"
4. Assign jadwal ke user di menu "Jadwal Kerja"
5. Monitor absensi departemen
6. Export laporan absensi

### User (Magang/Daily Worker)
1. Login ke sistem
2. Lihat jadwal shift hari ini di dashboard
3. Klik "Check In" saat mulai kerja
4. Klik "Check Out" saat selesai kerja
5. Lihat riwayat absensi

## Kirim Laporan WhatsApp Otomatis

Jalankan command untuk mengirim rekap harian:
```bash
php artisan attendance:send-daily-report
```

Untuk departemen tertentu:
```bash
php artisan attendance:send-daily-report --department=1
```

### Setup Cron Job (Otomatis)
Tambahkan ke crontab untuk kirim otomatis setiap hari jam 17:00:
```bash
0 17 * * * cd /path/to/project && php artisan attendance:send-daily-report
```

## Teknologi

- Laravel 11
- MySQL (via Laragon)
- Tailwind CSS
- WhatsApp API Integration

## Lisensi

Open source untuk keperluan pembelajaran.
