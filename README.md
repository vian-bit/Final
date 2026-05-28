# Grandhika Intern and Daily Worker Attendance

Sistem absensi untuk intern dan daily worker di Hotel Grandhika dengan multiple departemen, notifikasi WhatsApp otomatis, dan chatbot WA.

## Fitur Utama

- **3 Role User**: Superuser, Admin Departemen, User
- **User Type Dinamis**: Tipe user dapat dikonfigurasi (Magang, Daily Worker, Staff, dll)
- **Departemen**: Dinamis, dapat ditambah sesuai kebutuhan
- **Manajemen User**: CRUD user dengan role-based access
- **Manajemen Shift**: Buat dan kelola jam shift kerja per departemen
- **Penjadwalan**: Assign shift ke user via kalender bulanan
- **Absensi**: Check-in/Check-out dengan deteksi keterlambatan otomatis
- **Early Checkout Request**: User ajukan permintaan pulang lebih awal, admin approve/reject
- **Export Laporan**: Export absensi ke Excel dengan filter tanggal dan departemen
- **Chatbot WhatsApp**: Reminder otomatis + perintah interaktif untuk admin dan user

---

## Instalasi (Lokal)

### 1. Clone Project
```bash
git clone <repo-url>
cd <folder-project>
```

### 2. Install Dependencies
```bash
composer install
npm install && npm run build
```

### 3. Buat File .env
```bash
cp .env.example .env
```

Edit file `.env`:
```env
APP_NAME="Grandhika Attendance"
APP_URL=http://localhost/Final/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_trainee
DB_USERNAME=root
DB_PASSWORD=

WHATSAPP_SERVER_URL=http://202.155.18.115:3000
WHATSAPP_API_KEY=rahasia123
WHATSAPP_PHONE_NUMBER=
```

### 4. Generate App Key & Migrate
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

---

## Instalasi (VPS)

### 1. Clone & Install
```bash
cd /var/www
git clone <repo-url> Absensi_Trainee
cd Absensi_Trainee
composer install --no-dev
```

### 2. Setup .env
```bash
cp .env.example .env
# Edit .env sesuai konfigurasi VPS
php artisan key:generate
```

### 3. Migrate & Optimize
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan optimize
```

### 4. Setup Cron Job
```bash
crontab -e
```
Tambahkan:
```
* * * * * cd /var/www/Absensi_Trainee && php artisan schedule:run >> /dev/null 2>&1
```

### 5. Update dari Repo
```bash
git pull
php artisan migrate
php artisan optimize
```

---

## Akun Default

Setelah seeder, gunakan akun berikut:

| Role | Email | Password |
|------|-------|----------|
| Superuser | superadmin@grandhika.com | password |

Admin dan user dibuat melalui panel Superuser.

---

## Struktur Database

| Tabel | Keterangan |
|-------|------------|
| `users` | Data user dengan role, departemen, dan tipe |
| `user_types` | Tipe user yang dapat dikonfigurasi secara dinamis |
| `departments` | Data departemen hotel |
| `shifts` | Jam shift kerja per departemen |
| `schedules` | Jadwal kerja user per tanggal |
| `attendances` | Data absensi check-in/check-out |
| `early_checkout_requests` | Permintaan pulang lebih awal |

---

## Panduan Penggunaan

### Superuser
1. Kelola departemen di menu **Departemen**
2. Kelola tipe user di menu **User Types**
3. Buat akun admin untuk setiap departemen
4. Monitor semua aktivitas absensi dan export laporan

### Admin Departemen
1. Buat akun user di menu **Manajemen User**
2. Buat shift kerja di menu **Shift Kerja**
3. Assign jadwal ke user di menu **Manage Schedule**
4. Monitor absensi dan export laporan departemen
5. Approve/reject early checkout request

### User
1. Lihat jadwal shift hari ini di dashboard
2. Klik **Check In** saat mulai kerja
3. Klik **Check Out** saat selesai kerja
4. Ajukan early checkout request jika perlu pulang lebih awal
5. Lihat riwayat absensi di menu **Attendance**

---

## Chatbot WhatsApp

### Perintah untuk User
| Perintah | Fungsi |
|----------|--------|
| `jadwal` / `shift` | Cek jadwal shift hari ini + status absensi |
| `link email@grandhika.com` | Hubungkan nomor WA ke akun |

### Perintah untuk Admin / Superuser
| Perintah | Fungsi |
|----------|--------|
| `rekap` | Rekap absensi hari ini |
| `rekap YYYY-MM-DD` | Rekap tanggal tertentu |
| `export` | Download Excel absensi hari ini |
| `export YYYY-MM-DD` | Download Excel tanggal tertentu |
| `export YYYY-MM-DD YYYY-MM-DD` | Download Excel rentang tanggal |
| `absen` | Daftar yang belum absen hari ini |
| `terlambat` | Daftar yang terlambat hari ini |
| `help` | Tampilkan daftar perintah |

> Nomor yang tidak terdaftar di sistem tidak akan mendapat balasan dari bot.

---

## Notifikasi Otomatis

| Command | Jadwal | Keterangan |
|---------|--------|------------|
| `attendance:send-checkin-reminder` | Setiap 2 menit | Reminder sebelum shift mulai (menit dinamis) |
| `attendance:send-checkout-reminder` | Setiap 2 menit | Reminder setelah shift selesai (menit dinamis) |
| `attendance:send-daily-report` | Setiap hari 17:00 WIB | Rekap harian ke semua admin |

### Jalankan Manual (Testing)
```bash
# Clear cache reminder dulu
php artisan cache:clear

# Cek status cache reminder hari ini
php artisan reminder:clear-cache --check

# Hapus cache reminder hari ini
php artisan reminder:clear-cache

# Hapus cache reminder 7 hari ke belakang
php artisan reminder:clear-cache --all

# Test checkin reminder (bypass filter waktu & cache)
php artisan attendance:send-checkin-reminder --force

# Test checkout reminder (bypass filter waktu & cache)
php artisan attendance:send-checkout-reminder --force

# Test rekap harian
php artisan attendance:send-daily-report
```

> **Catatan:** Flag `--force` bypass pengecekan waktu dan cache. Jangan gunakan di cron job.

---

## Debug & Troubleshooting

### Cek status schedule
```bash
php artisan schedule:list
php artisan schedule:run --verbose
```

### Cek log Laravel
```bash
tail -f storage/logs/laravel.log
```

### Cek WA server
```bash
curl http://localhost:3000/status
```

### Test webhook WA manual
```bash
curl -X POST http://localhost/webhook/whatsapp \
  -H "x-wa-secret: rahasia123" \
  -H "Content-Type: application/json" \
  -d '{"from":"628123456789@s.whatsapp.net","text":"rekap"}'
```

### Clear semua cache
```bash
php artisan optimize:clear
```

---

## Teknologi

- **Backend**: Laravel 12, PHP 8.2+
- **Database**: MySQL
- **Frontend**: Tailwind CSS
- **WA Gateway**: Baileys (wa-server lokal)
- **Export**: PhpSpreadsheet

---

## Lisensi

Dikembangkan untuk keperluan internal Hotel Grandhika.
