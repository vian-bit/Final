@echo off
color 0B
title Quick Restart Server

cls
echo ========================================
echo   QUICK RESTART SERVER
echo ========================================
echo.
echo Fast restart without cache clearing
echo Use this for quick testing
echo.

echo Starting server...
echo.
echo Server: http://localhost:8000
echo Press Ctrl+C to stop
echo.
timeout /t 1 /nobreak > nul
start http://localhost:8000
php artisan serve
