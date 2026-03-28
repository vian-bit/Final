# Quick Start Guide - Sistem Absensi Hotel

## Instalasi Cepat (5 Menit)

### 1. Persiapan
```bash
# Pastikan Laragon sudah terinstall dan running
# Buka terminal di folder project
cd C:\laragon\www\hotel-absensi
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
copy .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit `.env`:
```env
DB_DATABASE=hotel_absensi
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat Database
Buka HeidiSQL/phpMyAdmin, buat database `hotel_absensi`

### 6. Migrasi dan Seed
```bash
php artisan migrate
php artisan db:seed
```

### 7. Jalankan Server
```bash
php artisan serve
```

Buka: http://localhost:8000

## Login Pertama

**Superuser:**
- Email: superadmin@hotel.com
- Password: password

## Langkah Awal Penggunaan

### Sebagai Superuser:

1. **Cek Departemen** (sudah otomatis dibuat)
   - Front Office
   - Housekeeping
   - F&B
   - Engineering

2. **Cek Admin** (sudah otomatis dibuat)
   - Admin FO: admin.fo@hotel.com
   - Admin HK: admin.hk@hotel.com

### Sebagai Admin (Login: admin.fo@hotel.com):

1. **Buat Shift Kerja**
   - Menu: Shift Kerja > Tambah Shift
   - Contoh: Shift Pagi (08:00-16:00)

2. **Buat User**
   - Menu: Manajemen User > Tambah User
   - Isi data magang/daily worker

3. **Buat Jadwal**
   - Menu: Jadwal Kerja > Tambah Jadwal
   - Assign user ke shift

### Sebagai User (Login: john@hotel.com):

1. **Lihat Jadwal**
   - Dashboard menampilkan jadwal hari ini

2. **Check-In**
   - Klik tombol "Check In"

3. **Check-Out**
   - Klik tombol "Check Out"

## Fitur Tambahan

### Export Laporan
```
Menu: Absensi > Export Laporan
Pilih tanggal > Print/Save PDF
```

### Kirim Laporan WhatsApp
```bash
php artisan attendance:send-daily-report
```

## Troubleshooting Cepat

**Error Migration:**
```bash
php artisan migrate:fresh --seed
```

**Error Composer:**
```bash
composer dump-autoload
```

**Clear Cache:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Dokumentasi Lengkap

- [INSTALASI.md](INSTALASI.md) - Panduan instalasi detail
- [FITUR_DAN_PENGGUNAAN.md](FITUR_DAN_PENGGUNAAN.md) - Panduan fitur lengkap
- [WHATSAPP_INTEGRATION.md](WHATSAPP_INTEGRATION.md) - Integrasi WhatsApp

## Support

Jika ada masalah, cek:
1. Laragon sudah running
2. Database sudah dibuat
3. File .env sudah dikonfigurasi
4. Migration sudah dijalankan

Selamat menggunakan! 🎉
