@echo off
title Clear WA Sessions
echo ========================================
echo   HAPUS SESSION FILES (tanpa scan QR ulang)
echo ========================================
echo.
echo Menghapus session files lama...

for /f "tokens=5" %%a in ('netstat -aon ^| findstr ":3000 " 2^>nul') do (
    taskkill /F /PID %%a >nul 2>&1
)
timeout /t 1 /nobreak >nul

del /q "%~dp0wa-server\auth_info\session-*.json" 2>nul
echo Selesai! Session files dihapus.
echo creds.json tetap aman - tidak perlu scan QR ulang.
echo.
echo Jalankan START-WA-SERVER.bat untuk melanjutkan.
pause
