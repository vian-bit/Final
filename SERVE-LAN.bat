@echo off
chcp 65001 >nul
color 0B
title Server LAN - Accessible from Other Devices

cls
echo ========================================
echo   SERVER LAN ACCESS
echo   Hotel Attendance System
echo ========================================
echo.

REM Kill any existing PHP server
echo Stopping any existing server...
taskkill /F /IM php.exe >nul 2>&1
timeout /t 2 /nobreak >nul

echo.
echo Getting your IP address...
echo.

setlocal enabledelayedexpansion
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /c:"IPv4" ^| findstr /v "169.254"') do (
    set IP=%%a
    set IP=!IP:~1!
    echo Your IP Address: !IP!
    goto :found
)

:found
echo.
echo ========================================
echo   ACCESS INFORMATION
echo ========================================
echo.
echo From THIS computer:
echo   http://localhost:8000
echo   http://127.0.0.1:8000
echo.
echo From OTHER devices (same network):
echo   http://!IP!:8000
echo.
echo ========================================
echo.
echo INSTRUCTIONS FOR OTHER DEVICES:
echo.
echo 1. Make sure device is on same WiFi/Network
echo 2. Open browser on that device
echo 3. Type: http://!IP!:8000
echo 4. Login with demo account
echo.
echo ========================================
echo.
echo IMPORTANT:
echo - Make sure ALLOW-FIREWALL.bat has been run as Admin
echo - Make sure Laragon is running (MySQL must be active)
echo.
echo ========================================
echo.
echo Starting server...
echo Server will be accessible from all devices
echo Press Ctrl+C to stop
echo.

timeout /t 3 /nobreak > nul

REM Check if PHP exists
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo.
    echo ERROR: PHP not found!
    echo Make sure Laragon is running and PHP is in PATH
    echo.
    pause
    exit /b 1
)

REM Start browser
start http://localhost:8000

REM Start server
echo.
echo ========================================
echo SERVER RUNNING
echo ========================================
echo.
php artisan serve --host=0.0.0.0 --port=8000
