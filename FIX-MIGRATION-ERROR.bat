@echo off
color 0C
title Fix Migration Error

cls
echo ========================================
echo   FIX MIGRATION ERROR
echo ========================================
echo.
echo Error: Table already exists
echo.
echo Solusi: Reset database dan migrate ulang
echo.
echo PERINGATAN: Ini akan menghapus semua data!
echo.
echo Tekan Ctrl+C untuk BATAL, atau
pause

echo.
echo ========================================
echo Mereset Database...
echo ========================================
echo.

echo yes | php artisan migrate:fresh --seed

if errorlevel 1 (
    echo.
    echo ERROR: Masih gagal!
    echo.
    echo Coba solusi alternatif:
    echo 1. Buka HeidiSQL
    echo 2. Hapus database 'hotel_absensi'
    echo 3. Jalankan SETUP-LENGKAP.bat lagi
    echo.
    pause
    exit /b 1
)

echo.
echo ========================================
echo BERHASIL!
echo ========================================
echo.
echo Database telah direset dan data demo dibuat.
echo.
echo Akun demo:
echo - superadmin@hotel.com / password
echo - admin.fo@hotel.com / password
echo - john@hotel.com / password
echo.
pause
