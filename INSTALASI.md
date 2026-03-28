# Panduan Instalasi Sistem Absensi Hotel

## Persiapan

### 1. Install Laragon
- Download Laragon dari https://laragon.org/download/
- Install Laragon (sudah include PHP, MySQL, Apache)
- Jalankan Laragon

### 2. Setup Project

#### A. Jika Clone dari Repository
```bash
cd C:\laragon\www
git clone [repository-url] hotel-absensi
cd hotel-absensi
composer install
```

#### B. Jika Project Sudah Ada
Pastikan project berada di folder `C:\laragon\www\hotel-absensi`

### 3. Konfigurasi Environment

Copy file `.env.example` menjadi `.env`:
```bash
copy .env.example .env
```

Edit file `.env`:
```env
APP_NAME="Sistem Absensi Hotel"
APP_URL=http://hotel-absensi.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_absensi
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Buat Database

Buka Laragon, klik kanan > MySQL > Open

Di HeidiSQL atau phpMyAdmin:
```sql
CREATE DATABASE hotel_absensi;
```

### 6. Jalankan Migration dan Seeder
```bash
php artisan migrate
php artisan db:seed
```

### 7. Setup Virtual Host (Opsional)

Di Laragon:
- Klik kanan icon Laragon
- Pilih "Apache" > "sites-enabled" > "Add"
- Nama: hotel-absensi
- Laragon akan otomatis membuat virtual host

Akses: http://hotel-absensi.test

Atau jalankan development server:
```bash
php artisan serve
```
Akses: http://localhost:8000

## Login Pertama Kali

Gunakan akun superuser:
- Email: superadmin@hotel.com
- Password: password

## Konfigurasi WhatsApp (Opsional)

Tambahkan ke file `.env`:
```env
WHATSAPP_API_URL=https://api.whatsapp.com
WHATSAPP_API_KEY=your_api_key_here
WHATSAPP_PHONE_NUMBER=628123456789
```

## Testing Kirim Laporan WhatsApp

```bash
php artisan attendance:send-daily-report
```

## Troubleshooting

### Error: SQLSTATE[HY000] [2002]
- Pastikan MySQL di Laragon sudah running
- Cek konfigurasi DB di file `.env`

### Error: Class not found
```bash
composer dump-autoload
```

### Error: Permission denied
Jalankan sebagai Administrator

### Port 80 sudah digunakan
- Stop service yang menggunakan port 80 (Skype, IIS)
- Atau ubah port Apache di Laragon

## Selesai!

Sistem siap digunakan. Silakan login dan mulai konfigurasi departemen, user, dan shift kerja.
