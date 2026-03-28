@echo off
chcp 65001 >nul
color 0E
title Troubleshoot LAN Access

echo ========================================
echo TROUBLESHOOT LAN ACCESS
echo ========================================
echo.

echo [1/5] Checking IP Address...
echo.
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /c:"IPv4"') do (
    set IP=%%a
    set IP=!IP:~1!
    echo Your IP: !IP!
)
echo.

echo [2/5] Checking if server is running on 0.0.0.0...
echo.
netstat -ano | findstr ":8000"
echo.
echo Pastikan ada baris yang menunjukkan: 0.0.0.0:8000
echo Jika hanya ada 127.0.0.1:8000, server tidak bisa diakses dari device lain!
echo.
pause

echo.
echo [3/5] Checking Windows Firewall...
echo.
netsh advfirewall firewall show rule name="Laravel Port 8000" >nul 2>&1
if %errorlevel% equ 0 (
    echo ✓ Firewall rule sudah ada
) else (
    echo ✗ Firewall rule BELUM ada!
    echo   Jalankan ALLOW-FIREWALL.bat sebagai Administrator
)
echo.
pause

echo.
echo [4/5] Testing port 8000...
echo.
netstat -ano | findstr ":8000" | findstr "LISTENING"
if %errorlevel% equ 0 (
    echo ✓ Port 8000 sedang listening
) else (
    echo ✗ Port 8000 TIDAK listening!
    echo   Pastikan server sudah running
)
echo.
pause

echo.
echo [5/5] Ping test...
echo.
echo Dari device lain, coba ping ke IP ini:
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /c:"IPv4"') do (
    set IP=%%a
    set IP=!IP:~1!
    echo ping !IP!
)
echo.
echo Jika ping berhasil tapi website tidak bisa diakses,
echo masalahnya ada di firewall atau server tidak running dengan --host=0.0.0.0
echo.

echo ========================================
echo SUMMARY - CHECKLIST
echo ========================================
echo.
echo [ ] Server running dengan: php artisan serve --host=0.0.0.0 --port=8000
echo [ ] Firewall rule sudah dibuat (ALLOW-FIREWALL.bat)
echo [ ] Device lain bisa ping ke IP server
echo [ ] Device lain dan server dalam 1 jaringan WiFi/LAN yang sama
echo.
echo ========================================
echo SOLUSI CEPAT:
echo ========================================
echo.
echo 1. Tutup server yang sedang running (Ctrl+C)
echo 2. Jalankan ALLOW-FIREWALL.bat sebagai Administrator
echo 3. Jalankan START-HERE.bat, pilih [L] untuk LAN server
echo 4. Dari device lain, buka: http://[IP_ADDRESS]:8000
echo.
pause
