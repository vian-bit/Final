@echo off
chcp 65001 >nul
color 0A
title Fix Session Error

echo ========================================
echo FIX SESSION ERROR
echo ========================================
echo.
echo Error terjadi karena tabel sessions bermasalah.
echo Script ini akan memperbaikinya.
echo.
pause

echo.
echo [1/4] Clear cache...
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo.
echo [2/4] Recreate sessions table...
php artisan session:table

echo.
echo [3/4] Run migration...
php artisan migrate --force

echo.
echo [4/4] Clear cache lagi...
php artisan cache:clear

echo.
echo ========================================
echo SELESAI!
echo ========================================
echo.
echo Sekarang coba jalankan server lagi:
echo - Tutup server yang error (Ctrl+C)
echo - Jalankan START-HERE.bat
echo - Pilih option [3] atau [L] untuk start server
echo.
pause
