@echo off
chcp 65001 >nul
color 0A
title FIX: MySQL Not Running

echo ========================================
echo FIX MYSQL NOT RUNNING
echo ========================================
echo.
echo This error occurs when MySQL in Laragon is not running.
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
netstat -ano | findstr ":3306" >nul
if %errorlevel% equ 0 (
    echo ✓ MySQL is RUNNING on port 3306
    echo.
    echo If you still get errors, try:
    echo 1. Stop Laragon completely
    echo 2. Start Laragon again
    echo 3. Wait 10 seconds
    echo 4. Run this server again
) else (
    echo ✗ MySQL is NOT RUNNING!
    echo.
    echo PLEASE DO THIS:
    echo 1. Open Laragon application
    echo 2. Click "Start All" button
    echo 3. Wait until all services are green
    echo 4. Then run START-HERE.bat again
)

echo.
echo ========================================
pause
