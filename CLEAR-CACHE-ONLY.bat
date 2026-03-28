@echo off
color 0E
title Clear Cache Only

cls
echo ========================================
echo   CLEAR CACHE ONLY
echo ========================================
echo.

echo Clearing all caches...
echo.

echo [1/4] Config cache...
php artisan config:clear

echo [2/4] Application cache...
php artisan cache:clear

echo [3/4] View cache...
php artisan view:clear

echo [4/4] Route cache...
php artisan route:clear

echo.
echo ========================================
echo DONE!
echo ========================================
echo.
echo All caches cleared successfully.
echo.
echo Next steps:
echo - Restart your server if it's running
echo - Or run: QUICK-RESTART.bat
echo.
pause
