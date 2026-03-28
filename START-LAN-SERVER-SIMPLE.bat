@echo off
chcp 65001 >nul
color 0B
title LAN Server - Simple Version

echo ========================================
echo STARTING LAN SERVER
echo ========================================
echo.

REM Kill existing PHP processes
taskkill /F /IM php.exe >nul 2>&1
timeout /t 1 /nobreak >nul

REM Get IP
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /c:"IPv4" ^| findstr /v "169.254"') do (
    set IP=%%a
    set IP=!IP:~1!
)

echo Your IP: %IP%
echo.
echo Access from other devices:
echo http://%IP%:8000
echo.
echo Starting server...
echo.

REM Start server
php artisan serve --host=0.0.0.0 --port=8000

pause
