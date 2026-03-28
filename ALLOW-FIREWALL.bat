@echo off
color 0C
title Allow Firewall - Port 8000

cls
echo ========================================
echo   ALLOW FIREWALL - PORT 8000
echo ========================================
echo.
echo This script will add firewall rule to
echo allow incoming connections on port 8000
echo.
echo IMPORTANT: Run as Administrator!
echo Right-click this file and select
echo "Run as administrator"
echo.
pause

echo.
echo Adding firewall rule...
echo.

netsh advfirewall firewall add rule name="Laravel Server Port 8000" dir=in action=allow protocol=TCP localport=8000

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo SUCCESS!
    echo ========================================
    echo.
    echo Firewall rule added successfully.
    echo Port 8000 is now allowed.
    echo.
    echo You can now access the server from
    echo other devices on the same network.
    echo.
) else (
    echo.
    echo ========================================
    echo FAILED!
    echo ========================================
    echo.
    echo Failed to add firewall rule.
    echo.
    echo Please:
    echo 1. Run this script as Administrator
    echo 2. Or manually add firewall rule:
    echo    - Open Windows Firewall
    echo    - Add Inbound Rule
    echo    - Port: 8000
    echo    - Protocol: TCP
    echo    - Allow connection
    echo.
)

pause
