@echo off
color 0B
title Setup Lengkap - Sistem Absensi Hotel

cls
echo ========================================
echo   SETUP LENGKAP SISTEM ABSENSI HOTEL
echo ========================================
echo.
echo Script ini akan melakukan:
echo 1. Install composer dependencies
echo 2. Generate application key
echo 3. Clear cache
echo 4. Membuat database (otomatis)
echo 5. Migrasi database
echo 6. Seed data demo
echo 7. Jalankan server
echo.
echo PASTIKAN:
echo - Laragon sudah running
echo - MySQL di Laragon aktif
echo.
echo Database akan dibuat OTOMATIS oleh Laravel
echo Tidak perlu buat database manual!
echo.
echo Tekan Ctrl+C untuk BATAL, atau
pause
echo.

echo ========================================
echo STEP 1: Install Dependencies
echo ========================================
call composer install
if errorlevel 1 (
    echo ERROR: Composer install gagal!
    pause
    exit /b 1
)
echo.

echo ========================================
echo STEP 2: Generate Application Key
echo ========================================
php artisan key:generate
echo.

echo ========================================
echo STEP 3: Clear Cache
echo ========================================
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo.

echo ========================================
echo STEP 4: Migrasi Database
echo ========================================
echo yes | php artisan migrate
if errorlevel 1 (
    echo.
    echo ERROR: Migration gagal!
    echo.
    echo Kemungkinan penyebab:
    echo 1. MySQL di Laragon belum running
    echo 2. Konfigurasi .env salah
    echo 3. User MySQL tidak punya permission
    echo.
    echo Silakan:
    echo 1. Pastikan Laragon running
    echo 2. Cek konfigurasi .env
    echo 3. Jalankan script ini lagi
    echo.
    pause
    exit /b 1
)
echo.

echo ========================================
echo STEP 5: Seed Data Demo
echo ========================================
php artisan db:seed
echo.

echo ========================================
echo SETUP SELESAI!
echo ========================================
echo.
echo Data demo telah dibuat:
echo.
echo SUPERUSER:
echo   Email: superadmin@hotel.com
echo   Password: password
echo.
echo ADMIN FRONT OFFICE:
echo   Email: admin.fo@hotel.com
echo   Password: password
echo.
echo USER MAGANG:
echo   Email: john@hotel.com
echo   Password: password
echo.
echo Lihat AKUN-DEMO.txt untuk daftar lengkap
echo.
echo ========================================
echo.
set /p run="Jalankan server sekarang? (Y/N): "
if /i "%run%"=="Y" (
    echo.
    echo Membuka browser...
    timeout /t 2 /nobreak > nul
    start http://localhost:8000
    echo.
    echo Server berjalan di: http://localhost:8000
    echo Tekan Ctrl+C untuk menghentikan
    echo.
    php artisan serve
) else (
    echo.
    echo Untuk menjalankan server, gunakan: 3-serve.bat
    echo Atau jalankan: START-HERE.bat
    echo.
    pause
)
