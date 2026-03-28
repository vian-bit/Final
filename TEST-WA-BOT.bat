@echo off
chcp 65001 >nul
title Test WA Bot
color 0A

echo ========================================
echo   TEST WA BOT - SIMULASI PESAN MASUK
echo ========================================
echo.
echo Pastikan Laravel server sudah jalan!
echo.

set /p nomor="Nomor WA admin (yang terdaftar, contoh: 08123456789): "
set /p perintah="Perintah (help / rekap / absen / terlambat): "

:: Konversi 08xx ke 628xx@s.whatsapp.net
set jid=62%nomor:~2%@s.whatsapp.net

echo.
echo Simulasi pesan dari %jid%...
echo.

curl -s -X POST http://localhost:8000/wa-webhook ^
  -H "Content-Type: application/json" ^
  -H "x-wa-secret: rahasia123" ^
  -d "{\"from\":\"%jid%\",\"text\":\"%perintah%\"}"

echo.
echo.
echo Jika muncul "reply" berisi teks = berhasil!
echo.
pause
