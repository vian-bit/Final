@echo off
chcp 65001 >nul
color 0A
title Test Koneksi Database

echo ========================================
echo TEST KONEKSI DATABASE
echo ========================================
echo.
echo Mengecek koneksi ke MySQL...
echo.

php artisan tinker --execute="echo 'Database: ' . config('database.connections.mysql.database'); echo PHP_EOL; echo 'Host: ' . config('database.connections.mysql.host'); echo PHP_EOL; echo 'Port: ' . config('database.connections.mysql.port'); echo PHP_EOL; try { DB::connection()->getPdo(); echo 'Status: CONNECTED ✓'; } catch (Exception $e) { echo 'Status: ERROR ✗'; echo PHP_EOL; echo 'Error: ' . $e->getMessage(); }"

echo.
echo ========================================
echo.
echo Jika masih error, coba:
echo 1. Restart Laragon (Stop All, lalu Start All)
echo 2. Tunggu 10-15 detik
echo 3. Jalankan script ini lagi
echo.
pause
