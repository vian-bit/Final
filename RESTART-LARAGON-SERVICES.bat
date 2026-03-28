@echo off
chcp 65001 >nul
color 0C
title Restart Laragon Services

echo ========================================
echo RESTART LARAGON SERVICES
echo ========================================
echo.
echo INSTRUKSI:
echo.
echo 1. Buka aplikasi Laragon
echo 2. Klik tombol "Stop All"
echo 3. Tunggu sampai semua service berhenti
echo 4. Klik tombol "Start All"
echo 5. Tunggu sampai semua service hijau (15-20 detik)
echo 6. Tekan tombol apapun di sini untuk lanjut
echo.
echo ========================================
pause

echo.
echo Checking MySQL status...
echo.

netstat -ano | findstr ":3306"
if %errorlevel% equ 0 (
    echo.
    echo ✓ MySQL sudah running!
    echo Sekarang coba jalankan server lagi.
) else (
    echo.
    echo ✗ MySQL masih belum running!
    echo Pastikan Laragon sudah Start All dan tunggu lebih lama.
)

echo.
echo ========================================
pause
