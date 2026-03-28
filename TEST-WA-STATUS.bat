@echo off
chcp 65001 >nul
title Cek Status WA Server
color 0A

echo ========================================
echo   CEK STATUS WA SERVER
echo ========================================
echo.

curl -s http://localhost:3000/status

echo.
echo.
echo Keterangan:
echo   "connected":true  = WhatsApp terhubung, siap kirim
echo   "connected":false = Belum terhubung, perlu scan QR
echo   Error/gagal       = WA Server belum dijalankan
echo.
echo Untuk scan QR buka: http://localhost:3000/qr
echo.
pause
