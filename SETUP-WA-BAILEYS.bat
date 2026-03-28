@echo off
chcp 65001 >nul
title Setup WhatsApp Baileys
color 0B

cd /d "%~dp0"

echo ========================================
echo   SETUP WHATSAPP BAILEYS
echo ========================================
echo.

where node >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Node.js tidak ditemukan!
    echo Download dari: https://nodejs.org  (pilih LTS)
    pause
    exit /b 1
)

echo [OK] Node.js:
node --version
echo.

echo [1/2] Install dependencies Baileys...
cd /d "%~dp0wa-server"
call npm install
cd /d "%~dp0"
echo.

echo [2/2] Clear Laravel cache...
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo.

echo ========================================
echo   SETUP SELESAI!
echo ========================================
echo.
echo Selanjutnya:
echo 1. Jalankan START-WA-SERVER.bat
echo 2. Buka: http://localhost:3000/qr
echo 3. Scan QR dengan WhatsApp
echo.
pause
