# Grandhika Intern and Daily Worker Attendance

Sistem absensi untuk intern dan daily worker Hotel Grandhika.

---

## Akun & Role

| Role | Akses |
|------|-------|
| **Superuser** | Akses penuh ke semua fitur dan semua departemen |
| **Admin** | Kelola user, shift, jadwal, dan absensi departemennya |
| **User** | Check in/out, lihat jadwal dan riwayat absensi sendiri |

---

## Panduan Penggunaan

### Superuser

1. **Departemen** — Tambah, edit, hapus departemen
2. **User Types** — Tambah tipe user baru (Magang, Daily Worker, Staff, dll)
3. **User Management** — Buat akun admin dan user, atur departemen dan tipe
4. **Shift** — Buat shift kerja (nama, jam mulai, jam selesai, toleransi keterlambatan)
5. **Manage Schedule** — Assign shift ke user per hari via kalender bulanan
6. **Attendance** — Monitor absensi semua departemen, export laporan Excel
7. **Early Checkout Requests** — Approve/reject permintaan pulang lebih awal

### Admin Departemen

1. **User Management** — Buat dan kelola akun user di departemennya
2. **Shift** — Buat shift untuk departemennya
3. **Manage Schedule** — Assign shift ke user di departemennya
4. **Attendance** — Monitor absensi departemen, export laporan
5. **Early Checkout Requests** — Approve/reject permintaan user departemennya

### User

1. **Dashboard** — Lihat jadwal shift hari ini dan status absensi
2. **Check In** — Klik tombol Check In saat mulai kerja
3. **Check Out** — Klik tombol Check Out saat selesai kerja
4. **Early Checkout** — Ajukan permintaan pulang lebih awal jika perlu (butuh persetujuan admin)
5. **Attendance** — Lihat riwayat absensi sendiri

---

## Chatbot WhatsApp

### Cara Menghubungkan Nomor WA

Kirim pesan ke nomor bot:
```
link email@grandhika.com
```
Gunakan email yang terdaftar di sistem.

### Perintah untuk User

| Perintah | Fungsi |
|----------|--------|
| `jadwal` | Cek jadwal shift hari ini + status check in/out |
| `shift` | Sama seperti jadwal |

### Perintah untuk Admin & Superuser

| Perintah | Fungsi |
|----------|--------|
| `rekap` | Rekap absensi hari ini |
| `rekap 2026-05-28` | Rekap tanggal tertentu |
| `export` | Download Excel absensi hari ini |
| `export 2026-05-28` | Download Excel tanggal tertentu |
| `export 2026-05-01 2026-05-31` | Download Excel rentang tanggal |
| `absen` | Daftar yang belum absen hari ini |
| `terlambat` | Daftar yang terlambat hari ini |
| `help` | Tampilkan daftar perintah |

> Nomor yang tidak terdaftar di sistem tidak akan mendapat balasan dari bot.

---

## Notifikasi Otomatis

Sistem mengirim notifikasi WA secara otomatis:

| Notifikasi | Waktu | Penerima |
|------------|-------|----------|
| Reminder Check In | ~10 menit sebelum shift mulai | User |
| Reminder Check Out | Setelah shift selesai | User |
| Rekap Harian | Setiap hari jam 17:00 WIB | Admin & Superuser |

---

## Perintah Artisan (Admin Server)

```bash
# Test kirim reminder checkin (bypass waktu & cache)
php artisan attendance:send-checkin-reminder --force

# Test kirim reminder checkout (bypass waktu & cache)
php artisan attendance:send-checkout-reminder --force

# Test kirim rekap harian
php artisan attendance:send-daily-report

# Cek status cache reminder hari ini
php artisan reminder:clear-cache --check

# Hapus cache reminder hari ini
php artisan reminder:clear-cache

# Hapus cache reminder 7 hari ke belakang
php artisan reminder:clear-cache --all

# Cek jadwal yang terdaftar di scheduler
php artisan schedule:list
```
