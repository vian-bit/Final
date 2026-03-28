@echo off
color 0A
title Update dan Restart Server

cls
echo ========================================
echo   UPDATE DAN RESTART SERVER
echo ========================================
echo.
echo Script ini akan:
echo 1. Clear semua cache
echo 2. Restart server dengan perubahan terbaru
echo.
pause

echo.
echo [1/2] Clear cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo.
echo [2/2] Memulai server...
echo.
echo Server akan berjalan di: http://localhost:8000
echo Tekan Ctrl+C untuk menghentikan
echo.
timeout /t 2 /nobreak > nul
start http://localhost:8000
echo.
php artisan serve
