@echo off
color 0E
title Hapus Database

cls
echo ========================================
echo   HAPUS DATABASE
echo ========================================
echo.
echo Script ini akan menghapus database 'hotel_absensi'
echo.
echo PERINGATAN: Semua data akan hilang!
echo.
echo Tekan Ctrl+C untuk BATAL, atau
pause

echo.
echo Menghapus database...
echo.

php artisan db:wipe

if errorlevel 1 (
    echo.
    echo Gagal menghapus database otomatis.
    echo.
    echo Silakan hapus manual:
    echo 1. Buka HeidiSQL/phpMyAdmin
    echo 2. Klik kanan database 'hotel_absensi'
    echo 3. Pilih 'Drop database'
    echo.
) else (
    echo.
    echo Database berhasil dihapus!
    echo.
    echo Jalankan SETUP-LENGKAP.bat untuk setup ulang
    echo.
)

pause
