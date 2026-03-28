@echo off
title Hotel Attendance - WA Server
echo ========================================
echo   HOTEL ATTENDANCE - WA SERVER
echo ========================================
echo.

:: Cek apakah Node.js ada
where node >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Node.js tidak ditemukan!
    echo Install Node.js dari https://nodejs.org
    pause
    exit /b 1
)

:: Masuk ke folder wa-server
cd /d "%~dp0wa-server"

:: Cek apakah node_modules ada
if not exist "node_modules" (
    echo [1/3] Install dependencies...
    call npm install
    if %errorlevel% neq 0 (
        echo [ERROR] npm install gagal!
        pause
        exit /b 1
    )
)

:: Kill proses lama di port 3000
echo [INFO] Membersihkan proses lama di port 3000...
for /f "tokens=5" %%a in ('netstat -aon ^| findstr ":3000 " 2^>nul') do (
    taskkill /F /PID %%a >nul 2>&1
)
timeout /t 1 /nobreak >nul

echo [INFO] Menjalankan WA Server...
echo.
echo Buka browser: http://localhost:3000/qr
echo Tekan Ctrl+C untuk berhenti
echo.

node index.js

echo.
echo [INFO] Server berhenti.
pause
