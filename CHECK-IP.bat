@echo off
color 0E
title Check IP Address

cls
echo ========================================
echo   CHECK IP ADDRESS
echo ========================================
echo.

echo Your Network Information:
echo.

ipconfig | findstr /c:"IPv4" /c:"Subnet" /c:"Default Gateway"

echo.
echo ========================================
echo.

for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /c:"IPv4"') do (
    set IP=%%a
    goto :found
)

:found
set IP=%IP:~1%

echo Your Main IP Address: %IP%
echo.
echo To access from other devices:
echo   http://%IP%:8000
echo.
echo Make sure:
echo 1. Server is running (use SERVE-LAN.bat)
echo 2. Firewall allows port 8000
echo 3. Devices are on same network
echo.
pause
