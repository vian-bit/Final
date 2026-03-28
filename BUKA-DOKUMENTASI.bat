@echo off
title Dokumentasi Sistem Absensi Hotel

cls
echo ========================================
echo   DOKUMENTASI SISTEM ABSENSI HOTEL
echo ========================================
echo.
echo Membuka semua file dokumentasi...
echo.

if exist "README-FIRST.txt" start notepad "README-FIRST.txt"
if exist "CARA-MENJALANKAN.txt" start notepad "CARA-MENJALANKAN.txt"
if exist "AKUN-DEMO.txt" start notepad "AKUN-DEMO.txt"
if exist "QUICK_START.md" start notepad "QUICK_START.md"

echo.
echo Dokumentasi telah dibuka!
echo.
echo File dokumentasi yang tersedia:
echo - README-FIRST.txt (Baca ini dulu!)
echo - CARA-MENJALANKAN.txt
echo - AKUN-DEMO.txt
echo - QUICK_START.md
echo - INSTALASI.md
echo - FITUR_DAN_PENGGUNAAN.md
echo - WHATSAPP_INTEGRATION.md
echo.
pause
