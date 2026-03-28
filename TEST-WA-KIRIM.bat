@echo off
chcp 65001 >nul
title Test Kirim WhatsApp
color 0A

echo ========================================
echo   TEST KIRIM WHATSAPP
echo ========================================
echo.
echo Pastikan START-WA-SERVER.bat sudah berjalan!
echo.

set /p nomor="Masukkan nomor tujuan (contoh: 08123456789): "
set /p pesan="Masukkan pesan: "

echo.
echo Mengirim pesan ke %nomor%...
echo.

curl -s -X POST http://localhost:3000/send ^
  -H "Content-Type: application/json" ^
  -H "x-api-key: rahasia123" ^
  -d "{\"phone\":\"%nomor%\",\"message\":\"%pesan%\"}"

echo.
echo.
echo Jika muncul {"status":true} berarti berhasil!
echo.
pause
