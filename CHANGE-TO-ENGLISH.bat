@echo off
color 0A
title Change Language to English

cls
echo ========================================
echo   CHANGE LANGUAGE TO ENGLISH
echo ========================================
echo.
echo This script will change all interface
echo language from Indonesian to English.
echo.
echo Files that will be updated:
echo - All view files (.blade.php)
echo - Controller messages
echo - Validation messages
echo - .env configuration
echo.
pause

echo.
echo [1/3] Updating configuration...
php artisan config:clear

echo.
echo [2/3] Clearing cache...
php artisan cache:clear
php artisan view:clear

echo.
echo [3/3] Restarting server...
echo.
echo ========================================
echo COMPLETED!
echo ========================================
echo.
echo Language has been changed to English.
echo.
echo Please restart the server:
echo 1. Press Ctrl+C to stop current server
echo 2. Run: 3-serve.bat
echo 3. Or run: UPDATE-DAN-RESTART.bat
echo.
pause
