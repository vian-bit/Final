╔════════════════════════════════════════════════════════════╗
║                                                            ║
║         SISTEM ABSENSI HOTEL                               ║
║         Untuk Magang & Daily Worker                        ║
║                                                            ║
╚════════════════════════════════════════════════════════════╝


SELAMAT DATANG! 👋

Terima kasih telah menggunakan Sistem Absensi Hotel.
Sistem ini dibuat untuk memudahkan pengelolaan absensi
karyawan magang dan daily worker di hotel.


📋 FITUR UTAMA:
===============
✅ 3 Role User (Superuser, Admin, User)
✅ 4 Departemen (FO, HK, F&B, Engineering)
✅ Manajemen User & Shift Kerja
✅ Penjadwalan Otomatis
✅ Check-in/Check-out dengan Deteksi Terlambat
✅ Laporan Absensi & Export
✅ Integrasi WhatsApp untuk Rekap Otomatis


🚀 CARA MEMULAI (SUPER CEPAT):
===============================

OPSI 1 - Setup Otomatis (Rekomendasi):
---------------------------------------
1. Pastikan Laragon sudah running
2. Double-click: SETUP-LENGKAP.bat
3. Tunggu sampai selesai (database akan dibuat otomatis)
4. Login dengan akun demo


OPSI 2 - Setup Manual:
-----------------------
1. Double-click: START-HERE.bat
2. Pilih menu sesuai urutan:
   [1] Install Aplikasi
   [2] Migrasi Database (database akan dibuat otomatis)
   [3] Jalankan Server


📖 DOKUMENTASI:
===============

CARA-MENJALANKAN.txt
  → Panduan lengkap cara menjalankan sistem

AKUN-DEMO.txt
  → Daftar akun demo untuk login

QUICK_START.md
  → Panduan cepat 5 menit

INSTALASI.md
  → Panduan instalasi detail

FITUR_DAN_PENGGUNAAN.md
  → Panduan lengkap semua fitur

WHATSAPP_INTEGRATION.md
  → Setup integrasi WhatsApp API


🔧 FILE .BAT YANG TERSEDIA:
============================

START-HERE.bat
  → Menu utama (gunakan ini untuk akses semua fitur)

SETUP-LENGKAP.bat
  → Setup otomatis dari awal sampai selesai

1-install.bat
  → Install dependencies

2-migrate.bat
  → Migrasi database

3-serve.bat
  → Jalankan server

4-reset-database.bat
  → Reset database (hapus semua data)

5-send-whatsapp-report.bat
  → Kirim laporan WhatsApp manual

6-run-scheduler.bat
  → Jalankan scheduler (kirim laporan otomatis)

7-clear-cache.bat
  → Bersihkan cache

8-optimize.bat
  → Optimize untuk production


🔐 AKUN DEMO:
=============

Superuser:
  Email: superadmin@hotel.com
  Password: password

Admin FO:
  Email: admin.fo@hotel.com
  Password: password

User:
  Email: john@hotel.com
  Password: password

Lihat AKUN-DEMO.txt untuk daftar lengkap


⚙️ KONFIGURASI DATABASE:
=========================

File: .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_absensi
DB_USERNAME=root
DB_PASSWORD=


📱 INTEGRASI WHATSAPP (OPSIONAL):
==================================

1. Daftar di Fonnte.com atau Wablas.com
2. Dapatkan API Key
3. Edit .env:
   WHATSAPP_API_KEY=your_key_here
   WHATSAPP_PHONE_NUMBER=628123456789
4. Test: 5-send-whatsapp-report.bat


❓ TROUBLESHOOTING:
===================

Error saat install:
  → Pastikan Composer terinstall
  → Gunakan Laragon yang sudah include Composer

Error saat migrate:
  → Pastikan database sudah dibuat
  → Pastikan MySQL di Laragon running
  → Cek konfigurasi .env

Server tidak jalan:
  → Cek port 8000 tidak digunakan aplikasi lain
  → Restart Laragon
  → Jalankan: 7-clear-cache.bat


📞 SUPPORT:
===========

Jika ada masalah:
1. Baca dokumentasi di folder project
2. Cek file log: storage/logs/laravel.log
3. Jalankan: 7-clear-cache.bat
4. Restart Laragon


💡 TIPS:
========

✓ Gunakan START-HERE.bat untuk akses mudah
✓ Backup database secara berkala
✓ Ganti password default setelah login pertama
✓ Baca FITUR_DAN_PENGGUNAAN.md untuk panduan lengkap
✓ Setup WhatsApp untuk notifikasi otomatis


═══════════════════════════════════════════════════════════

Selamat menggunakan Sistem Absensi Hotel! 🎉

Jika ada pertanyaan, silakan baca dokumentasi
atau hubungi developer sistem.

═══════════════════════════════════════════════════════════
