@echo off
chcp 65001 >nul
title Hotel Attendance - Start All
color 0A

cd /d "%~dp0"

echo ========================================
echo   HOTEL ATTENDANCE - START ALL
echo ========================================
echo.

:: Kill proses lama
taskkill /F /IM node.exe >nul 2>&1
timeout /t 1 /nobreak >nul

:: Jalankan WA Server di window terpisah
echo [1/2] Menjalankan WA Server...
start "WA Server (Baileys)" cmd /k "cd /d "%~dp0wa-server" && node index.js"
timeout /t 2 /nobreak >nul

:: Jalankan Laravel Server di window terpisah
echo [2/2] Menjalankan Laravel Server...
start "Laravel Server" cmd /k "cd /d "%~dp0" && php artisan serve --host=0.0.0.0 --port=8000"

echo.
echo ========================================
echo  Semua server berjalan!
echo.
echo  Website  : http://localhost:8000
echo  WA QR    : http://localhost:3000/qr
echo.
echo  Jangan tutup window WA Server dan
echo  window Laravel Server!
echo ========================================
echo.
pause
