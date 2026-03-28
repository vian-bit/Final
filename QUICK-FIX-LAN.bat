@echo off
chcp 65001 >nul
color 0C
title Quick Fix LAN Access

echo ========================================
echo QUICK FIX - LAN ACCESS
echo ========================================
echo.
echo Script ini akan memperbaiki masalah LAN access
echo.
pause

echo.
echo [1/3] Stopping server jika ada...
taskkill /F /IM php.exe >nul 2>&1
timeout /t 2 /nobreak >nul

echo.
echo [2/3] Checking firewall rule...
netsh advfirewall firewall show rule name="Laravel Port 8000" >nul 2>&1
if %errorlevel% equ 0 (
    echo ✓ Firewall rule sudah ada
) else (
    echo ✗ Firewall rule belum ada
    echo.
    echo PENTING: Anda harus jalankan ALLOW-FIREWALL.bat
    echo sebagai Administrator untuk membuat firewall rule!
    echo.
    echo Cara:
    echo 1. Klik kanan ALLOW-FIREWALL.bat
    echo 2. Pilih "Run as administrator"
    echo 3. Klik Yes pada UAC prompt
    echo.
    pause
)

echo.
echo [3/3] Getting your IP address...
echo.
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /c:"IPv4" ^| findstr /v "169.254"') do (
    set IP=%%a
    set IP=!IP:~1!
    echo Your IP Address: !IP!
    echo.
    echo Dari device lain, akses:
    echo http://!IP!:8000
)

echo.
echo ========================================
echo NEXT STEPS:
echo ========================================
echo.
echo 1. Jika firewall rule belum ada, jalankan ALLOW-FIREWALL.bat as Admin
echo 2. Jalankan START-HERE.bat
echo 3. Pilih [L] untuk start LAN server
echo 4. Dari device lain, buka URL di atas
echo.
pause
