@echo off
title Reset WA Session
echo ========================================
echo   RESET SESI WHATSAPP
echo ========================================
echo.
echo [PERINGATAN] Ini akan menghapus sesi WA yang tersimpan.
echo Kamu perlu scan QR ulang setelah ini.
echo.
set /p confirm=Lanjutkan? (y/n): 
if /i "%confirm%" neq "y" (
    echo Dibatalkan.
    pause
    exit /b 0
)

echo.
echo [1/3] Matikan proses Node.js di port 3000...
for /f "tokens=5" %%a in ('netstat -aon ^| findstr ":3000 " 2^>nul') do (
    taskkill /F /PID %%a >nul 2>&1
)
timeout /t 2 /nobreak >nul

echo [2/3] Hapus folder auth_info...
if exist "%~dp0wa-server\auth_info" (
    rmdir /s /q "%~dp0wa-server\auth_info"
    echo      Folder auth_info dihapus.
) else (
    echo      Folder auth_info tidak ditemukan, skip.
)

echo [3/3] Selesai!
echo.
echo Sekarang jalankan START-WA-SERVER.bat dan scan QR ulang.
echo.
pause
