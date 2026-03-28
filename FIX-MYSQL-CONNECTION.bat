@echo off
chcp 65001 >nul
color 0A
title Fix MySQL Connection Error

echo ========================================
echo FIX MYSQL CONNECTION ERROR
echo ========================================
echo.
echo This error occurs when MySQL is not running.
echo.
echo SOLUTION:
echo 1. Open Laragon
echo 2. Click "Start All" button
echo 3. Wait until MySQL status shows "Running"
echo 4. Then restart this server
echo.
echo ========================================
echo CHECKING MYSQL STATUS...
echo ========================================
echo.

REM Check if MySQL is running
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✓ MySQL is RUNNING
    echo.
    echo If you still get errors, try:
    echo 1. Stop Laragon
    echo 2. Start Laragon again
    echo 3. Wait 10 seconds
    echo 4. Run this server again
) else (
    echo ✗ MySQL is NOT RUNNING
    echo.
    echo PLEASE:
    echo 1. Open Laragon
    echo 2. Click "Start All"
    echo 3. Wait until all services are green
    echo 4. Then run START-HERE.bat again
)

echo.
echo ========================================
pause
